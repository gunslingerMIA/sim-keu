<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\JournalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Account;
use App\Exports\LedgerExport;
use App\Exports\LraExport;

class ReportController extends Controller
{
    public function journalIndex(Request $request)
    {
        $tahunAnggaran = session('tahun_anggaran', date('Y'));

        $start = $request->get('start_date', date('Y-m-01'));
        $end = $request->get('end_date', $tahunAnggaran . '-12-31'); //

        $transactions = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();
        // Logika untuk menampilkan halaman laporan jurnal transaksi
        return view('reports.journal_index', compact('transactions', 'start', 'end'));
    }
    //

    public function journalExport(Request $request)
    {
        $start = $request->get('start_date');
        $end = $request->get('end_date'); //

        $transactions = Transaction::with(['debitAccount', 'kreditAccount'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();

        return Excel::download(new JournalExport($transactions), "Jurnal_Transaksi_{$start}_to_{$end}.xlsx");
    }

    public function ledgerIndex(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Ambil data untuk Pilihan Modal Search (Tetap seperti kode Abang)
        $budgetData = \App\Models\Budget::with(['account', 'subActivity'])
            ->where('tahun', $tahun)
            ->get()
            ->sortBy('subActivity.kode_sub_kegiatan')
            ->map(function ($b) {
                return [
                    'id' => $b->account_id,
                    'sub_activity_id' => $b->sub_activity_id,
                    'kelompok' => 'belanja',
                    'kode' => $b->subActivity->kode_sub_kegiatan,
                    'display' => $b->subActivity->nama_sub_kegiatan . " - " . $b->account->nama_rekening
                ];
            });

        $nonBudgetData = \App\Models\Account::whereIn('kelompok', ['non sub-kegiatan'])
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'sub_activity_id' => null,
                    'kelompok' => 'Non-Belanja',
                    'kode' => $a->kode_rekening,
                    'display' => $a->nama_rekening
                ];
            });

        $allOptions = $budgetData->merge($nonBudgetData);

        // 2. Tangkap Request Filter
        $selectedAccount = $request->get('account_id');
        $selectedSubActivityId = $request->get('sub_activity_id');
        $start = $request->get('start_date', $tahun . '-01-01');
        $end = $request->get('end_date', $tahun . '-12-31');

        $mutations = [];
        $saldoAwal = 0;

