@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Dashboard Anggaran {{ $tahun }}</h2>
                    <div class="text-muted small mt-1">Monitoring Pagu dan Realisasi DPA Perangkat Daerah</div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar shadow">
                                    <i class="bi bi-wallet2"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Total Pagu DPA</div>
                                <div class="text-muted h3 mb-0 fw-bold">Rp {{ number_format($totalPagu, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar shadow">
                                    <i class="bi bi-cash-stack"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Total Realisasi</div>
                                <div class="text-muted h3 mb-0 fw-bold">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-yellow text-white avatar shadow">
                                    <i class="bi bi-piggy-bank"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Sisa Anggaran</div>
                                <div class="text-muted h3 mb-0 fw-bold">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="chart-sparkline chart-sparkline-square" id="sparkline-activity"></div>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Persentase Serapan</div>
                                <div class="text-muted h3 mb-0 fw-bold">{{ number_format($persenSerapan, 2) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="subheader">Progress Serapan Anggaran Keseluruhan</div>
                            <div class="ms-auto fw-bold text-azure">{{ number_format($persenSerapan, 2) }}%</div>
                        </div>
                        <div class="progress progress-md">
                            <div class="progress-bar bg-azure" style="width: {{ $persenSerapan }}%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Proporsi Pagu Per Program</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Nama Program</th>
                                    <th>Alokasi Pagu</th>
                                    <th>Realisasi</th>
                                    <th>Sisa</th>
                                    <th class="w-1">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $p)
                                    <tr>
                                        <td>{{ $p->nama_program }}</td>
                                        <td class="text-muted">Rp {{ number_format($p->pagu, 0, ',', '.') }}</td>
                                        <td class="text-muted">Rp {{ number_format($p->realisasi, 0, ',', '.') }}</td>
                                        <td class="text-muted">Rp {{ number_format($p->sisa, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="fw-bold me-2">{{ number_format($p->persen, 1) }}%</div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $p->persen }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
