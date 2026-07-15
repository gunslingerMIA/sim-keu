<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class StagesController extends Controller
{
    // Menambah tahapan baru (mis: dari "Penetapan" ke "Perubahan Sebelum Perubahan")
    // Otomatis: salin pagu dari tahapan terakhir + kunci tahapan lama
    public function store(Request $request)
    {
        $request->validate([
            'nama_tahapan' => 'required|string|max:255',
        ], [
            'nama_tahapan.required' => 'Nama tahapan belum diisi',
        ]);

        $tahun = session('tahun_anggaran', date('Y'));

        // Cari tahapan terakhir (urutan tertinggi) di tahun ini sebagai sumber salinan
        $stageLama = Stage::where('tahun', $tahun)->orderByDesc('urutan')->first();

        if (!$stageLama) {
            return back()->with('error', 'Tahun anggaran ini belum punya tahapan awal (Penetapan). Buat tahapan pertama lewat menu Tahun Anggaran terlebih dahulu.');
        }

        DB::transaction(function () use ($stageLama, $tahun, $request) {
            // 1. Buat tahapan baru, urutan lanjut dari yang terakhir
            $stageBaru = Stage::create([
                'tahun'        => $tahun,
                'nama_tahapan' => $request->nama_tahapan,
                'urutan'       => $stageLama->urutan + 1,
                'is_active'    => true,
                'is_locked'    => false,
            ]);

            // 2. Kunci tahapan lama — tidak bisa diedit lagi
            $stageLama->update([
                'is_active' => false,
                'is_locked' => true,
            ]);

            // 3. Salin semua pagu (Budget) dari tahapan lama ke tahapan baru
            //    Nominal ikut tersalin, dan boleh diubah user di tahapan baru.
            //    Pakai updateOrCreate (bukan create) supaya kalau form ini ke-submit
            //    dua kali (double click / reload), tidak menghasilkan baris dobel.
            $budgetsLama = Budget::where('stage_id', $stageLama->id)->get();
            foreach ($budgetsLama as $b) {
                Budget::updateOrCreate(
                    [
                        'sub_activity_id' => $b->sub_activity_id,
                        'account_id'      => $b->account_id,
                        'stage_id'        => $stageBaru->id,
                        'tahun'           => $b->tahun,
                    ],
                    [
                        'nominal' => $b->nominal,
                    ]
                );
            }

            // 4. Update session agar aplikasi langsung pindah ke tahapan baru
            session([
                'active_stage_id' => $stageBaru->id,
                'nama_tahapan'    => $stageBaru->nama_tahapan,
            ]);
        });

        return back()->with('success', "Tahapan '{$request->nama_tahapan}' berhasil dibuat. Pagu dari tahapan '{$stageLama->nama_tahapan}' sudah disalin, dan tahapan tersebut kini terkunci.");
    }

    // Berpindah tampilan ke tahapan tertentu (untuk melihat histori tahapan yang sudah terkunci)
    public function setActive($id)
    {
        $stage = Stage::findOrFail($id);

        session([
            'active_stage_id' => $stage->id,
            'nama_tahapan'    => $stage->nama_tahapan,
        ]);

        return back()->with('success', 'Sedang melihat tahapan: ' . $stage->nama_tahapan . ($stage->is_locked ? ' (terkunci)' : ''));
    }
}