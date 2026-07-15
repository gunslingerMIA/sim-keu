<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\SubActivity;
use App\Models\Account;
use App\Models\Program;
use App\Models\AppSetting;
use App\Models\Stage;
use Illuminate\Http\Request;
use App\Models\Transaction;

class BudgetController extends Controller
{
    // Menampilkan daftar pagu per Sub-Kegiatan
    // NOTE: gantiTahapan() & replicate() lama dihapus dari sini — kolom 'tahapan'
    // yang dipakainya tidak pernah ada di tabel budgets (yang ada stage_id).
    // Fungsinya sekarang digantikan oleh StagesController::store().

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

        $stageAktif = Stage::find($tahapan);
        $riwayatTahapan = Stage::where('tahun', $tahun)->orderBy('urutan')->get();

        return view('budgets.index', compact('programs', 'stageAktif', 'riwayatTahapan'));
    }

    public function rincian($sub_id)
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $subActivity = SubActivity::with(['budgets.account'])->findOrFail($sub_id);
        $accounts = Account::where('tahun', $tahun)->get();
        $budgets = Budget::where('sub_activity_id', $sub_id)
                        ->where('tahun', $tahun)
                        ->where('stage_id', session('active_stage_id'))
                        ->get();

        $stageAktif = Stage::find(session('active_stage_id'));

        return view('budgets.rinci', compact('subActivity', 'accounts', 'budgets', 'stageAktif'));
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

        $stage = Stage::find($stage_id);
        if ($stage && $stage->is_locked) {
            return back()->with('error', "Tahapan '{$stage->nama_tahapan}' sudah terkunci dan tidak bisa diubah lagi.");
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

        $stage = Stage::find($budget->stage_id);
        if ($stage && $stage->is_locked) {
            return back()->with('error', "Tahapan '{$stage->nama_tahapan}' sudah terkunci, rincian anggaran tidak bisa dihapus.");
        }

        //cek apakah ada transaksi
        $adaTransaksi = Transaction::where('sub_activity_id', $budget->sub_activity_id)
                                    ->where('account_debit', $budget->account_id)
                                    ->exists();
        if ($adaTransaksi) {
            return back()->with('error', 'Tidak dapat menghapus rincian anggaran karena terdapat transaksi terkait.');
        }
       
        $budget->delete();

        return back()->with('success', 'Rincian anggaran berhasil dihapus.');
    }
}