        // Semua proses query harus masuk ke dalam check ini
        if ($selectedAccount) {

            // --- PROSES 1: HITUNG SALDO AWAL (Gunakan kolom 'jumlah') ---
            $debitAwalQuery = Transaction::where('account_debit', $selectedAccount)->where('tanggal', '<', $start);
            $kreditAwalQuery = Transaction::where('account_kredit', $selectedAccount)->where('tanggal', '<', $start);

            if ($selectedSubActivityId) {
                $debitAwalQuery->where('sub_activity_id', $selectedSubActivityId);
                $kreditAwalQuery->where('sub_activity_id', $selectedSubActivityId);
            } else {
                $debitAwalQuery->whereNull('sub_activity_id');
                $kreditAwalQuery->whereNull('sub_activity_id');
            }

            $debitAwal = $debitAwalQuery->sum('jumlah');
            $kreditAwal = $kreditAwalQuery->sum('jumlah');
            $saldoAwal = $debitAwal - $kreditAwal;


            // --- PROSES 2: AMBIL MUTASI TRANSAKSI ---
            $mutationsQuery = Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
                ->whereBetween('tanggal', [$start, $end]);

            $mutationsQuery->where(function ($query) use ($selectedAccount, $selectedSubActivityId) {
                $query->where(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                    $q->where('account_debit', $selectedAccount);
                    if ($selectedSubActivityId) {
                        $q->where('sub_activity_id', $selectedSubActivityId);
                    } else {
                        $q->whereNull('sub_activity_id');
                    }
                })
                    ->orWhere(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                        $q->where('account_kredit', $selectedAccount);
                        if ($selectedSubActivityId) {
                            $q->where('sub_activity_id', $selectedSubActivityId);
                        }
                    });
            });

            $mutations = $mutationsQuery->orderBy('tanggal', 'asc')
                ->orderBy('pkjur', 'asc')
                ->get();
        }

        // Ambil semua data master akun untuk fallback compact (jika dibutuhkan di view)
        $accounts = \App\Models\Account::all();

        return view('reports.ledger_index', compact(
            'accounts',
            'selectedAccount',
            'selectedSubActivityId', // Bagian ini juga dikirim balik biar filter gak ke-reset
            'start',
            'end',
            'mutations',
            'saldoAwal',
            'allOptions',
            'nonBudgetData'
        ));
    }

    public function ledgerExport(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));

        // 1. Tangkap Request Filter dari Blade
        $selectedAccount = $request->get('account_id');
        $selectedSubActivityId = $request->get('sub_activity_id');
        $start = $request->get('start_date', $tahun . '-01-01');
        $end = $request->get('end_date', $tahun . '-12-31');

        if (!$selectedAccount) {
            return redirect()->back()->with('error', 'Silakan pilih rekening terlebih dahulu.');
        }

        // 2. LOGIKA HITUNG SALDO AWAL (Langsung ditulis di sini biar anti-error)
        $debitAwalQuery = \App\Models\Transaction::where('account_debit', $selectedAccount)->where('tanggal', '<', $start);
        $kreditAwalQuery = \App\Models\Transaction::where('account_kredit', $selectedAccount)->where('tanggal', '<', $start);

        if ($selectedSubActivityId) {
            $debitAwalQuery->where('sub_activity_id', $selectedSubActivityId);
            $kreditAwalQuery->where('sub_activity_id', $selectedSubActivityId);
        } else {
            $debitAwalQuery->whereNull('sub_activity_id');
            $kreditAwalQuery->whereNull('sub_activity_id');
        }

        $saldoAwal = $debitAwalQuery->sum('jumlah') - $kreditAwalQuery->sum('jumlah');

        // 3. AMBIL DATA MUTASI TRANSAKSI PERIODE INI
        $mutationsQuery = \App\Models\Transaction::with(['debitAccount', 'kreditAccount', 'subActivity'])
            ->whereBetween('tanggal', [$start, $end]);

        $mutationsQuery->where(function ($query) use ($selectedAccount, $selectedSubActivityId) {
            $query->where(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                $q->where('account_debit', $selectedAccount);
                if ($selectedSubActivityId) {
                    $q->where('sub_activity_id', $selectedSubActivityId);
                } else {
                    $q->whereNull('sub_activity_id');
                }
            })
                ->orWhere(function ($q) use ($selectedAccount, $selectedSubActivityId) {
                    $q->where('account_kredit', $selectedAccount);
                    if ($selectedSubActivityId) {
                        $q->where('sub_activity_id', $selectedSubActivityId);
                    }
                });
        });

        $mutations = $mutationsQuery->orderBy('tanggal', 'asc')
            ->orderBy('pkjur', 'asc')
            ->get();

        // 4. Tempel ID Akun terpilih ke properti sementara agar LedgerExport tahu posisi Debit/Kredit-nya
        $mutations->transform(function ($item) use ($selectedAccount) {
            $item->selected_account_id = $selectedAccount;
            return $item;
        });

        // 5. Cari Nama Rekening untuk Keperluan Judul di Atas Dokumen Excel
        $accountData = \App\Models\Account::find($selectedAccount);
        $accountName = $accountData ? $accountData->nama_rekening : 'Rekening Buku Besar';

        // Jika yang dipilih akun belanja, kombinasikan judulnya dengan nama sub-kegiatan biar informatif
        if ($selectedSubActivityId) {
            $subActivityData = \App\Models\SubActivity::find($selectedSubActivityId);
            if ($subActivityData) {
                $accountName = $subActivityData->nama_sub_kegiatan . " - " . $accountName;
            }
        }

        // 6. Jalankan Proses Download Excel
        $filename = 'Buku_Besar_' . str_replace('.', '_', $selectedAccount) . '_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LedgerExport($mutations, $saldoAwal, $start, $end, $accountName), $filename);
    }

    public function lraIndex(Request $request)
    {
        // Logika untuk menampilkan halaman laporan LRA
        $tahunAnggaran = session('tahun_anggaran', date('Y'));

        //filter parameter
        $end = $request->get('end_date', $tahunAnggaran . '-12-31'); //

        $jenisLra = $request->get('jenis_lra', 'ringkas'); // default ke 'ringkas' jika tidak ada input

        //ambil struktur program sampai budget
        $programs = \App\Models\Program::where('tahun', $tahunAnggaran)
            ->with([
                'activities.subActivities.budgets' => function ($query) use ($tahunAnggaran) {
                    $query->where('tahun', $tahunAnggaran)->with('account');
                }
            ])
            ->get();

        //mapping data
        $processedData = $programs->map(function ($program) use ($end) {
            foreach ($program->activities as $activity) {
                foreach ($activity->subActivities as $subActivity) {

                    $subActivity->budgets->transform(function ($budget) use ($end) {
                        // Hitung realisasi murni belanja (Debit)
                        $realisasi = \App\Models\Transaction::where('account_debit', $budget->account_id)
                            ->where('sub_activity_id', $budget->sub_activity_id)
                            ->where('tanggal', '<=', $end)
                            ->sum('jumlah');

                        // Ganti 'pagu' di bawah ini dengan nama kolom pagu murni di DB Abang
                        $paguMurni = $budget->nominal;
                        $sisa = $paguMurni - $realisasi;
                        $persen = $paguMurni > 0 ? ($realisasi / $paguMurni) * 100 : 0;

                        $budget->pagu_murni = $paguMurni;
                        $budget->realisasi = $realisasi;
                        $budget->sisa = $sisa;
                        $budget->persen = $persen;

                        return $budget;
                    });

                    // Total level Sub-Kegiatan
                    $subActivity->total_pagu = $subActivity->budgets->sum('pagu_murni');
                    $subActivity->total_realisasi = $subActivity->budgets->sum('realisasi');
                    $subActivity->total_sisa = $subActivity->total_pagu - $subActivity->total_realisasi;
                    $subActivity->total_persen = $subActivity->total_pagu > 0 ? ($subActivity->total_realisasi / $subActivity->total_pagu) * 100 : 0;
                }

                // Total level Kegiatan
                $activity->total_pagu = $activity->subActivities->sum('total_pagu');
                $activity->total_realisasi = $activity->subActivities->sum('total_realisasi');
                $activity->total_sisa = $activity->total_pagu - $activity->total_realisasi;
                $activity->total_persen = $activity->total_pagu > 0 ? ($activity->total_realisasi / $activity->total_pagu) * 100 : 0;
            }

            // Total level Program
            $program->total_pagu = $program->activities->sum('total_pagu');
            $program->total_realisasi = $program->activities->sum('total_realisasi');
            $program->total_sisa = $program->total_pagu - $program->total_realisasi;
            $program->total_persen = $program->total_pagu > 0 ? ($program->total_realisasi / $program->total_pagu) * 100 : 0;

            return $program;
        });

        // Grand Total SKPD
        $grandPagu = $processedData->sum('total_pagu');
        $grandRealisasi = $processedData->sum('total_realisasi');
        $grandSisa = $grandPagu - $grandRealisasi;
        $grandPersen = $grandPagu > 0 ? ($grandRealisasi / $grandPagu) * 100 : 0;

        return view('reports.lra_index', compact(
            'processedData',
            'end',
            'jenisLra',
            'tahunAnggaran',
            'grandPagu',
            'grandRealisasi',
            'grandSisa',
            'grandPersen'
        ));
    }

    public function lraExport(Request $request)
    {
        $tahun = session('tahun_anggaran', date('Y'));
        $endDate = $request->get('end_date', $tahun . '-12-31');
        $jenisLra = $request->get('jenis_lra', 'ringkas');

        // Ambil raw data yang sama dari logic index LRA Abang sebelumnya
        $programs = \App\Models\Program::where('tahun', $tahun)
            ->with([
                'activities.subActivities.budgets' => function ($query) use ($tahun) {
                    $query->where('tahun', $tahun)->with('account');
                }
            ])
            ->get();

        // Jalankan mapping transform untuk menghitung realisasi & pagu (Gunakan logic penghitungan sum yang sama persis seperti lraIndex Abang)
        $processedData = $programs->map(function ($program) use ($endDate) {
            foreach ($program->activities as $activity) {
                foreach ($activity->subActivities as $subActivity) {

                    $subActivity->budgets->transform(function ($budget) use ($endDate) {
                        // Hitung realisasi murni belanja (Debit)
                        $realisasi = \App\Models\Transaction::where('account_debit', $budget->account_id)
                            ->where('sub_activity_id', $budget->sub_activity_id)
                            ->where('tanggal', '<=', $endDate)
                            ->sum('jumlah');

                        // Ganti 'pagu' di bawah ini dengan nama kolom pagu murni di DB Abang
                        $paguMurni = $budget->nominal;
                        $sisa = $paguMurni - $realisasi;
                        $persen = $paguMurni > 0 ? ($realisasi / $paguMurni) * 100 : 0;

                        $budget->pagu_murni = $paguMurni;
                        $budget->realisasi = $realisasi;
                        $budget->sisa = $sisa;
                        $budget->persen = $persen;

                        return $budget;
                    });

                    // Total level Sub-Kegiatan
                    $subActivity->total_pagu = $subActivity->budgets->sum('pagu_murni');
                    $subActivity->total_realisasi = $subActivity->budgets->sum('realisasi');
                    $subActivity->total_sisa = $subActivity->total_pagu - $subActivity->total_realisasi;
                    $subActivity->total_persen = $subActivity->total_pagu > 0 ? ($subActivity->total_realisasi / $subActivity->total_pagu) * 100 : 0;
                }

                // Total level Kegiatan
                $activity->total_pagu = $activity->subActivities->sum('total_pagu');
                $activity->total_realisasi = $activity->subActivities->sum('total_realisasi');
                $activity->total_sisa = $activity->total_pagu - $activity->total_realisasi;
                $activity->total_persen = $activity->total_pagu > 0 ? ($activity->total_realisasi / $activity->total_pagu) * 100 : 0;
            }

            // Total level Program
            $program->total_pagu = $program->activities->sum('total_pagu');
            $program->total_realisasi = $program->activities->sum('total_realisasi');
            $program->total_sisa = $program->total_pagu - $program->total_realisasi;
            $program->total_persen = $program->total_pagu > 0 ? ($program->total_realisasi / $program->total_pagu) * 100 : 0;

            return $program;
        });

         // Grand Total SKPD
        $grandPagu = $processedData->sum('total_pagu');
        $grandRealisasi = $processedData->sum('total_realisasi');
        $grandSisa = $grandPagu - $grandRealisasi;
        $grandPersen = $grandPagu > 0 ? ($grandRealisasi / $grandPagu) * 100 : 0;

        // Siapkan array ringkas untuk grand total
        $grandTotal = [
            'pagu' => $grandPagu, // dari hitungan variabel index abang
            'realisasi' => $grandRealisasi,
            'sisa' => $grandSisa,
            'persen' => $grandPersen
        ];

        $filename = 'LRA_DPMPTSP_' . $jenisLra . '_' . date('Ymd') . '.xlsx';

        if (ob_get_contents()) ob_end_clean();
        return Excel::download(new LraExport($processedData, $endDate, $jenisLra, $tahun, $grandTotal), $filename);
    }
}
