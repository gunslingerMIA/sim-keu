<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function journalIndex(Request $request)
    {
        $start = $request->get('start_date', date('Y-m-01'));
        $end = $request->get('end_date', date('Y-m-t')); //

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();
        // Logika untuk menampilkan halaman laporan jurnal transaksi
        return view('reports.journal_index', compact('transactions', 'start', 'end'));
    }
    //
}
