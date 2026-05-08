<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Budget;

class TransactionController extends Controller
{
    //

    // app/Http/Controllers/TransactionController.php

    public function index()
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $tahapan = session('active_stage_id');

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        $budgetData = \App\Models\Budget::with(['account', 'subActivity'])
            ->where('tahun', $tahun)
            ->where('stage_id', $tahapan)
            ->get()
            ->sortBy('subActivity.kode_sub_kegiatan') // Urutkan berdasarkan nama sub kegiatan
            ->map(function ($b) {
                return [
                    'id' => $b->account_id,
                    'sub_activity_id' => $b->sub_activity_id,
                    'kelompok' => 'belanja',
                    'kode' => $b->subActivity->kode_sub_kegiatan,
                    'display' => $b->subActivity->nama_sub_kegiatan . " - " . $b->account->nama_rekening
                ];
            });
        // 2. Ambil Rekening Non-Belanja (Pajak, Kas, Panjar)
        $nonBudgetData = \App\Models\Account::whereIn('kelompok', ['non sub-kegiatan'])
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'sub_activity_id' => null, // Non-belanja tidak ada sub-kegiatan
                    'kelompok' => 'Non-Belanja',
                    'kode' => $a->kode_rekening,
                    'display' => $a->nama_rekening
                ];
            });

        // 3. Gabungkan keduanya
        // $allOptions = $budgetData->concat($nonBudgetData);
        $allOptions = $budgetData->merge($nonBudgetData); // Gunakan merge untuk menggabungkan koleksi

        return view('transactions.index', compact('transactions', 'tahun', 'allOptions', 'nonBudgetData'));
    }

    public function add()
    {
        $tahun = session('tahun_anggaran');
        $tahapan = session('active_stage_id');

        $budgetData = \App\Models\Budget::with(['account', 'subActivity'])
            ->where('tahun', $tahun)
            ->where('stage_id', $tahapan)
            ->get()
            ->sortBy('subActivity.kode_sub_kegiatan') // Urutkan berdasarkan nama sub kegiatan
            ->map(function ($b) {
                return [
                    'id' => $b->account_id,
                    'sub_activity_id' => $b->sub_activity_id,
                    'kelompok' => 'belanja',
                    'kode' => $b->subActivity->kode_sub_kegiatan,
                    'display' => $b->subActivity->nama_sub_kegiatan . " - " . $b->account->nama_rekening
                ];
            });
        // 2. Ambil Rekening Non-Belanja (Pajak, Kas, Panjar)
        $nonBudgetData = \App\Models\Account::whereIn('kelompok', ['non sub-kegiatan'])
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'sub_activity_id' => null, // Non-belanja tidak ada sub-kegiatan
                    'kelompok' => 'Non-Belanja',
                    'kode' => $a->kode_rekening,
                    'display' => $a->nama_rekening
                ];
            });

        // 3. Gabungkan keduanya
        // $allOptions = $budgetData->concat($nonBudgetData);
        $allOptions = $budgetData->merge($nonBudgetData); // Gunakan merge untuk menggabungkan koleksi

        // dd($allOptions->all());

        return view('transactions.create', compact('allOptions', 'nonBudgetData'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal'           => 'required|date',
            'nobukti'           => 'required|string|max:50',
            'keterangan'        => 'required|string',
            'debit_account_id'  => 'required|exists:accounts,id',
            'kredit_account_id' => 'required|required|exists:accounts,id',
            'amount'            => 'required|numeric|min:1', // Minimal 1 rupiah
            'sub_activity_id'   => 'nullable|exists:sub_activities,id',
        ], [
            'debit_account_id.required'  => 'Rekening debit harus dipilih.',
            'kredit_account_id.required' => 'Rekening kredit harus dipilih.',
            'amount.min'                 => 'Jumlah nominal tidak boleh nol.',
        ]);

        // 2. VALIDASI TAMBAHAN: Akun Debit & Kredit tidak boleh sama
        if ($request->debit_account_id == $request->kredit_account_id) {
            return back()->withInput()->with('error', 'Akun Debit dan Kredit tidak boleh sama!');
        }

        // 3. CEK PAGU (Hanya jika ada Sub Kegiatan / Transaksi Belanja)
        if ($request->sub_activity_id) {

            // Cari Pagu di DPA
            $pagu = \App\Models\Budget::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_id', $request->debit_account_id)
                ->first();

            if (!$pagu) {
                return back()->withInput()->with('error', 'Rekening ini tidak memiliki anggaran (Pagu) di DPA untuk sub kegiatan terpilih!');
            }

            // Hitung total realisasi (Sisi Debit)
            $totalRealisasi = \App\Models\Transaction::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_debit', $request->debit_account_id) // Pastikan kolom di DB sesuai
                ->sum('jumlah');

            $sisaPagu = $pagu->nominal - $totalRealisasi;

            if ($request->amount > $sisaPagu) {
                $formattedSisa = number_format($sisaPagu, 0, ',', '.');
                return back()->withInput()->with('error', "Anggaran melampaui sisa pagu! Sisa pagu: Rp $formattedSisa.");
            }
        }

        try {
            // 4. Proses Simpan
            \App\Models\Transaction::create([
                'pkjur'           => 'B' . date('ymdHis') . rand(10, 99), // Tambah random biar gak bentrok jika input cepat
                'tanggal'         => $request->tanggal,
                'nobukti'         => $request->nobukti,
                'keterangan'      => $request->keterangan,
                'account_debit'   => $request->debit_account_id,
                'account_kredit'  => $request->kredit_account_id,
                'sub_activity_id' => $request->sub_activity_id,
                'jumlah'          => $request->amount,
            ]);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi No. Bukti ' . $request->nobukti . ' berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('transactions.index')
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    // public function edit($id)
    // {
    //     $transaction = Transaction::findOrFail($id);
    //     $tahun = session('tahun_anggaran');
    //     $tahapan = session('active_stage_id');

    //     

    //     // Cari display untuk Debit
    //     $selectedDebit = $allOptions->first(function ($item) use ($transaction) {
    //         return $item['id'] == $transaction->account_debit && $item['sub_activity_id'] == $transaction->sub_activity_id;
    //     });

    //     // Cari display untuk Kredit
    //     $selectedKredit = $nonBudgetData->firstWhere('id', $transaction->account_kredit);

    //     return view('transactions.edit', compact('transaction', 'allOptions', 'selectedDebit', 'selectedKredit'));
    // }

    public function update(Request $request, $id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);

        // (Gunakan validasi yang sama dengan Store...)

        if ($request->sub_activity_id) {
            $pagu = \App\Models\Budget::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_id', $request->debit_account_id)
                ->first();

            // Hitung realisasi transaksi LAIN (kecuali transaksi yang sedang diedit ini)
            $realisasiLain = \App\Models\Transaction::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_debit', $request->debit_account_id)
                ->where('id', '!=', $id) // ABAIKAN TRANSAKSI INI
                ->sum('jumlah');

            $sisaPaguTersedia = $pagu->nominal - $realisasiLain;

            if ($request->amount > $sisaPaguTersedia) {
                return back()->withInput()->with('error', "Update Gagal! Total belanja melebihi sisa pagu.");
            }
        }

        $transaction->update([
            'tanggal'         => $request->tanggal,
            'nobukti'         => $request->nobukti,
            'keterangan'      => $request->keterangan,
            'account_debit'   => $request->debit_account_id,
            'account_kredit'  => $request->kredit_account_id,
            'sub_activity_id' => $request->sub_activity_id,
            'jumlah'          => $request->amount,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
}
