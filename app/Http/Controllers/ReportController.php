<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;

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
}
