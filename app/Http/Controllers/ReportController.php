<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Account;
use App\Exports\LedgerExport;

class ReportController extends Controller
{
    public function journalIndex(Request $request)
    {
        $tahunAnggaran = session('tahun_anggaran', date('Y'));

        $start = $request->get('start_date', date('Y-m-01'));
        $end = $request->get('end_date', $tahunAnggaran . '-12-31'); //

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();
        // Logika untuk menampilkan halaman laporan jurnal transaksi
        return view('reports.journal_index', compact('transactions', 'start', 'end'));
    }
    //

    public function journalExport(Request $request)
    {
        $start = $request->get('start_date');
        $end = $request->get('end_date'); //

        $transactions = Transaction::with(['debitAccount', 'kreditAccount'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();

        return Excel::download(new JournalExport($transactions), "Jurnal_Transaksi_{$start}_to_{$end}.xlsx");
    }

    public function ledgerIndex(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Ambil data untuk Pilihan Modal Search (Tetap seperti kode Abang)
        $budgetData = \App\Models\Budget::with(['account', 'subActivity'])
            ->where('tahun', $tahun)
            ->get()
            ->sortBy('subActivity.kode_sub_kegiatan')
            ->map(function ($b) {
                return [
                    'id' => $b->account_id,
                    'sub_activity_id' => $b->sub_activity_id,
                    'kelompok' => 'belanja',
                    'kode' => $b->subActivity->kode_sub_kegiatan,
                    'display' => $b->subActivity->nama_sub_kegiatan . " - " . $b->account->nama_rekening
                ];
            });

        $nonBudgetData = \App\Models\Account::whereIn('kelompok', ['non sub-kegiatan'])
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'sub_activity_id' => null,
                    'kelompok' => 'Non-Belanja',
                    'kode' => $a->kode_rekening,
                    'display' => $a->nama_rekening
                ];
            });

        $allOptions = $budgetData->merge($nonBudgetData);

        // 2. Tangkap Request Filter
        $selectedAccount = $request->get('account_id');
        $selectedSubActivityId = $request->get('sub_activity_id');
        $start = $request->get('start_date', $tahun . '-01-01');
        $end = $request->get('end_date', $tahun . '-12-31');

        $mutations = [];
        $saldoAwal = 0;

