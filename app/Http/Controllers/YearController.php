<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Stage;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
{
    /**
     * Tampilkan halaman manajemen tahun anggaran.
     * Hanya bisa diakses oleh admin.
     */
    public function index()
    {
        // Ambil semua tahun beserta jumlah program dan stage-nya
        $years = Year::withCount([
                'programs',
                'stages',
            ])
            ->orderByDesc('tahun')
            ->get();

        return view('years.index', compact('years'));
    }

    /**
     * Buat tahun anggaran baru.
     * - Menduplikasi Program, Kegiatan, Sub-Kegiatan, dan Rekening Belanja dari tahun terbaru.
     * - Membuat Stage awal "APBD Murni" (pagu 0 = tidak ada Budget yang disalin).
     * - Budget (pagu anggaran) TIDAK disalin — harus diisi ulang lewat menu DPA.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
                'unique:years,tahun',
            ],
        ], [
            'tahun.unique'    => 'Tahun anggaran tersebut sudah terdaftar.',
            'tahun.required'  => 'Tahun anggaran wajib diisi.',
            'tahun.integer'   => 'Tahun harus berupa angka.',
            'tahun.min'       => 'Tahun anggaran tidak valid.',
            'tahun.max'       => 'Tahun anggaran tidak valid.',
        ]);

        $tahunBaru = (int) $request->tahun;

        // Cari tahun terbaru yang sudah ada sebagai sumber duplikasi
        $tahunSumber = Year::orderByDesc('tahun')->value('tahun');

        if (!$tahunSumber) {
            return back()->with('error', 'Tidak ada tahun anggaran sumber untuk diduplikasi. Pastikan minimal ada 1 tahun anggaran yang sudah memiliki data.');
        }

        DB::transaction(function () use ($tahunBaru, $tahunSumber) {

            // -------------------------------------------------------------
            // 1. Buat record tahun baru di tabel years
            // -------------------------------------------------------------
            Year::create([
                'tahun'     => $tahunBaru,
                'is_active' => true,
            ]);

            // -------------------------------------------------------------
            // 2. Duplikasi Program ? Kegiatan ? Sub-Kegiatan
            //    Mapping ID lama ke ID baru diperlukan untuk menjaga relasi.
            // -------------------------------------------------------------
            $programSumber = Program::with('activities.subActivities')
                ->where('tahun', $tahunSumber)
                ->get();

            foreach ($programSumber as $programLama) {
                // Buat Program baru
                $programBaru = Program::create([
                    'kode_program' => $programLama->kode_program,
                    'nama_program' => $programLama->nama_program,
                    'tahun'        => $tahunBaru,
                ]);

                foreach ($programLama->activities as $activityLama) {
                    // Buat Kegiatan baru (terkait ke Program baru)
                    $activityBaru = Activity::create([
                        'program_id'    => $programBaru->id,
                        'kode_kegiatan' => $activityLama->kode_kegiatan,
                        'nama_kegiatan' => $activityLama->nama_kegiatan,
                        'tahun'         => $tahunBaru,
                    ]);

                    foreach ($activityLama->subActivities as $subLama) {
                        // Buat Sub-Kegiatan baru (terkait ke Kegiatan baru)
                        SubActivity::create([
                            'activity_id'       => $activityBaru->id,
                            'kode_sub_kegiatan' => $subLama->kode_sub_kegiatan,
                            'nama_sub_kegiatan' => $subLama->nama_sub_kegiatan,
                            'tahun'             => $tahunBaru,
                        ]);
                    }
                }
            }

            // -------------------------------------------------------------
            // 3. Duplikasi Rekening Belanja (Account)
            // -------------------------------------------------------------
            $accountSumber = Account::where('tahun', $tahunSumber)->get();

            foreach ($accountSumber as $akunLama) {
                Account::create([
                    'kode_rekening' => $akunLama->kode_rekening,
                    'nama_rekening' => $akunLama->nama_rekening,
                    'kelompok'      => $akunLama->kelompok,
                    'tahun'         => $tahunBaru,
                ]);
            }

            // -------------------------------------------------------------
            // 4. Buat Stage awal "APBD Murni" untuk tahun baru
            //    Pagu = 0 karena Budget tidak disalin (harus diisi ulang).
            // -------------------------------------------------------------
            Stage::create([
                'tahun'        => $tahunBaru,
                'nama_tahapan' => 'APBD Murni',
                'urutan'       => 1,
                'is_active'    => true,
                'is_locked'    => false,
            ]);

            // -------------------------------------------------------------
            // NOTE: Budget (pagu anggaran) SENGAJA TIDAK DISALIN.
            // Admin harus mengisi pagu lewat menu DPA setelah login
            // dengan memilih tahun anggaran baru ini.
            // -------------------------------------------------------------
        });

        $jumlahProgram  = Program::where('tahun', $tahunBaru)->count();
        $jumlahAkun     = Account::where('tahun', $tahunBaru)->count();

        return back()->with(
            'success',
            "Tahun anggaran {$tahunBaru} berhasil dibuat. " .
            "Tersalin: {$jumlahProgram} program dan {$jumlahAkun} rekening. " .
            "Stage 'APBD Murni' sudah terbentuk. Pagu anggaran silakan diisi lewat menu DPA."
        );
    }
}
