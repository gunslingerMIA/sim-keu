@extends('layouts.app')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Buku Besar Akun</h2>
                </div>
                <div class="col-auto ms-auto">
                    {{-- Tombol Cetak (Hanya muncul kalau ada data) --}}
                    {{-- <button type="button" onclick="window.print()"
                        class="btn btn-primary {{ $accounts->isEmpty() ? 'disabled' : '' }}">
                        <i class="bi bi-printer me-2"></i> Cetak Jurnal
                    </button>
                    <a href="{{ route('reports.journal.export', ['start_date' => $start, 'end_date' => $end]) }}"
                        class="btn btn-success">
                        <i class="bi bi-file-earmark-excel me-2"></i> Ekspor Excel
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            {{-- Card Filter --}}
            <div class="card mb-3 d-print-none">
                <div class="card-body">
                    <form action="{{ route('reports.ledger') }}" method="GET">
                        <div class="row mb-3 align-items-end">
                            <div class="col-md-2">
                                <label for="account_id" class="form-label">Akun</label>
                            </div>
                            <div class="col-md-10">
                                <select name="account_id" id="account_id" class="form-control">
                                    <option value="">Pilih Akun</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ $selectedAccount == $account->id ? 'selected' : '' }}>
                                            {{ $account->nama_rekening }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                                    <th width="15%" class="text-end">NO BUKTI</th>
                                    <th width="15%" class="text-end">DEBIT</th>
                                    <th width="15%" class="text-end">KREDIT</th>
                                    <th width="15%" class="text-end">SALDO</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Di dalam Loop Mutasi --}}
                                @php $currentSaldo = $saldoAwal; @endphp

                                <tr class="bg-light fw-bold">
                                    <td colspan="3" class="text-left">SALDO AWAL</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                                </tr>

                                @foreach ($mutations as $m)
                                    @php
                                        $isDebit = $m->account_debit == $selectedAccount;
                                        $debit = $isDebit ? $m->jumlah : 0;
                                        $kredit = !$isDebit ? $m->jumlah : 0;
                                        $currentSaldo += $debit - $kredit;
                                    @endphp
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($m->tanggal)) }}<br><small>{{ $m->pkjur }}</small>
                                        </td>
                                        <td>{{ $m->keterangan }} <br> <small class="text-muted">Lawan:
                                                {{ $isDebit ? $m->kreditAccount->nama_rekening : $m->debitAccount->nama_rekening }}</small>
                                        </td>
                                        <td class="text-center">{{ $m->nobukti }}</td>
                                        <td class="text-end">{{ $debit > 0 ? number_format($debit, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end">{{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end fw-bold">Rp {{ number_format($currentSaldo, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