        // Semua proses query harus masuk ke dalam check ini
        if ($selectedAccount) {

            // --- PROSES 1: HITUNG SALDO AWAL (Gunakan kolom 'jumlah') ---
            $debitAwalQuery = Transaction::where('account_debit', $selectedAccount)->where('tanggal', '<', $start);
            $kreditAwalQuery = Transaction::where('account_kredit', $selectedAccount)->where('tanggal', '<', $start);

            if ($selectedSubActivityId) {
                $debitAwalQuery->where('sub_activity_id', $selectedSubActivityId);
                $kreditAwalQuery->where('sub_activity_id', $selectedSubActivityId);
            } else {
                $debitAwalQuery->whereNull('sub_activity_id');
                $kreditAwalQuery->whereNull('sub_activity_id');
            }

            $debitAwal = $debitAwalQuery->sum('jumlah');
            $kreditAwal = $kreditAwalQuery->sum('jumlah');
            $saldoAwal = $debitAwal - $kreditAwal;


            // --- PROSES 2: AMBIL MUTASI TRANSAKSI ---
            $mutationsQuery = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
                ->whereBetween('tanggal', [$start, $end]);

            $mutationsQuery->where(function ($query) use ($selectedAccount, $selectedSubActivityId) {
                $query->where(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                    $q->where('account_debit', $selectedAccount);
                    if ($selectedSubActivityId) {
                        $q->where('sub_activity_id', $selectedSubActivityId);
                    } else {
                        $q->whereNull('sub_activity_id');
                    }
                })
                    ->orWhere(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                        $q->where('account_kredit', $selectedAccount);
                        if ($selectedSubActivityId) {
                            $q->where('sub_activity_id', $selectedSubActivityId);
                        }
                    });
            });

            $mutations = $mutationsQuery->orderBy('tanggal', 'asc')
                ->orderBy('pkjur', 'asc')
                ->get();
        }

        // Ambil semua data master akun untuk fallback compact (jika dibutuhkan di view)
        $accounts = \App\Models\Account::all();

        return view('reports.ledger_index', compact(
            'accounts',
            'selectedAccount',
            'selectedSubActivityId', // Bagian ini juga dikirim balik biar filter gak ke-reset
            'start',
            'end',
            'mutations',
            'saldoAwal',
            'allOptions',
            'nonBudgetData'
        ));
    }

    public function ledgerExport(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Tangkap Request Filter dari Blade
        $selectedAccount = $request->get('account_id');
        $selectedSubActivityId = $request->get('sub_activity_id');
        $start = $request->get('start_date', $tahun . '-01-01');
        $end = $request->get('end_date', $tahun . '-12-31');

        if (!$selectedAccount) {
            return redirect()->back()->with('error', 'Silakan pilih rekening terlebih dahulu.');
        }

        // 2. LOGIKA HITUNG SALDO AWAL (Langsung ditulis di sini biar anti-error)
        $debitAwalQuery = \App\Models\Transaction::where('account_debit', $selectedAccount)->where('tanggal', '<', $start);
        $kreditAwalQuery = \App\Models\Transaction::where('account_kredit', $selectedAccount)->where('tanggal', '<', $start);

        if ($selectedSubActivityId) {
            $debitAwalQuery->where('sub_activity_id', $selectedSubActivityId);
            $kreditAwalQuery->where('sub_activity_id', $selectedSubActivityId);
        } else {
            $debitAwalQuery->whereNull('sub_activity_id');
            $kreditAwalQuery->whereNull('sub_activity_id');
        }

        $saldoAwal = $debitAwalQuery->sum('jumlah') - $kreditAwalQuery->sum('jumlah');

        // 3. AMBIL DATA MUTASI TRANSAKSI PERIODE INI
        $mutationsQuery = \App\Models\Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereBetween('tanggal', [$start, $end]);

        $mutationsQuery->where(function ($query) use ($selectedAccount, $selectedSubActivityId) {
            $query->where(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                $q->where('account_debit', $selectedAccount);
                if ($selectedSubActivityId) {
                    $q->where('sub_activity_id', $selectedSubActivityId);
                } else {
                    $q->whereNull('sub_activity_id');
                }
            })
                ->orWhere(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                    $q->where('account_kredit', $selectedAccount);
                    if ($selectedSubActivityId) {
                        $q->where('sub_activity_id', $selectedSubActivityId);
                    }
                });
        });

        $mutations = $mutationsQuery->orderBy('tanggal', 'asc')
            ->orderBy('pkjur', 'asc')
            ->get();

        // 4. Tempel ID Akun terpilih ke properti sementara agar LedgerExport tahu posisi Debit/Kredit-nya
        $mutations->transform(function ($item) use ($selectedAccount) {
            $item->selected_account_id = $selectedAccount;
            return $item;
        });

        // 5. Cari Nama Rekening untuk Keperluan Judul di Atas Dokumen Excel
        $accountData = \App\Models\Account::find($selectedAccount);
        $accountName = $accountData ? $accountData->nama_rekening : 'Rekening Buku Besar';

        // Jika yang dipilih akun belanja, kombinasikan judulnya dengan nama sub-kegiatan biar informatif
        if ($selectedSubActivityId) {
            $subActivityData = \App\Models\SubActivity::find($selectedSubActivityId);
            if ($subActivityData) {
                $accountName = $subActivityData->nama_sub_kegiatan . " - " . $accountName;
            }
        }

        // 6. Jalankan Proses Download Excel
        $filename = 'Buku_Besar_' . str_replace('.', '_', $selectedAccount) . '_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LedgerExport($mutations, $saldoAwal, $start, $end, $accountName), $filename);
    }
}
