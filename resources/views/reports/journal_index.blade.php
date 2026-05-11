@extends('layouts.app')

@section('content')
    @push('after_style')
        <style>
            /* Hilangkan background abu-abu bawaan striped atau light */
            .table-jurnal,
            .table-jurnal tbody,
            .table-jurnal tr,
            .table-jurnal td {
                background-color: #fff !important;
            }

            /* Hilangkan semua border bawaan */
            .table-jurnal {
                border-collapse: collapse !important;
            }

            .table-jurnal td,
            .table-jurnal th {
                border: none !important;
                /* Hapus semua garis sel */
                padding: 4px 8px !important;
                border-left: 1px solid #000 !important;
                /* Garis kiri */
                border-right: 1px solid #000 !important;
                /* Garis kanan */
            }

            /* Berikan garis tipis hanya di bagian bawah grup transaksi (sebagai pemisah) */
            .border-group-bottom {
                border-bottom: 1px solid #000 !important;
            }

            /* Khusus Header Tabel */
            .table-jurnal thead th {
                border-top: 1px solid #000 !important;
                border-bottom: 1px solid #000 !important;
                font-weight: bold;
               
            }

            /* Atur teks agar pas saat dicetak */
            @media print {

                .page-header,
                .navbar,
                .d-print-none {
                    display: none !important;
                }

                .card,  {
                    border: none !important;
                    box-shadow: none !important;
                }

                body {
                    background: #fff !important;
                }
            }
        </style>
    @endpush

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Jurnal Transaksi</h2>
                </div>
                <div class="col-auto ms-auto">
                    {{-- Tombol Cetak (Hanya muncul kalau ada data) --}}
                    <button type="button" onclick="window.print()"
                        class="btn btn-primary {{ $transactions->isEmpty() ? 'disabled' : '' }}">
                        <i class="bi bi-printer me-2"></i> Cetak Jurnal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            {{-- Card Filter --}}
            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form action="{{ route('reports.journal') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $start }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-filter me-2"></i> Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Area Pratinjau Jurnal --}}
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4 d-none d-print-block">
                        <h2 class="mb-0">JURNAL TRANSAKSI</h2>
                        <p>Periode: {{ date('d/m/Y', strtotime($start)) }} - {{ date('d/m/Y', strtotime($end)) }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-jurnal">
                            <thead>
                                <tr>
                                    <th width="15%">TANGGAL / ID</th>
                                    <th>URAIAN REKENING & KETERANGAN</th>
                                    <th width="15%" class="text-end">DEBIT</th>
                                    <th width="15%" class="text-end">KREDIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $t)
                                    {{-- BARIS 1: DEBIT --}}
                                    <tr>
                                        <td class="fw-bold">{{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                                        <td>{{ $t->debitAccount->kode_rekening }} - {{ $t->debitAccount->nama_rekening }}
                                        </td>
                                        <td class="text-end">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>

                                    {{-- BARIS 2: KREDIT --}}
                                    <tr>
                                        <td class="text-muted small">{{ $t->pkjur }}</td>
                                        <td class="ps-4">
                                            &nbsp;&nbsp; {{ $t->kreditAccount->kode_rekening }} -
                                            {{ $t->kreditAccount->nama_rekening }}
                                        </td>
                                        <td></td>
                                        <td class="text-end">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                    </tr>

                                    {{-- BARIS 3: KETERANGAN --}}
                                    <tr class="border-group-bottom">
                                        <td></td>
                                        <td class="small">
                                            Ket: {{ $t->keterangan }} <br>
                                            Bukti: {{ $t->nobukti }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
