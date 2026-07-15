<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    //

    public function index()
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $accounts = Account::where('tahun', $tahun)
            ->withCount(['transactionsAsDebit', 'transactionsAsKredit'])
            ->orderBy('kode_rekening')
            ->get();
        return view('accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $request->validate([
            'kode_rekening' => [
                'required',
                Rule::unique('accounts')->where(fn($q) => $q->where('tahun', $tahun)),
            ],
            'nama_rekening' => 'required',
            'kelompok'      => 'required',
        ], [
            'kode_rekening.unique' => 'Kode Rekening sudah ada di tahun anggaran ini.',
        ]);
        $request->merge(['tahun' => $tahun]);
        Account::create($request->all());
        return redirect()->back()->with('success', 'Rekening berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $request->validate([
            'kode_rekening' => [
                'required',
                Rule::unique('accounts')->where(fn($q) => $q->where('tahun', $tahun))->ignore($id),
            ],
            'nama_rekening' => 'required',
            'kelompok'      => 'required',
        ], [
            'kode_rekening.unique' => 'Kode Rekening Sudah Ada di tahun anggaran ini.',
        ]);

        $account = Account::findOrFail($id);
        $account->update($request->all());
        return back()->with('success', 'Rekening berhasil diubah');
    }

    public function delete($id)
    {
        $account = Account::findOrFail($id);
        $account->delete($id);

        return back()->with('success', 'Akun berhasil dihapus');
    }
}
