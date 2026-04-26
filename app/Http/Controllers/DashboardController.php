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
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Ambil Total Pagu (Sum dari tabel budgets)
        $totalPagu = Budget::where('tahun', $tahun)->sum('nominal');

        // 2. Ambil Total Realisasi (Sum dari tabel transactions kelompok belanja)
        $totalRealisasi = Transaction::whereYear('date', $tahun)
            ->whereHas('account', function($q) {
                $q->where('kelompok', 'belanja');
            })->sum('debit');

        // 3. Kalkulasi
        $sisaAnggaran = $totalPagu - $totalRealisasi;
        $persenSerapan = $totalPagu > 0 ? ($totalRealisasi / $totalPagu) * 100 : 0;

        // 4. Data Chart/Ringkasan Program
        $programs = \App\Models\Program::where('tahun', $tahun)
            ->with(['activities.subActivities.budgets', 'activities.subActivities.transactions'])
            ->get()
            ->map(function ($p) {
                $p->pagu = $p->activities->flatMap->subActivities->flatMap->budgets->sum('nominal');
                $p->realisasi = $p->activities->flatMap->subActivities->flatMap->transactions->sum('debit');
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
}
