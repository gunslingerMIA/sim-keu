<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // app/Http/Controllers/DashboardController.php

    public function index()
    {
        $tahun = session('tahun_anggaran', 2026);

        // 1. Hitung Total Pagu dari tabel budgets
        $totalPagu = \App\Models\Budget::where('fiscal_year', $tahun)->sum('amount');

        // 2. Hitung Total Realisasi dari tabel transactions (Akun Tipe Belanja)
        $totalRealisasi = \App\Models\Transaction::whereYear('date', $tahun)
                            ->whereHas('account', function($q) {
                                $q->where('kelompok', 'belanja');
                            })
                            ->sum('debit');

        $sisa = $totalPagu - $totalRealisasi;
        $persen = $totalPagu > 0 ? ($totalRealisasi / $totalPagu) * 100 : 0;

        // 3. Ringkasan per Program
        $programs = \App\Models\Program::with(['activities.subActivities.budgets', 'activities.subActivities.transactions'])
                    ->get()
                    ->map(function($program) {
                        // Logika penjumlahan pagu dan realisasi per program di sini
                        return $program;
                    });

        return view('dashboard', compact('totalPagu', 'totalRealisasi', 'sisa', 'persen', 'programs'));
    }
}
