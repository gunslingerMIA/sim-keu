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
        return view('master.accounts', compact('accounts'));
    
    }

    public function store(Request $request)
    {
        dd($request->all());
        Account::create($request->all());
        return redirect()->back()->with('success', 'Akun berhasil ditambah!');

      
    }
}
