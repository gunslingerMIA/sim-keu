@extends('layouts.app')

@section('content')
<div class="container-xl">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title fw-bold">
                    <i class="bi bi-calendar3 me-2 text-primary"></i>Manajemen Tahun Anggaran
                </h2>
                <p class="text-muted mb-0">Tambah tahun anggaran baru. Struktur program, kegiatan, sub-kegiatan, dan rekening belanja akan tersalin otomatis dari tahun sebelumnya.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ═══════════════════════════════════════════════
             PANEL KIRI: Form Tambah Tahun Anggaran
        ══════════════════════════════════════════════════ --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Tahun Anggaran Baru
                    </h5>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('years.store') }}" method="POST" onsubmit="return konfirmasiTambah(event)">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tahun Anggaran <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                name="tahun"
                                id="inputTahun"
                                class="form-control @error('tahun') is-invalid @enderror"
                                placeholder="Contoh: 2027"
                                min="2000"
                                max="2100"
                                value="{{ old('tahun') }}"
                                required
                            >
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="alert alert-info border-0 bg-blue-lt p-3 mb-3">
                            <h6 class="alert-heading fw-bold mb-2">
                                <i class="bi bi-info-circle me-1"></i> Yang akan terjadi:
                            </h6>
                            <ul class="mb-0 small ps-3">
                                <li>Struktur <strong>Program, Kegiatan, Sub-Kegiatan</strong> disalin dari tahun terbaru</li>
                                <li><strong>Rekening belanja</strong> disalin dari tahun terbaru</li>
                                <li>Tahapan <strong>"APBD Murni"</strong> terbentuk otomatis</li>
                                <li><strong>Pagu anggaran (DPA)</strong> <span class="text-danger fw-bold">TIDAK disalin</span> — harus diisi ulang</li>
                            </ul>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnTambah" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> Buat Tahun Anggaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- Petunjuk Switch Tahun --}}
            <div class="card mt-3 border-warning border shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-bold text-warning mb-1">
                        <i class="bi bi-arrow-left-right me-1"></i>Cara Berpindah Tahun
                    </h6>
                    <p class="small text-muted mb-0">
                        Untuk berpindah ke tahun anggaran yang berbeda, silakan <strong>logout</strong> terlebih dahulu kemudian pilih tahun anggaran yang diinginkan pada halaman <strong>Login</strong>.
                    </p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════
             PANEL KANAN: Daftar Tahun Anggaran
        ══════════════════════════════════════════════════ --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul me-2"></i>Daftar Tahun Anggaran
                    </h5>
                    <span class="badge bg-blue">{{ $years->count() }} tahun</span>
                </div>
                <div class="card-body p-0">
                    @if($years->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            Belum ada tahun anggaran terdaftar.
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tahun</th>
                                    <th class="text-center">Jumlah Program</th>
                                    <th class="text-center">Jumlah Tahapan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Sumber Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($years as $year)
                                <tr class="{{ session('tahun_anggaran') == $year->tahun ? 'table-primary' : '' }}">
                                    <td>
                                        <span class="fw-bold fs-5">{{ $year->tahun }}</span>
                                        @if(session('tahun_anggaran') == $year->tahun)
                                            <span class="badge bg-primary ms-2">Aktif Sekarang</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-blue-lt text-blue border border-blue">
                                            {{ $year->programs_count }} program
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-teal-lt text-teal border border-teal">
                                            {{ $year->stages_count }} tahapan
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($year->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Ditutup</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($loop->last && $years->count() > 1)
                                            <span class="badge bg-orange-lt text-orange border border-orange">
                                                <i class="bi bi-arrow-up-circle me-1"></i>Tahun Perdana
                                            </span>
                                        @elseif($loop->first && $years->count() > 1)
                                            <span class="badge bg-purple-lt text-purple border border-purple">
                                                <i class="bi bi-stars me-1"></i>Terbaru
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info Card: Alur Duplikasi --}}
            <div class="card mt-3 border-0 bg-light shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-2"><i class="bi bi-diagram-3 me-1"></i>Alur Duplikasi Data</h6>
                    <div class="row g-2 small">
                        <div class="col-auto">
                            <span class="badge bg-green-lt text-green border border-green p-2">
                                <i class="bi bi-check-circle me-1"></i>Program ✓
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-green-lt text-green border border-green p-2">
                                <i class="bi bi-check-circle me-1"></i>Kegiatan ✓
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-green-lt text-green border border-green p-2">
                                <i class="bi bi-check-circle me-1"></i>Sub-Kegiatan ✓
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-green-lt text-green border border-green p-2">
                                <i class="bi bi-check-circle me-1"></i>Rekening Belanja ✓
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-green-lt text-green border border-green p-2">
                                <i class="bi bi-check-circle me-1"></i>Stage "APBD Murni" ✓
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-red-lt text-red border border-red p-2">
                                <i class="bi bi-x-circle me-1"></i>Pagu DPA ✗
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function konfirmasiTambah(event) {
    event.preventDefault();
    const tahun = document.getElementById('inputTahun').value;
    if (!tahun) return false;

    Swal.fire({
        title: `Buat Tahun Anggaran ${tahun}?`,
        html: `Sistem akan menyalin struktur program, kegiatan, sub-kegiatan, dan rekening belanja dari tahun sebelumnya.<br><br>
               <span class="text-danger fw-bold">Pagu anggaran (DPA) tidak akan tersalin</span> dan harus diisi ulang.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `<i class="bi bi-check-lg me-1"></i> Ya, Buat`,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('btnTambah').disabled = true;
            document.getElementById('btnTambah').innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
            event.target.submit();
        }
    });

    return false;
}
</script>
@endpush
