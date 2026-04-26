@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/budgets/">Sub Kegiatan</a></li>
                        <li class="breadcrumb-item active">Rincian Sub Kegiatan</li>
                    </ol>
                </nav>
                <h4 class="mt-2 text-azure">
                    <i class="bi bi-wallet2 me-2"></i> {{ $subActivity->kode_sub_kegiatan }} {{ $subActivity->nama_sub_kegiatan }}
                </h4>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary-lt">
                        <h3 class="card-title">Tambah Rekening Belanja</h3>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('budgets.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="sub_activity_id" value="{{ $subActivity->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Rekening Belanja</label>
                                <select name="account_id" class="form-select" id="select-account" required>
                                    <option value="">-- Pilih Rekening --</option>
                                    @foreach($accounts as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->kode_rekening }} - {{ $acc->nama_rekening }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Nominal Pagu (Rp)</label>
                                <input type="number" name="nominal" class="form-control" placeholder="0" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save me-2"></i> Simpan ke DPA
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Rekening</th>
                                    <th>Uraian</th>
                                    <th class="text-end">Nominal</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @forelse($budgets as $b)
                                <tr>
                                    <td class="text-muted small">{{ $b->account->kode_rekening }}</td>
                                    <td class="fw-bold">{{ $b->account->nama_rekening }}</td>
                                    <td class="text-end fw-bold">
                                        {{ number_format($b->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <button class="btn btn-icon btn-ghost-danger btn-sm" onclick="confirmDeleteBudget('/budgets/delete/{{ $b->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php $total += $b->nominal; @endphp
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted italic">Belum ada rincian belanja.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="2" class="text-end h4 fw-bold text-uppercase">Total Pagu Sub Kegiatan:</td>
                                    <td class="text-end h4 text-azure fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi Tom Select
        
        new TomSelect("#select-account", {
            
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            // Agar dropdown tidak tertutup saat discroll di dalam modal
            dropdownParent: 'body' 
        });
        console.log('sampe sini');
    });

    function confirmDeleteBudget(url){
        Swal.fire({
            title: 'Yakin ingin menghapus rincian ini?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection