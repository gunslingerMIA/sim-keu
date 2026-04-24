<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
    
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'nama_user' => 'required',
            'nip' => 'required|unique:users,nip',
            'jabatan' => 'required',
            'role' => 'required'
        ],
        [
            'nip.unique' => 'NIP sudah digunakan',
            'nip.required' => 'NIP belum diisi',
            'nama_user.required' => 'Nama Belum Diisi',
            'jabatan.required' => 'jabatan Belum Diisi',
            'role.required' => 'Role Belum Diisi',
        ]);
       

        User::create([
            'nip' => $request->nip,
            'name' => $request->nama_user,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make('dpmptsp')
        ]);

        return back()->with('success', "Berhasil menambah user");
    }
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('dpmptsp')
        ]);

        return back()->with('success', 'Password user ' . $user->name . ' telah direset ke: dpmptsp');
    }
}
