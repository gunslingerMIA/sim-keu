<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    // app/Http/Controllers/TransactionController.php

    public function create()
    {
        // Mengambil data untuk dropdown
        $programs = \App\Models\Program::all();
        
        // Akun debet (Belanja & Panjar)
        $accounts = \App\Models\Account::whereIn('type', ['belanja', 'panjar'])->get();
        
        // Akun kredit (Kas Bendahara / Bank)
        $cashAccounts = \App\Models\Account::where('type', 'kas')->get();

        return view('transactions.create', compact('programs', 'accounts', 'cashAccounts'));
    }

    public function store(Request $request) 
    {

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit_account' => 'required|exists:accounts,id',
            'credit_account' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
        ]);

        // Generate ID unik untuk kelompok transaksi ini
        $batchId = 'TRX-' . time(); 

        // 1. Catat Baris DEBIT (Akun Belanja/Panjar)
        Transaction::create([
            'batch_id' => $batchId,
            'date' => $request->date,
            'evidence_number' => $request->evidence_number,
            'description' => $request->description,
            'account_id' => $request->debit_account, // Akun yang didebet
            'sub_activity_id' => $request->sub_activity_id,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        // 2. Catat Baris KREDIT (Akun Kas/Bendahara)
        Transaction::create([
            'batch_id' => $batchId,
            'date' => $request->date,
            'evidence_number' => $request->evidence_number,
            'description' => $request->description,
            'account_id' => $request->credit_account, // Akun yang dikredit
            'sub_activity_id' => null, // Kas biasanya tidak nempel ke sub-kegiatan
            'debit' => 0,
            'credit' => $request->amount
        ]);

        return redirect()->back()->with('success', 'Transaksi Berhasil Dicatat!');
    }

   public function getActivities($programId) {
        $activities = \App\Models\Activity::where('program_id', $programId)->get();
        return response()->json($activities); // WAJIB ada response()->json()
    }

    public function getSubActivities($activityId) {
        $subActivities = \App\Models\SubActivity::where('activity_id', $activityId)->get();
        return response()->json($subActivities);
    }
}
