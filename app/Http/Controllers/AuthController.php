<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Year;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|digits:18',
            'password' => 'required',
        ], [
            'nip.required' => 'NIP belum diisi',
            'nip.digits' => 'NIP harus terdiri dari 18 digit',
            'password.required' => 'Password belum diisi',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('tahun.pilih');
        }

        return back()->withErrors(['nip' => 'NIP atau password salah'])->withInput();
    }

    public function pilihTahun()
    {
        $years = Year::orderBy('tahun', 'desc')->get();
        return view('auth.pilih-tahun', compact('years'));
    }

    public function simpanTahun(Request $request)
    {
        $request->validate([
            'tahun' => 'required|exists:years,tahun',
        ], [
            'tahun.required' => 'Tahun belum dipilih',
            'tahun.exists' => 'Tahun tidak valid',
        ]);
        session(['tahun_anggaran' => $request->tahun]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
