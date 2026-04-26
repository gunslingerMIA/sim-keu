<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\SubActivity;
use App\Models\Account;
use App\Models\Program;
use App\Models\AppSetting;
use App\Models\Stage;
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
        $tahun = session('tahun_anggaran', date('Y'));
        $tahapan = session('active_stage_id');

        // Jika tahapan kosong, redirect ke pilih tahun atau beri peringatan
        if (!$tahapan) {
            return redirect()->route('tahun.pilih')->with('error', 'Silakan pilih tahun dan tahapan terlebih dahulu.');
        }

        $programs = Program::where('tahun', $tahun)
            // Opsi: Jika Program juga punya stage_id, tambahkan where di sini
            ->with([
                'activities' => function($q) use ($tahun, $tahapan) {
                    $q->with([
                        'subActivities' => function($sq) use ($tahun, $tahapan) {
                            // Gunakan withSum dengan kondisi yang ketat
                            $sq->withSum(['budgets as total_pagu' => function($bq) use ($tahun, $tahapan) {
                                $bq->where('tahun', $tahun)
                                ->where('stage_id', $tahapan);
                            }], 'nominal');
                        }
                    ]);
                }
            ])
            ->get()
            ->map(function ($program) {
                foreach ($program->activities as $activity) {
                    // Pastikan nilai default 0 jika sum bernilai null
                    $activity->total_pagu = $activity->subActivities->sum('total_pagu') ?? 0;
                }
                
                $program->total_pagu = $program->activities->sum('total_pagu') ?? 0;
                
                return $program;
            });

        return view('budgets.index', compact('programs'));
    }

    public function rincian($sub_id)
    {
        $subActivity = SubActivity::with(['budgets.account'])->findOrFail($sub_id);
        $accounts = Account::all();
        $budgets = Budget::where('sub_activity_id', $sub_id)
                        ->where('tahun', session('tahun_anggaran', date('Y')))
                        ->get();
        return view('budgets.rinci', compact('subActivity', 'accounts', 'budgets'));
    }

    // Simpan atau Update Rincian Pagu
    public function store(Request $request)
    {   
        $request->validate([
            'sub_activity_id' => 'required|exists:sub_activities,id',
            'account_id'      => 'required|exists:accounts,id',
            'nominal'         => 'required|numeric|min:1'
        ], [
            'nominal.min'     => 'Nominal harus lebih dari 0!',
            'account_id.required' => 'Pilih rekening belanja terlebih dahulu.'
        ]);

        $tahun = session('tahun_anggaran', date('Y'));
        $stage_id = session('active_stage_id');

        if (!$stage_id) {
            $stage_id = \App\Models\Stage::where('tahun', $tahun)->where('is_active', true)->first()?->id;  
            if (!$stage_id) {
                return back()->with('error', 'Silakan pilih tahapan terlebih dahulu.');
            }
        }

        // Gunakan updateOrCreate untuk mencegah duplikasi rekening di sub kegiatan yang sama
        Budget::updateOrCreate(
            [
                'stage_id'       => $stage_id,
                'tahun'           => $tahun,
                'sub_activity_id' => $request->sub_activity_id,
                'account_id'      => $request->account_id
            ],
            [
                'nominal'         => $request->nominal
            ]
        );

        return back()->with('success', 'Rincian anggaran berhasil disimpan.');
    }

    public function delete($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();

        return back()->with('success', 'Rincian anggaran berhasil dihapus.');
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
