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

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('transactions.index', compact('transactions', 'tahun'));
    }

    public function add()
    {   
        $tahun = session('tahun_anggaran');
        $tahapan = session('active_stage_id');

        $budgetData = \App\Models\Budget::with(['account', 'subActivity'])
            ->where('tahun', $tahun)
            ->where('stage_id', $tahapan)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->account_id,
                    'sub_activity_id' => $b->sub_activity_id,
                    'kelompok' => 'belanja',
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
                    'type' => $a->kelompok,
                    'display' => $a->nama_rekening
                ];
            });

        // 3. Gabungkan keduanya
        $allOptions = $budgetData->concat($nonBudgetData);
        
        return view('transactions.create', compact('allOptions', 'nonBudgetData'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        // Pastikan nama field di request sesuai dengan atribut 'name' di form HTML Bapak
        $request->validate([
            'tanggal'         => 'required|date',
            'nobukti'         => 'required|string|max:50',
            'keterangan'      => 'required|string',
            'account_id'      => 'required|exists:accounts,id', // Sisi Debit
            'cash_account_id' => 'required|exists:accounts,id', // Sisi Kredit
            'amount'          => 'required|numeric|min:0',
            'sub_activity_id' => 'nullable|exists:sub_activities,id',
        ], [
            'account_id.required' => 'Rekening debit harus dipilih.',
            'cash_account_id.required' => 'Rekening kredit (sumber dana) harus dipilih.',
            'amount.min' => 'Jumlah nominal tidak boleh nol.',
        ]);
        // HANYA CEK PAGU JIKA ADA SUB_ACTIVITY_ID (Transaksi Belanja)
        if ($request->sub_activity_id) {
            
            // 1. Cari Pagu di tabel budgets untuk rekening + sub kegiatan ini
            $pagu = \App\Models\Budget::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_id', $request->account_id)
                ->first();

            if (!$pagu) {
                return back()->withInput()->with('error', 'Rekening ini tidak terdaftar di DPA untuk sub kegiatan tersebut!');
            }

            // 2. Hitung total realisasi yang sudah ada di tabel transactions
            $totalRealisasi = \App\Models\Transaction::where('sub_activity_id', $request->sub_activity_id)
                ->where('account_debit', $request->account_id)
                ->sum('jumlah');

            // 3. Hitung Sisa Pagu
            $sisaPagu = $pagu->nominal - $totalRealisasi;

            // 4. Bandingkan dengan input baru
            if ($request->amount > $sisaPagu) {
                $formattedSisa = number_format($sisaPagu, 0, ',', '.');
                return back()->withInput()->with('error', "Anggaran jebol! Sisa pagu hanya Rp $formattedSisa. Anda mencoba menginput Rp " . number_format($request->amount, 0, ',', '.'));
            }
        }


        try {
            // 2. Proses Simpan ke Database
            \App\Models\Transaction::create([
                'pkjur'           => 'B' . date('ymdHis'), // Generate ID otomatis
                'tanggal'         => $request->tanggal,
                'nobukti'         => $request->nobukti,
                'keterangan'      => $request->keterangan,
                'account_debit'   => $request->account_id,
                'account_kredit'  => $request->cash_account_id,
                'sub_activity_id' => $request->sub_activity_id, // Nullable, otomatis terisi dari hidden input
                'jumlah'          => $request->amount,
            ]);

            // 3. Redirect dengan pesan sukses
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi No. Bukti ' . $request->nobukti . ' berhasil disimpan.');

        } catch (\Exception $e) {
            // Jika ada error database, kembali ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
