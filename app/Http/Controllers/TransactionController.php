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
        $nonBudgetData = \App\Models\Account::whereIn('kelompok', ['pajak', 'kas', 'panjar'])
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
    $request->validate([
        'batch_id' => 'required',
        'type' => 'required',
        'date' => 'required|date',
        'evidence_number' => 'required',
        'description' => 'required',
        'account_id' => 'required',      // ID Rekening yang didebit
        'cash_account_id' => 'required', // ID Rekening yang dikredit
        'amount' => 'required|numeric|min:1',
    ]);

    // 2. Simpan Transaksi dengan Database Transaction (Double Entry)
    \DB::transaction(function () use ($request) {
        
        // BARIS DEBIT (Misal: Belanja ATK / Panjar)
        \App\Models\Transaction::create([
            'batch_id' => $request->batch_id,
            'type' => $request->type,
            'date' => $request->date,
            'evidence_number' => $request->evidence_number,
            'description' => $request->description,
            'account_id' => $request->account_id,
            'sub_activity_id' => $request->sub_activity_id, // Terisi jika belanja, NULL jika bukan
            'debit' => $request->amount,
            'credit' => 0,
        ]);

        // BARIS KREDIT (Misal: Kas Tunai / Bank)
        \App\Models\Transaction::create([
            'batch_id' => $request->batch_id,
            'type' => $request->type,
            'date' => $request->date,
            'evidence_number' => $request->evidence_number,
            'description' => $request->description,
            'account_id' => $request->cash_account_id,
            'sub_activity_id' => null, // Sisi Kas tidak pakai sub kegiatan
            'debit' => 0,
            'credit' => $request->amount,
        ]);
    });

    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
}
}
