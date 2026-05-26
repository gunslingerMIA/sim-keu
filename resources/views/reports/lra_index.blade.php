@extends('layouts.app')

@section('content')
    @push('after_style')
        <style>
            /* ======================== BINDING PREVIEW LAYOUT DI LAYAR MONITOR ======================== */
            .table-lra {
                border: 1px solid #000 !important;
                border-collapse: collapse !important;
            }

            .table-lra th,
            .table-lra td {
                border: 1px solid #000 !important;
                padding: 5px 8px !important;
                vertical-align: middle;
            }

            .row-program {
                background-color: #e9ecef !important;
                font-weight: bold;
            }

            .row-kegiatan {
                background-color: #f8f9fa !important;
                font-weight: bold;
            }

            .row-subkegiatan {
                font-weight: bold;
                font-style: italic;
            }

            .row-rekening {
                font-weight: normal;
            }

            .row-detail-transaksi {
                background-color: #fffdf0 !important;
                font-size: 11px;
                font-style: italic;
            }

            .indent-kegiatan {
                padding-left: 25px !important;
            }

            .indent-subkegiatan {
                padding-left: 45px !important;
            }

            .indent-rekening {
                padding-left: 65px !important;
            }

            .indent-detail {
                padding-left: 85px !important;
            }

            /* ======================== RACIKAN ENGINE@MEDIA PRINT (PDF / KERTAS) ======================== */
            @media print {

                /* 1. Paksa Orientasi Kertas Otomatis LANDSCAPE & Atur Margin Sisi Kosong Kertas */
                @page {
                    size: landscape;
                    margin: 15mm 10mm 15mm 10mm;
                }

                /* 2. JEBOL TOTAL Kunci Tinggi & Scroll Layout Tabler dari File Master */
                html,
                body {
                    background: #fff !important;
                    color: #000 !important;
                    height: auto !important;
                    overflow: visible !important;
                }

                /* Hancurkan paksa flexbox 100vh milik '.page' dan '.content-area' pembungkus utama dashboard */
                .page,
                .content-area,
                .page-body,
                .container-xl,
                .card,
                .card-body,
                .page-content {
                    display: block !important;
                    /* Ubah flex/row menjadi block mengalir ke bawah */
                    position: static !important;
                    height: auto !important;
                    min-height: auto !important;
                    overflow: visible !important;
                    overflow-x: visible !important;
                    overflow-y: visible !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    border: none !important;
                    box-shadow: none !important;
                    width: 100% !important;
                }

                /* 3. SEMBUNYIKAN SIDEBAR FIXED & NAV ELEMEN BAWAAN LAYOUT MASTER */
                .sidebar-fixed,
                .sidebar-backdrop,
                header.navbar,
                .d-print-none,
                #sidebarBackdrop {
                    display: none !important;
                    visibility: hidden !important;
                    width: 0 !important;
                    height: 0 !important;
                }

                /* 4. AUTO SCALING: Paksa Lebar Tabel Mengunci Sesuai Batas Lebar Kertas */
                .table-responsive {
                    overflow: visible !important;
                    overflow-x: visible !important;
                    width: 100% !important;
                }

                .table-lra {
                    width: 100% !important;
                    table-layout: fixed !important;
                    /* Kolom patuh pada width % */
                    page-break-inside: auto !important;
                }

                /* 5. REPEAT HEADER: Buat judul kolom berulang otomatis di atas halaman baru */
                .table-lra thead {
                    display: table-header-group !important;
                }

                .table-lra tr {
                    page-break-inside: avoid !important;
                    /* Teks baris anti terpotong di tengah kertas */
                    page-break-after: auto !important;
                }

                /* Pertahankan Ketajaman Warna Cetak Komponen Anggaran Dinas */
                .table-lra th {
                    background-color: #2f4f4f !important;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                .row-program {
                    background-color: #e9ecef !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                .row-kegiatan {
                    background-color: #f8f9fa !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                .row-detail-transaksi {
                    background-color: #fffdf0 !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                .table-lra th,
                .table-lra td {
                    border: 1px solid #000 !important;
                    padding: 5px 8px !important;
                    vertical-align: middle;

                    /* Tambahkan 2 baris di bawah ini agar teks otomatis wrap rapi */
                    white-space: normal !important;
                    word-break: break-word !important;
                }
            }
        </style>
    @endpush

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Laporan Realisasi Anggaran (LRA)</h2>
                </div>
                <div class="col-auto ms-auto">
                    <button type="button" onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer me-2"></i> Cetak LRA
                    </button>
                    <a href="{{ route('reports.lra.export', ['end_date' => $end, 'jenis_lra' => $jenisLra]) }}"
                        class="btn btn-success">
                        <i class="bi bi-file-earmark-excel me-2"></i> Ekspor Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            {{-- Card Filter & Opsi Tampilan --}}
            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form action="{{ route('reports.lra') }}" method="GET">
                        <div class="row align-items-end g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Per Tanggal Batas (*Cut-off*)</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Tampilan LRA</label>
                                <select name="jenis_lra" class="form-select">
                                    <option value="ringkas" {{ $jenisLra == 'ringkas' ? 'selected' : '' }}>LRA Ringkas
                                        (Sampai Rekening)</option>
                                    <option value="rinci" {{ $jenisLra == 'rinci' ? 'selected' : '' }}>LRA Rinci (Detail
                                        Transaksi Muncul)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-arrow-clockwise me-2"></i> Proses Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Area Lembar Cetak LRA --}}
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="mb-1 text-uppercase">LAPORAN REALISASI ANGGARAN BELANJA</h3>
                        <h4 class="mb-1 text-muted">DPMPTSP KOTA PEKALONGAN</h4>
                        <p class="mb-0 small">Tahun Anggaran: {{ $tahunAnggaran }} | Posisi s.d Tanggal:
                            {{ date('d/m/Y', strtotime($end)) }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-lra">
                            <thead class="text-white text-center fw-bold" style="background-color: #2f4f4f;">
                                <tr>
                                    <th width="15%">KODE</th>
                                    <th>URAIAN PROGRAM / KEGIATAN / SUB-KEGIATAN / REKENING</th>
                                    <th width="15%">PAGU ANGGARAN</th>
                                    <th width="15%">REALISASI (DEBIT)</th>
                                    <th width="15%">SISA ANGGARAN</th>
                                    <th width="8%">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- LEVEL 1: LOOP PROGRAM --}}
                                @forelse($processedData as $p)
                                    <tr class="row-program">
                                        <td>{{ $p->kode_program }}</td>
                                        <td>{{ $p->nama_program }}</td>
                                        <td class="text-end">Rp {{ number_format($p->total_pagu, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($p->total_realisasi, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($p->total_sisa, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format($p->total_persen, 2, ',', '.') }}%</td>
                                    </tr>

                                    {{-- LEVEL 2: LOOP KEGIATAN --}}
                                    @foreach ($p->activities as $act)
                                        <tr class="row-kegiatan">
                                            <td>{{ $act->kode_kegiatan }}</td>
                                            <td class="indent-kegiatan">{{ $act->nama_kegiatan }}</td>
                                            <td class="text-end">Rp {{ number_format($act->total_pagu, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($act->total_realisasi, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">Rp {{ number_format($act->total_sisa, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ number_format($act->total_persen, 2, ',', '.') }}%
                                            </td>
                                        </tr>

                                        {{-- LEVEL 3: LOOP SUB-KEGIATAN --}}
                                        @foreach ($act->subActivities as $sub)
                                            <tr class="row-subkegiatan">
                                                <td>{{ $sub->kode_sub_kegiatan }}</td>
                                                <td class="indent-subkegiatan">{{ $sub->nama_sub_kegiatan }}</td>
                                                <td class="text-end">Rp {{ number_format($sub->total_pagu, 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp
                                                    {{ number_format($sub->total_realisasi, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($sub->total_sisa, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($sub->total_persen, 2, ',', '.') }}%</td>
                                            </tr>

                                            {{-- LEVEL 4: LOOP REKENING BELANJA (BUDGET DATA) --}}
                                            @foreach ($sub->budgets as $b)
                                                <tr class="row-rekening">
                                                    <td class="text-muted small">{{ $b->account->kode_rekening }}</td>
                                                    <td class="indent-rekening text-primary fw-bold">
                                                        {{ $b->account->nama_rekening }}</td>
                                                    <td class="text-end">Rp
                                                        {{ number_format($b->pagu_murni, 0, ',', '.') }}</td>
                                                    <td class="text-end text-azure">Rp
                                                        {{ number_format($b->realisasi, 0, ',', '.') }}</td>
                                                    <td class="text-end">Rp {{ number_format($b->sisa, 0, ',', '.') }}</td>
                                                    <td class="text-center fw-bold">
                                                        {{ number_format($b->persen, 2, ',', '.') }}%</td>
                                                </tr>

                                                {{-- LEVEL 5 (OPSIONAL): DETAIL TRANSAKSI UNTUK LRA RINCI --}}
                                                @if ($jenisLra == 'rinci')
                                                    @forelse($b->transactions as $t)
                                                        <tr class="row-detail-transaksi">
                                                            <td class="text-center text-muted">
                                                                {{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                                                            <td class="indent-detail">
                                                                <strong>[{{ $t->nobukti }}]</strong> -
                                                                {{ $t->keterangan }}
                                                                @if ($t->kreditAccount)
                                                                    <span class="text-muted small">(Lawan:
                                                                        {{ $t->kreditAccount->nama_rekening }})</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-end text-muted">-</td>
                                                            <td class="text-end text-dark">Rp
                                                                {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                                            <td class="text-end text-muted">-</td>
                                                            <td class="text-muted text-center">-</td>
                                                        </tr>
                                                    @empty
                                                        <tr class="row-detail-transaksi text-muted text-center">
                                                            <td></td>
                                                            <td colspan="5"
                                                                class="text-start indent-detail text-danger small">* Belum
                                                                ada realisasi pengeluaran untuk rekening belanja ini.</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data program
                                                anggaran di tahun ini.</td>
                                        </tr>
                                    @endforelse {{-- <-- SUDAH DIPERBAIKI --}}

                                    {{-- BARIS GRAND TOTAL SKPD --}}
                                    <tr class="fw-bold fs-3 text-white" style="background-color: #1a365d; ...">
                                        <td colspan="2" class="text-center text-uppercase">TOTAL REALISASI BELANJA SKPD</td>
                                        <td class="text-end">Rp {{ number_format($grandPagu, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($grandRealisasi, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($grandSisa, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format($grandPersen, 2, ',', '.') }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
