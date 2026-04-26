@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Jurnal Transaksi</h2>
                <div class="text-muted small mt-1">Daftar seluruh mutasi kas dan belanja tahun {{ $tahun }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="/transactions/add" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>No. Bukti / Keterangan</th>
                            <th>Rekening / Sub Kegiatan</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr>
                            <td class="text-nowrap">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $badgeColor = [
                                        'JKK' => 'bg-red-lt',
                                        'JKM' => 'bg-green-lt',
                                        'JAK' => 'bg-azure-lt',
                                        'JU'  => 'bg-secondary-lt'
                                    ][$t->type] ?? 'bg-gray-lt';
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ $t->type }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $t->evidence_number }}</div>
                                <div class="text-muted small">{{ $t->description }}</div>
                            </td>
                            <td>
                                <div>{{ $t->account->nama_akun ?? 'N/A' }}</div>
                                @if($t->subActivity)
                                    <div class="text-muted small">
                                        <i class="bi bi-arrow-return-right me-1"></i>
                                        {{ $t->subActivity->nama_sub_kegiatan }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-end text-success fw-bold">
                                {{ $t->debit > 0 ? number_format($t->debit, 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-end text-danger fw-bold">
                                {{ $t->credit > 0 ? number_format($t->credit, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi di tahun {{ $tahun }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection