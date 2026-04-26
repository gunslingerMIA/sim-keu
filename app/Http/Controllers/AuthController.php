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

        // 2. CARI TAHAPAN AKTIF DI TAHUN TERSEBUT
        // Kita cari yang is_active-nya true khusus untuk tahun yang dipilih
        $activeStage = \App\Models\Stage::where('tahun', $request->tahun)
                                        ->where('is_active', true)
                                        ->first();
        if ($activeStage) {
            session([
                'active_stage_id' => $activeStage->id,
                'nama_tahapan'    => $activeStage->nama_tahapan,
            ]);
        } else {
            // Opsi jika belum ada tahapan yang diaktifkan admin
            session()->forget(['active_stage_id', 'nama_tahapan']);
        }

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
