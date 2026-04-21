@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Rekening Belanja</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-akun">
            <i class="bi bi-plus-lg me-2"></i> Tambah Akun
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table" id="table">
            <thead>
                <tr>
                    <th>Kode Rekening</th>
                    <th>Uraian Akun</th>
                    <th>Kelompok</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $acc)
                <tr>
                    <td class="text-muted">{{ $acc->kode_rekening }}</td>
                    <td class="fw-bold">{{ $acc->nama_rekening }}</td>
                    <td>
                        <span class="badge {{ $acc->kelompok == 'Belanja Modal' ? 'bg-purple-lt' : 'bg-blue-lt' }}">
                            {{ $acc->kelompok }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-ghost-warning" onclick="editAkun({{ $acc->id }})">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
