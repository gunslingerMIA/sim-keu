<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Budget;
use App\Models\Transaction;

class DashboardController extends Controller
{
    // app/Http/Controllers/DashboardController.php

    public function index()
    {
        // Mengambil tahun dari session atau default tahun sekarang
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Ambil Total Pagu (Langsung dari database)
        $totalPagu = \App\Models\Budget::where('tahun', $tahun)->sum('nominal');

        // 2. Ambil Total Realisasi
        // Kita filter hanya transaksi yang memiliki sub_activity_id (artinya transaksi belanja/kegiatan)
        $totalRealisasi = \App\Models\Transaction::whereYear('tanggal', $tahun)
            ->whereNotNull('sub_activity_id')
            ->sum('jumlah');

        // 3. Kalkulasi Ringkas
        $sisaAnggaran = $totalPagu - $totalRealisasi;
        $persenSerapan = $totalPagu > 0 ? ($totalRealisasi / $totalPagu) * 100 : 0;

        // 4. Data Program (Gunakan withSum agar database yang menghitung, bukan PHP)
        // Ini jauh lebih cepat daripada flatMap
        $programs = \App\Models\Program::where('tahun', $tahun)
            ->with(['activities.subActivities' => function($query) {
                // Kita ambil sub_activity sekaligus total budget dan total transaksi-nya
                $query->withSum('budgets as total_pagu', 'nominal')
                    ->withSum('transactions as total_realisasi', 'jumlah');
            }])
            ->get()
            ->map(function ($p) {
                // Menjumlahkan hasil sum dari cucu-cucunya (activities -> subActivities)
                $p->pagu = $p->activities->sum(function($activity) {
                    return $activity->subActivities->sum('total_pagu');
                });
                
                $p->realisasi = $p->activities->sum(function($activity) {
                    return $activity->subActivities->sum('total_realisasi');
                });

                $p->sisa = $p->pagu - $p->realisasi;
                $p->persen = $p->pagu > 0 ? ($p->realisasi / $p->pagu) * 100 : 0;
                return $p;
            });

        return view('dashboard', compact(
            'totalPagu', 
            'totalRealisasi', 
            'sisaAnggaran', 
            'persenSerapan', 
            'programs',
            'tahun'
        ));
    }

    public function journalIndex()
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $tahapan = session('active_stage_id');

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('reports.journal', compact('transactions', 'tahun'));
    }
}
