@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="page-title text-primary">Struktur DPA SKPD</h2>
                    <small class="text-success fw-bold">
                        <i class="bi bi-calendar3 me-1"></i> Tahun Anggaran: {{ session('tahun_anggaran') }} —
                        {{ session('nama_tahapan') }}
                        @if ($stageAktif && $stageAktif->is_locked)
                            <span class="badge bg-secondary-lt text-secondary ms-1"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>
                        @else
                            <span class="badge bg-success-lt text-success ms-1"><i class="bi bi-unlock-fill me-1"></i>Bisa diedit</span>
                        @endif
                    </small>
                    <div class="mt-1">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#riwayatTahapanModal" class="small">
                            Riwayat tahapan ({{ $riwayatTahapan->count() }})
                        </a>
                        &middot;
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tambahTahapanModal" class="small text-primary fw-bold">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Tahapan
                        </a>
                    </div>
                </div>
                <div class="text-end">
                    <div class="text-muted small text-uppercase">Total Pagu Perangkat Daerah</div>
                    <div class="h2 fw-bold text-azure">Rp {{ number_format($programs->sum('total_pagu'), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- MODAL: Tambah Tahapan --}}
            <div class="modal modal-blur fade" id="tambahTahapanModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('stages.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Tahapan APBD</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-secondary">
                                    Tahapan saat ini: <strong>{{ session('nama_tahapan') }}</strong>.
                                    Membuat tahapan baru akan <strong>menyalin seluruh pagu</strong> dari tahapan ini,
                                    lalu <strong>mengunci</strong> tahapan saat ini sehingga tidak bisa diedit lagi.
                                </p>
                                <div class="mb-3">
                                    <label class="form-label">Nama Tahapan Baru</label>
                                    <input type="text" name="nama_tahapan" class="form-control" list="saranTahapan"
                                        placeholder="Contoh: Perubahan Sebelum Perubahan" required>
                                    <datalist id="saranTahapan">
                                        <option value="Perubahan Sebelum Perubahan">
                                        <option value="Perubahan APBD">
                                        <option value="Perubahan Setelah Perubahan">
                                    </datalist>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Buat Tahapan & Salin Pagu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MODAL: Riwayat Tahapan --}}
            <div class="modal modal-blur fade" id="riwayatTahapanModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Riwayat Tahapan {{ session('tahun_anggaran') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                @foreach ($riwayatTahapan as $st)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $st->urutan }}. {{ $st->nama_tahapan }}</span>
                                        <span>
                                            @if ($st->is_locked)
                                                <span class="badge bg-secondary-lt text-secondary"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>
                                            @else
                                                <span class="badge bg-success-lt text-success"><i class="bi bi-unlock-fill me-1"></i>Aktif</span>
                                            @endif
                                            @if ($st->id != session('active_stage_id'))
                                                <form action="{{ route('stages.set-active', $st->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-white ms-1">Lihat</button>
                                                </form>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INPUT SEARCH BAR --}}
            <div class="mb-3">
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="bi bi-search text-primary"></i>
                    </span>
                    <input type="text" id="dpaSearch" class="form-control form-control-rounded"
                        placeholder="Cari Kode atau Nama Sub Kegiatan... (Tekan Enter/Ketik)">
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-no-border" id="mainTable">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Kode & Uraian Struktur</th>
                                <th class="text-end" style="width: 250px;">Pagu Anggaran (Rp)</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $p)
                                {{-- LEVEL 1: PROGRAM --}}
                                <tr class="bg-primary-lt cursor-pointer fw-bold program-row" data-bs-toggle="collapse"
                                    data-bs-target="#prog-{{ $p->id }}" aria-expanded="false">
                                    <td>
                                        <i class="bi bi-chevron-right me-2 transition-icon"></i>
                                        <span class="badge bg-primary-lt me-2">{{ $p->kode_program }}</span>
                                        {{ $p->nama_program }}
                                    </td>
                                    <td class="text-end">{{ number_format($p->total_pagu, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>

                                <tr class="collapse" id="prog-{{ $p->id }}">
                                    <td colspan="3" class="p-0">
                                        <table
                                            class="table table-vcenter mb-0 border-start border-primary border-3 nested-table">
                                            <tbody>
                                                @foreach ($p->activities as $a)
                                                    {{-- LEVEL 2: KEGIATAN --}}
                                                    <tr class="bg-light cursor-pointer shadow-none activity-row"
                                                        data-bs-toggle="collapse" data-bs-target="#act-{{ $a->id }}">
                                                        <td class="ps-4">
                                                            <i class="bi bi-chevron-right me-2 transition-icon"></i>
                                                            <strong class="text-muted">{{ $a->kode_kegiatan }}</strong>
                                                            {{ $a->nama_kegiatan }}
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
                                                                    @foreach ($a->subActivities as $s)
                                                                        {{-- LEVEL 3: SUB KEGIATAN --}}
                                                                        <tr class="hover-shadow sub-activity-row">
                                                                            <td class="ps-5">
                                                                                <span class="text-muted me-2">└─</span>
                                                                                <small
                                                                                    class="text-secondary">{{ $s->kode_sub_kegiatan }}</small>
                                                                                <span
                                                                                    class="ms-2 nama-sub">{{ $s->nama_sub_kegiatan }}</span>
                                                                            </td>
                                                                            <td class="text-end fw-bold text-azure"
                                                                                style="width: 250px;">
                                                                                {{ number_format($s->total_pagu, 0, ',', '.') }}
                                                                            </td>
                                                                            <td class="pe-3">
                                                                                <a href="/budgets/rinci/{{ $s->id }}"
                                                                                    class="btn btn-sm btn-white btn-pill border-azure text-azure shadow-sm">
                                                                                    <i class="bi bi-gear-fill me-1"></i>
                                                                                    Rincian
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

    <script>
        document.getElementById('dpaSearch').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let subRows = document.querySelectorAll('.sub-activity-row');

            // Reset state: Sembunyikan semua atau tampilkan semua
            if (value === "") {
                document.querySelectorAll('.collapse').forEach(el => {
                    bootstrap.Collapse.getOrCreateInstance(el).hide();
                });
                document.querySelectorAll('tr').forEach(tr => tr.style.display = '');
                return;
            }

            // Sembunyikan semua baris dulu
            document.querySelectorAll('.program-row, .activity-row, .sub-activity-row').forEach(tr => {
                tr.style.display = 'none';
            });

            subRows.forEach(sub => {
                let text = sub.textContent.toLowerCase();
                if (text.includes(value)) {
                    // Tampilkan Sub Kegiatan yang cocok
                    sub.style.display = '';

                    // Buka "Bapak"-nya (Kegiatan)
                    let activityCollapse = sub.closest('.collapse');
                    if (activityCollapse) {
                        bootstrap.Collapse.getOrCreateInstance(activityCollapse).show();
                        let activityRow = activityCollapse.previousElementSibling;
                        if (activityRow) activityRow.style.display = '';

                        // Buka "Kakek"-nya (Program)
                        let programCollapse = activityCollapse.closest('.nested-table').closest(
                        '.collapse');
                        if (programCollapse) {
                            bootstrap.Collapse.getOrCreateInstance(programCollapse).show();
                            let programRow = programCollapse.previousElementSibling;
                            if (programRow) programRow.style.display = '';
                        }
                    }
                }
            });
        });
    </script>

    <style>
        /* ... Style Abang yang lama ... */
        .cursor-pointer {
            cursor: pointer;
        }

        .transition-icon {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        tr[aria-expanded="true"] .transition-icon {
            transform: rotate(90deg);
            color: #206bc4;
        }

        .hover-shadow:hover {
            background-color: #f1f5f9;
            transition: background-color 0.2s;
        }

        .form-control-rounded {
            border-radius: 50px;
            padding-left: 40px;
        }
    </style>
@endsection