<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //

    // app/Http/Controllers/TransactionController.php

    public function index()
    {
        $tahun = session('tahun_anggaran');

        $transactions = Transaction::with(['account', 'subActivity'])
            ->whereYear('date', $tahun)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions', 'tahun'));
    }

    public function add()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'sub_activity_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'description' => 'required',
            'evidence_number' => 'required',
        ]);

        $batchId = Str::uuid(); // Generate batch_id unik untuk setiap transaksi baru

        //input debit
        Transasction::create([
            'batch_id' => $batchId,
            'date' => $request->date,
            'description' => $request->description,
            'account_id' => $request->account_id,
            'sub_activity_id' => $request->sub_activity_id,
            'debit' => $request->amount,
            'credit' => 0,
            'evidence_number' => $request->evidence_number
        ]);

        //input kredit (jika ada)
        Transaction::create([
            'batch_id' => $batchId,
            'date' => $request->date,
            'description' => $request->description,
            'account_id' => $request->account_id, // Ganti dengan akun lawan jika diperlukan
            'sub_activity_id' => $request->sub_activity_id, // Ganti dengan sub kegiatan lawan jika diperlukan
            'debit' => 0,
            'credit' => $request->amount,
            'evidence_number' => $request->evidence_number
        ]); 

        return back()->with('success', 'Transaksi berhasil disimpan!');
        
    }
}
