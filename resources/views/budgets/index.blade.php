@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title text-primary">Struktur DPA SKPD</h2>
                <small class="text-success fw-bold">
                    <i class="bi bi-calendar3 me-1"></i> Tahun Anggaran: {{ session('tahun_anggaran') }}
                </small>
            </div>
            <div class="text-end">
                <div class="text-muted small text-uppercase">Total Pagu Perangkat Daerah</div>
                <div class="h2 fw-bold text-azure">Rp {{ number_format($programs->sum('total_pagu'), 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-no-border">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Kode & Uraian Struktur</th>
                            <th class="text-end" style="width: 250px;">Pagu Anggaran (Rp)</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $p)
                        {{-- LEVEL 1: PROGRAM --}}
                        <tr class="bg-primary-lt cursor-pointer fw-bold" 
                            data-bs-toggle="collapse" data-bs-target="#prog-{{ $p->id }}" 
                            aria-expanded="false">
                            <td>
                                <i class="bi bi-chevron-right me-2 transition-icon"></i>
                                <span class="badge bg-primary-lt me-2">{{ $p->kode_program }}</span> {{ $p->nama_program }}
                            </td>
                            <td class="text-end">
                                {{ number_format($p->total_pagu, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>

                        <tr class="collapse" id="prog-{{ $p->id }}">
                            <td colspan="3" class="p-0">
                                <table class="table table-vcenter mb-0 border-start border-primary border-3">
                                    <tbody>
                                        @foreach($p->activities as $a)
                                        {{-- LEVEL 2: KEGIATAN --}}
                                        <tr class="bg-light cursor-pointer shadow-none" 
                                            data-bs-toggle="collapse" data-bs-target="#act-{{ $a->id }}" 
                                            style="background-color: #f8fafc !important;">
                                            <td class="ps-4">
                                                <i class="bi bi-chevron-right me-2 transition-icon"></i>
                                                <strong class="text-muted">{{ $a->kode_kegiatan }}</strong> {{ $a->nama_kegiatan }}
                                            </td>
                                            <td class="text-end text-muted fw-bold" style="width: 250px;">
                                                {{ number_format($a->total_pagu, 0, ',', '.') }}
                                            </td>
                                            <td class="w-1"></td>
                                        </tr>

                                        <tr class="collapse" id="act-{{ $a->id }}">
                                            <td colspan="3" class="p-0">
                                                <table class="table table-vcenter mb-0">
                                                    <tbody>
                                                        @foreach($a->subActivities as $s)
                                                        {{-- LEVEL 3: SUB KEGIATAN --}}
                                                        <tr class="hover-shadow">
                                                            <td class="ps-5">
                                                                <span class="text-muted me-2">└─</span> 
                                                                <small class="text-secondary">{{ $s->kode_sub_kegiatan }}</small> 
                                                                <span class="ms-2">{{ $s->nama_sub_kegiatan }}</span>
                                                            </td>
                                                            <td class="text-end fw-bold text-azure" style="width: 250px;">
                                                                {{ number_format($s->total_pagu, 0, ',', '.') }}
                                                            </td>
                                                            <td class="pe-3">
                                                                <a href="/budgets/rinci/{{ $s->id }}" class="btn btn-sm btn-white btn-pill border-azure text-azure shadow-sm">
                                                                    <i class="bi bi-gear-fill me-1"></i> Rincian
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    
    /* Animasi rotasi icon saat dibuka */
    .transition-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    tr[aria-expanded="true"] .transition-icon {
        transform: rotate(90deg);
        color: #206bc4;
    }

    /* Hilangkan border berlebih pada tabel nested */
    .table-no-border th, .table-no-border td {
        border-bottom: 1px solid rgba(101, 109, 119, 0.1);
    }

    /* Efek hover pada sub kegiatan */
    .hover-shadow:hover {
        background-color: #f1f5f9;
        transition: background-color 0.2s;
    }

    .btn-pill {
        padding-left: 1rem;
        padding-right: 1rem;
    }
</style>
@endsection