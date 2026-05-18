@extends('layouts.app')

@section('content')
    {{-- Cari nama display akun yang sedang terpilih untuk mempertahankan teks setelah reload --}}
    @php
        $currentDisplay = '';
        if ($selectedAccount) {
            $matched = $allOptions->first(function ($item) use ($selectedAccount, $selectedSubActivityId) {
                return $item['id'] == $selectedAccount && $item['sub_activity_id'] == $selectedSubActivityId;
            });
            $currentDisplay = $matched ? $matched['display'] : '';
        }
    @endphp

    @push('after_style')
        <style>
            /* Standar border kolom vertikal Buku Besar agar tegas di layar */
            .table-jurnal {
                border: 1px solid #000 !important;
                border-collapse: collapse !important;
                width: 100%;
            }

            .table-jurnal th,
            .table-jurnal td {
                border-left: 1px solid #000 !important;
                border-right: 1px solid #000 !important;
                padding: 6px 8px !important;
                vertical-align: top;
            }

            .table-jurnal thead th {
                border-top: 1px solid #000 !important;
                border-bottom: 1px solid #000 !important;
                background-color: #f8f9fa !important;
                text-align: center;
                font-weight: bold;
            }

            .table-jurnal tr.row-start {
                border-top: 1px solid #dee2e6 !important;
            }

            /* --- PENGATURAN KHUSUS SAAT PRINT --- */
            @media print {

                /* 1. Sembunyikan elemen dashboard Tabler */
                .d-print-none,
                .page-header,
                .navbar,
                .footer {
                    display: none !important;
                }

                /* 2. Bersihkan layout card */
                .card,
                .card-body {
                    border: none !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }

                body {
                    background: #fff !important;
                    color: #000 !important;
                }

                /* 3. Perbaikan Utama: Mengecilkan tampilan tabel (Font & Jarak Sel) */
                .table-jurnal {
                    font-size: 11px !important;
                    /* Setel ke 11px atau 10px sesuai tingkat kerapatan yang Abang mau */
                    border: 1px solid #000 !important;
                }

                .table-jurnal th,
                .table-jurnal td {
                    border: 1px solid #000 !important;
                    /* Memastikan semua garis tercetak hitam tegas di kertas */
                    padding: 4px 6px !important;
                    /* Mengecilkan padding/jarak sel agar tidak boros ruang vertikal */
                }

                .table-jurnal thead th {
                    background-color: #f2f2f2 !important;
                    /* Warna abu-abu tipis transparan untuk header saat print */
                    -webkit-print-color-adjust: exact;
                    /* Memaksa browser memunculkan warna background saat diprint */
                    print-color-adjust: exact;
                }
            }
        </style>
    @endpush

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Buku Besar Akun</h2>
                </div>
                <div class="col-auto ms-auto">
                    {{-- Tombol Cetak & Ekspor (Hanya aktif jika mutasi tidak kosong) --}}
                    <button type="button" onclick="window.print()"
                        class="btn btn-primary {{ empty($mutations) ? 'disabled' : '' }}">
                        <i class="bi bi-printer me-2"></i> Cetak Buku Besar
                    </button>
                    {{-- TOMBOL EKSPOR EXCEL (AKTIFKAN INI) --}}
                    <a href="{{ route('reports.ledger.export', [
                        'account_id' => $selectedAccount,
                        'sub_activity_id' => $selectedSubActivityId,
                        'start_date' => $start,
                        'end_date' => $end,
                    ]) }}"
                        class="btn btn-success {{ !$selectedAccount ? 'disabled' : '' }}">
                        <i class="bi bi-file-earmark-excel me-2"></i> Ekspor Excel
                    </a>
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
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-2">
                                <label for="display" class="form-label fw-bold mb-0">Pilih Rekening</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    {{-- Perbaikan: Tambahkan atribut 'name' agar data terkirim ke Controller --}}
                                    <input type="hidden" name="account_id" id="account_id" value="{{ $selectedAccount }}">
                                    <input type="hidden" name="sub_activity_id" id="sub_activity_id"
                                        value="{{ $selectedSubActivityId }}">

                                    <input type="text" id="display" class="form-control bg-white fw-bold text-primary"
                                        placeholder="Klik di sini untuk memilih akun belanja atau non-belanja..." readonly
                                        value="{{ $currentDisplay }}" onclick="openModal()" style="cursor: pointer;">
                                    <button class="btn btn-primary" type="button" onclick="openModal()">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
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
                                <button type="submit"
                                    class="btn btn-outline-primary w-100 {{ !$selectedAccount ? 'disabled' : '' }}"
                                    id="btn-filter">
                                    <i class="bi bi-filter me-2"></i> Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Area Cetak Dokumen / Hasil Preview --}}
            <div class="card">
                <div class="card-body">
                    @if ($selectedAccount)
                        <div class="text-center mb-4">
                            <h3 class="mb-1 text-uppercase">BUKU BESAR AKUN</h3>
                            <h4 class="mb-1 text-muted">{{ $currentDisplay }}</h4>
                            <p class="mb-0 small">Periode: {{ date('d/m/Y', strtotime($start)) }} -
                                {{ date('d/m/Y', strtotime($end)) }}</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-jurnal">
                                <thead>
                                    <tr>
                                        <th width="12%">TANGGAL / ID</th>
                                        <th>URAIAN TRANSAKSI & KETERANGAN</th>
                                        <th width="12%">NO BUKTI</th>
                                        <th width="15%" class="text-end">DEBIT</th>
                                        <th width="15%" class="text-end">KREDIT</th>
                                        <th width="15%" class="text-end">SALDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Menampilkan Baris Saldo Awal --}}
                                    @php $currentSaldo = $saldoAwal; @endphp
                                    <tr class="bg-light fw-bold"
                                        style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                        <td class="text-center">-</td>
                                        <td colspan="2">SALDO AWAL SEBELUM PERIODE</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end text-dark">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
                                    </tr>

                                    {{-- Loop Mutasi Transaksi --}}
                                    @forelse ($mutations as $m)
                                        @php
                                            $isDebit = $m->account_debit == $selectedAccount;
                                            $debit = $isDebit ? $m->jumlah : 0;
                                            $kredit = !$isDebit ? $m->jumlah : 0;
                                            $currentSaldo += $debit - $kredit;
                                        @endphp
                                        <tr class="row-start">
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($m->tanggal)) }}<br>
                                                <small class="text-muted">{{ $m->pkjur }}</small>
                                            </td>
                                            <td>
                                                @if ($m->subActivity && !$selectedSubActivityId)
                                                    <div class="small fw-bold text-uppercase text-azure mb-1">
                                                        {{ $m->subActivity->nama_sub_kegiatan }}
                                                    </div>
                                                @endif
                                                <div>{{ $m->keterangan }}</div>
                                                <small class="text-muted text-italic">
                                                    Lawan:
                                                    {{ $isDebit ? $m->kreditAccount->nama_rekening ?? 'N/A' : $m->debitAccount->nama_rekening ?? 'N/A' }}
                                                </small>
                                            </td>
                                            <td class="text-center small">{{ $m->nobukti }}</td>
                                            <td class="text-end text-primary">
                                                {{ $debit > 0 ? 'Rp ' . number_format($debit, 0, ',', '.') : '-' }}</td>
                                            <td class="text-end text-success">
                                                {{ $kredit > 0 ? 'Rp ' . number_format($kredit, 0, ',', '.') : '-' }}</td>
                                            <td class="text-end fw-bold text-dark">Rp
                                                {{ number_format($currentSaldo, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="row-start" style="border-bottom: 1px solid #000;">
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                Tidak ditemukan mutasi transaksi untuk akun ini pada periode terpilih.
                                            </td>
                                        </tr>
                                    @endforelse

                                    {{-- Baris Penutup Akhir Kumulatif --}}
                                    @if (!empty($mutations))
                                        <tr class="bg-light fw-bold"
                                            style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                            <td colspan="3" class="text-center">SALDO AKHIR PERIODE COMPILATION</td>
                                            <td class="text-end">-</td>
                                            <td class="text-end">-</td>
                                            <td class="text-end text-dark">Rp
                                                {{ number_format($currentSaldo, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-info-circle display-4 mb-3 d-block text-secondary"></i>
                            <p class="mb-0 fw-bold">Silakan pilih rekening terlebih dahulu untuk menampilkan data Buku
                                Besar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Search Akun --}}
    <div class="modal modal-blur fade" id="modal-search-account" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Rekening / Anggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon"><i class="bi bi-search"></i></span>
                        <input type="text" id="table_filter" class="form-control"
                            placeholder="Cari Kode atau Nama Anggaran...">
                    </div>
                    <div class="table-responsive" style="max-height: 450px;">
                        <table class="table table-vcenter table-hover" id="account_table">
                            <thead>
                                <tr>
                                    <th width="15%">Kategori</th>
                                    <th>Kode & Rekening</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allOptions as $opt)
                                    <tr class="account-row" data-kelompok="{{ $opt['kelompok'] }}"
                                        onclick="selectAccount('{{ $opt['id'] }}', '{{ $opt['sub_activity_id'] }}', '{{ $opt['display'] }}')"
                                        style="cursor:pointer">
                                        <td>
                                            <span
                                                class="badge {{ $opt['kelompok'] == 'belanja' ? 'bg-blue-lt' : 'bg-green-lt' }}">
                                                {{ $opt['kelompok'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted small fw-bold">{{ $opt['kode'] }}</div>
                                            <div>{{ $opt['display'] }}</div>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-primary">Pilih</button>
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

    <script>
        function openModal() {
            var modal = new bootstrap.Modal(document.getElementById('modal-search-account'));
            modal.show();
        }

        // Realtime pencarian di dalam modal tabel akun
        document.getElementById('table_filter').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#account_table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        function selectAccount(accountId, subId, displayText) {
            document.getElementById('account_id').value = accountId;
            document.getElementById('display').value = displayText;

            // Perbaikan: Bersihkan sisa nilai sub_activity_id jika memilih akun Non-Belanja
            if (subId && subId !== 'null' && subId !== '') {
                document.getElementById('sub_activity_id').value = subId;
            } else {
                document.getElementById('sub_activity_id').value = '';
            }

            // Aktifkan tombol filter
            document.getElementById('btn-filter').classList.remove('disabled');

            // Tutup modal secara aman
            const modalElement = document.getElementById('modal-search-account');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
        }
    </script>
@endsection
