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
            'nip' => [
                'required',
                'unique:users,nip',
                'digits:18',
            ],
            'jabatan' => 'required',
            'role' => 'required'
        ],
        [
            'nip.unique' => 'NIP sudah digunakan',
            'nip.required' => 'NIP belum diisi',
            'nip.digits' => 'NIP harus terdiri dari 18 digit',
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

        // Gunakan redirect ke route index kamu
        return back()->with('success', "Berhasil menambah user");
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User ' . $user->name . ' berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required',
            'nip' => [
                'required',
                'digits:18',
                'unique:users,nip,' . $user->id, // Pastikan NIP unik kecuali untuk user yang sedang diupdate
            ],
            'jabatan' => 'required',
            'role' => 'required'
        ],
        [
            'nip.unique' => 'NIP sudah digunakan',
            'nip.required' => 'NIP belum diisi',
            'nip.digits' => 'NIP harus terdiri dari 18 digit',
            'nama_user.required' => 'Nama Belum Diisi',
            'jabatan.required' => 'jabatan Belum Diisi',
            'role.required' => 'Role Belum Diisi',
        ]);

        $user->update([
            'name' => $request->nama_user,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'role' => $request->role
        ]);

        return back()->with('success', "Berhasil mengupdate user");
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('dpmptsp')
        ]);

        return back()->with('success', 'Password Berhasil Direset');
    }
}
