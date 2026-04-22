@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="mb-3">
            <small class="text-success fw-bold">
                <i class="bi bi-check-circle-fill me-1"></i> 
                Tahapan Aktif = {{ str_replace('_', ' ', $labelTahapan ?? $tahapanAktif) }}
            </small>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Struktur DPA SKPD</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Kode & Uraian Struktur</th>
                            <th class="text-end" style="width: 200px;">Pagu Anggaran</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $p)
                        <tr class="bg-light cursor-pointer" data-bs-toggle="collapse" data-bs-target="#prog-{{ $p->id }}" aria-expanded="false" style="cursor: pointer;">
                            <td class="fw-bold">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span class="text-primary">{{ $p->kode_program }}</span> {{ $p->nama_program }}
                            </td>
                            <td class="text-end fw-bold">
                                {{ number_format($p->total_pagu, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>

                        <tr class="collapse" id="prog-{{ $p->id }}">
                            <td colspan="3" class="p-0">
                                <table class="table table-vcenter mb-0" style="background: #fcfcfc;">
                                    <tbody>
                                        @foreach($p->activities as $a)
                                        <tr class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#act-{{ $a->id }}" aria-expanded="false" style="cursor: pointer;">
                                            <td class="ps-3 text-muted">
                                                <i class="bi bi-chevron-right me-2"></i>
                                                <strong>{{ $a->kode_kegiatan }}</strong> {{ $a->nama_kegiatan }}
                                            </td>
                                            <td class="text-end text-muted" style="width: 200px;">
                                                {{ number_format($a->total_pagu, 0, ',', '.') }}
                                            </td>
                                            <td class="w-1"></td>
                                        </tr>

                                        <tr class="collapse" id="act-{{ $a->id }}">
                                            <td colspan="3" class="p-0">
                                                <table class="table table-vcenter mb-0 bg-white">
                                                    <tbody>
                                                        @foreach($a->subActivities as $s)
                                                        <tr>
                                                            <td class="ps-5">
                                                                <span class="text-muted me-2">└─</span> {{ $s->kode_sub_kegiatan }} {{ $s->nama_sub_kegiatan }}
                                                            </td>
                                                            <td class="text-end fw-bold text-azure" style="width: 200px;">
                                                                {{ number_format($s->total_pagu, 0, ',', '.') }}
                                                            </td>
                                                            <td class="w-1">
                                                                <a href="{{ route('budgets.index', $s->id) }}" class="btn btn-sm btn-outline-primary btn-pill">
                                                                    <i class="bi bi-gear-fill me-1"></i> Set
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
    /* Rotasi icon saat collapse dibuka */
    tr[aria-expanded="true"] .bi-chevron-right {
        transform: rotate(90deg);
        transition: transform 0.2s;
    }
    .bi-chevron-right {
        transition: transform 0.2s;
        display: inline-block;
    }
    /* Menghilangkan border double saat collapse */
    .collapse td {
        border-bottom-width: 0;
    }
</style>
@endsection