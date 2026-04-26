<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stage;

class StagesController extends Controller
{
    //
    public function setActive($id)
    {
        // 1. Matikan semua tahapan di tahun tersebut
        Stage::where('tahun', session('tahun_anggaran'))->update(['is_active' => false]);

        //2. Aktifkan tahapan yang dipilih
        $stage = Stage::findOrFail($id);
        $stage->is_active = true;

        //3. update session agar aplikasi langsung sadar
        session(['active_stage_id' => $stage->id]);
        session(['active_stage_name' => $stage->name]);

        return back()->with('success', 'Tahapan aktif berhasil diubah ke: ' . $stage->name);
    }
}
