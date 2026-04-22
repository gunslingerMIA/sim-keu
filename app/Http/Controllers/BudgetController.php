<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\SubActivity;
use App\Models\Account;
use App\Models\Program;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // Menampilkan daftar pagu per Sub-Kegiatan

    public function gantiTahapan(Request $request) {
        $tahapBaru = $request->tahap_baru; // Contoh: 'geser_awal'
        $tahapLama = $request->tahap_lama; // Contoh: 'murni'

        // 1. Salin semua data dari tahap lama ke tahap baru
        $dataLama = Budget::where('tahapan', $tahapLama)->get();
        foreach($dataLama as $d) {
            Budget::create([
                'sub_activity_id' => $d->sub_activity_id,
                'account_id' => $d->account_id,
                'nominal' => $d->nominal,
                'tahapan' => $tahapBaru,
                'tahun' => $d->tahun
            ]);
        }

        // 2. Update Saklar Global di AppSetting
        \App\Models\AppSetting::where('key', 'tahapan_aktif')->update([
            'value' => $tahapBaru,
            'label' => $request->label_baru
        ]);

        return back()->with('success', 'Tahapan berhasil dikunci dan lanjut ke tahap berikutnya!');
    }

   

    public function index()
    {
        // 1. Ambil tahapan aktif dari database
        $setting = \App\Models\AppSetting::where('key', 'tahapan_aktif')->first();
        $tahapanAktif = $setting ? $setting->value : 'murni';

        // 2. Gunakan 'use ($tahapanAktif)' agar variabel bisa terbaca di dalam query relasi
        $programs = \App\Models\Program::with(['activities.subActivities.budgets' => function($query) use ($tahapanAktif) {
            $query->where('tahapan', $tahapanAktif)
                ->where('tahun', session('tahun_anggaran', date('Y')));
        }])->get();

        return view('budgets.index', compact('programs', 'tahapanAktif'));
    }

    // Simpan atau Update Rincian Pagu
    public function store(Request $request)
    {
        $request->validate([
            'sub_activity_id' => 'required',
            'account_id' => 'required',
            'nominal' => 'required|numeric|min:0',
            'tahapan' => 'required',
        ]);

        // Cek apakah sudah ada rekening yang sama di tahapan yang sama
        Budget::updateOrCreate(
            [
                'sub_activity_id' => $request->sub_activity_id,
                'account_id' => $request->account_id,
                'tahapan' => $request->tahapan,
                'tahun' => session('tahun_anggaran', date('Y')),
            ],
            [
                'nominal' => $request->nominal,
                'dasar_hukum' => $request->dasar_hukum,
            ]
        );

        return back()->with('success', 'Rincian anggaran berhasil diperbarui!');
    }

    // Fungsi Sakti: Salin data dari tahapan sebelumnya
    public function replicate(Request $request)
    {
        $target = $request->tahapan_tujuan; // misal: geser_awal
        $source = $request->tahapan_asal;   // misal: murni
        $sub_id = $request->sub_activity_id;

        $sourceData = Budget::where('sub_activity_id', $sub_id)
                            ->where('tahapan', $source)
                            ->get();

        if ($sourceData->isEmpty()) {
            return back()->with('error', "Data pada tahapan $source tidak ditemukan!");
        }

        foreach ($sourceData as $data) {
            Budget::updateOrCreate(
                [
                    'sub_activity_id' => $sub_id,
                    'account_id' => $data->account_id,
                    'tahapan' => $target,
                    'tahun' => $data->tahun,
                ],
                [
                    'nominal' => $data->nominal,
                    'dasar_hukum' => "Salinan dari $source",
                ]
            );
        }

        return back()->with('success', "Berhasil menyalin data dari $source ke $target");
    }
}
