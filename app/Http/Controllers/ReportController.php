<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Account;

class ReportController extends Controller
{
    public function journalIndex(Request $request)
    {
        $tahunAnggaran = session('tahun_anggaran', date('Y'));

        $start = $request->get('start_date', date('Y-m-01'));
        $end = $request->get('end_date', $tahunAnggaran.'-12-31'); //

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
        $accounts = Account::orderBy('kode_rekening', 'asc')->where('tahun', $tahun)->get();

        $selectedAccount = $request->get('account_id');
        $start = $request->get('start_date', $tahun.'-01-01');
        $end = $request->get('end_date', $tahun.'-12-31');

        $mutations = [];
        $saldoAwal = 0;

        if($selectedAccount) {
            // hitung saldo awal
            $debitAwal = Transaction::where('account_debit', $selectedAccount)
                ->where('tanggal', '<', $start)
                ->sum('jumlah');
        
            $kreditAwal = Transaction::where('account_kredit', $selectedAccount)
                ->where('tanggal', '<', $start)
                ->sum('jumlah');

            $saldoAwal = $debitAwal - $kreditAwal;
        }

        //ambil mutasi transaksi untuk akun yang dipilih
        $mutations = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
        ->where(function($query) use ($selectedAccount) {
            $query->where('account_debit', $selectedAccount)
                  ->orWhere('account_kredit', $selectedAccount);
        })
        ->whereBetween('tanggal', [$start, $end])
        ->orderBy('tanggal', 'asc')
        ->orderBy('pkjur', 'asc')
        ->get();


        return view('reports.ledger_index', compact('accounts', 'selectedAccount', 'start', 'end', 'mutations', 'saldoAwal'));
    }
}
