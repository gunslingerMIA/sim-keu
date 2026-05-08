@extends('layouts.app')

@section('content')
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
            <div class="card card-stacked">
                <div class="card-body">
                    <div class="text-center mb-4 d-none d-print-block">
                        <h2 class="mb-0">JURNAL TRANSAKSI</h2>
                        <p>Periode: {{ date('d/m/Y', strtotime($start)) }} - {{ date('d/m/Y', strtotime($end)) }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th width="15%">Tanggal / ID</th>
                                    <th>Uraian Rekening & Keterangan</th>
                                    <th width="15%">Debit</th>
                                    <th width="15%">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $t)
                                    {{-- Baris Utama (Debit): Tetap biarkan border top normal --}}
                                    <tr class="">
                                        <td class="fw-bold border-bottom-0 border-y-1">
                                            {{ date('d/m/Y', strtotime($t->tanggal)) }}<br><small
                                                class="text-muted">{{ $t->pkjur }}</small></td>
                                        <td class="border-bottom-0">{{ $t->debitAccount->kode_rekening }} -
                                            {{ $t->debitAccount->nama_rekening }}</td>
                                        <td class="text-end text-primary border-bottom-0">Rp
                                            {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                        <td class="bg-light border-bottom-0"></td>
                                    </tr>

                                    {{-- Baris Kredit: Hilangkan border top agar menyatu dengan baris di atasnya --}}
                                    <tr>
                                        <td class="border-0"></td>
                                        <td class="ps-4 border-y-0"><em>{{ $t->kreditAccount->kode_rekening }} -
                                                {{ $t->kreditAccount->nama_rekening }}</em></td>
                                        <td class="bg-light border-y-0"></td>
                                        <td class="text-end text-success border-y-0">Rp
                                            {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                    </tr>

                                    {{-- Baris Keterangan: Hilangkan border top, tapi biarkan border bottom untuk pemisah antar transaksi --}}
                                    <tr>
                                        <td class="border-top-0"></td>
                                        <td class="small text-muted border-top-0">
                                            Ket: {{ $t->keterangan }} <br>
                                            <strong>Bukti: {{ $t->nobukti }}</strong>
                                        </td>
                                        <td class="border-top-0"></td>
                                        <td class="border-top-0"></td>
                                    </tr>
                                @empty
                                    {{-- ... data kosong ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
