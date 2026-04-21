@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle">Ringkasan Eksekutif</div>
                <h2 class="page-title text-primary">
                    Dashboard Anggaran TA {{ session('tahun_anggaran', '2026') }}
                </h2>
            </div>
        </div>
    </div>

    <div class="row row-cards mb-4">
        <div class="col-12 col-lg-3">
            <div class="card card-sm shadow-sm border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <i class="bi bi-wallet2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-muted" style="font-size: 0.75rem;">TOTAL PAGU DPA</div>
                            <div class="h2 mb-0 fw-bold text-dark">Rp {{ number_format($totalPagu, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card card-sm shadow-sm border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <i class="bi bi-cash-stack"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-muted" style="font-size: 0.75rem;">REALISASI (LRA)</div>
                            <div class="h2 mb-0 fw-bold text-success">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card card-sm shadow-sm border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar">
                                <i class="bi bi-hourglass-split"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-muted" style="font-size: 0.75rem;">SISA ANGGARAN</div>
                            <div class="h2 mb-0 fw-bold text-warning">Rp {{ number_format($sisa, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12  col-lg-3">
            <div class="card card-sm shadow-sm border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto text-center w-100">
                            <div class="font-weight-medium text-muted" style="font-size: 0.75rem;">TINGKAT SERAPAN</div>
                            <div class="h2 mb-0 fw-bold text-info">{{ number_format($persen, 2) }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h3 class="card-title fw-bold"><i class="bi bi-bar-chart-line me-2"></i>Serapan Anggaran per Program</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Uraian Program</th>
                        <th>Alokasi Pagu</th>
                        <th>Realisasi</th>
                        <th width="35%">Progress Serapan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $p)
                        @php
                            $paguProg = $p->activities->flatMap->subActivities->flatMap->budgets->sum('amount');
                            $realisasiProg = $p->activities->flatMap->subActivities->flatMap->transactions->sum('debit');
                            $persenProg = $paguProg > 0 ? ($realisasiProg / $paguProg) * 100 : 0;
                        @endphp
                        <tr>
                            <td class="small fw-bold">{{ $p->nama_program }}</td>
                            <td class="text-nowrap text-secondary">Rp {{ number_format($paguProg, 0, ',', '.') }}</td>
                            <td class="text-nowrap text-success fw-medium">Rp {{ number_format($realisasiProg, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress progress-sm w-100 me-3">
                                        <div class="progress-bar {{ $persenProg > 90 ? 'bg-danger' : ($persenProg > 50 ? 'bg-primary' : 'bg-azure') }}" 
                                             role="progressbar" style="width: {{ $persenProg }}%"></div>
                                    </div>
                                    <div class="fw-bold" style="min-width: 45px;">{{ number_format($persenProg, 1) }}%</div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection