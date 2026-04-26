<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    //

    public function index()
    {
        $accounts = Account::orderBy('kode_rekening')->get();
        return view('accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rekening' => 'required|unique:accounts,kode_rekening',
            'nama_rekening' => 'required',
            'kelompok' => 'required'
        ]);
        $request->merge(['tahun' => session('tahun_anggaran', date('Y'))]);
        Account::create($request->all());
        return redirect()->back()->with('success', 'Rekening berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_rekening' => 'required|unique:accounts,kode_rekening,'.$id,
            'nama_rekening' => 'required',
            'kelompok' => 'required'
        ],
        [
            'kode_rekening.unique' => 'Kode Rekening Sudah Ada'
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
