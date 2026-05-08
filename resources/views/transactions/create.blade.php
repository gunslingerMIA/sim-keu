@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none">

        <div class="container-xl">
            <ol class="breadcrumb mb-3" aria-label="breadcrumbs">
                <li class="breadcrumb-item">
                    <a href="{{ route('transactions.index') }}">Transaksi</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('transactions.add') }}">Input Jurnal Transaksi</a>
                </li>
            </ol>
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus me-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M12 11v6" />
                            <path d="M9 14h6" />
                        </svg>
                        Input Jurnal Transaksi
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            {{-- Alert Error jika validasi gagal --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="9" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg></div>
                        <div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm border-top border-primary border-3">
                    <div class="card-body">
                        <div class="row g-4">
                            {{-- SEKTOR ATAS: IDENTITAS --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">ID Transaksi</label>
                                <input type="text" class="form-control bg-light fw-bold" name="pkjur"
                                    value="B{{ date('ymdHis') }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Jenis Jurnal</label>
                                <select class="form-select" name="type">
                                    <option value="JKK">Jurnal Kas Keluar (JKK)</option>
                                    <option value="JKM">Jurnal Kas Masuk (JKM)</option>
                                    <option value="JAK">Jurnal Antar Kas (JAK)</option>
                                    <option value="JU" selected>Jurnal Umum (JU)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">No. Bukti</label>
                                <input type="text" class="form-control" name="nobukti" value="{{ old('nobukti') }}"
                                    placeholder="Contoh: 001/SPJ/2026" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Uraian / Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="2" value=""
                                    placeholder="Masukkan detail transaksi..." required>{{ old('keterangan') }}</textarea>
                            </div>

                            {{-- SEKTOR BAWAH: AKUNTANSI --}}
                            <div class="col-12">
                                <div class="p-4 bg-primary-lt border border-primary rounded-3">
                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Akun Debit</label>
                                            <div class="input-group">
                                                <input type="text" id="debit_display" class="form-control" readonly
                                                    placeholder="Pilih Akun Debit...">
                                                <input type="hidden" name="debit_account_id" id="debit_account_id">
                                                <input type="hidden" name="sub_activity_id" id="sub_activity_id">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="openModal('debit')">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Akun Kredit</label>
                                            <div class="input-group">
                                                <input type="text" id="kredit_display" class="form-control" readonly
                                                    placeholder="Pilih Akun Kredit...">
                                                <input type="hidden" name="kredit_account_id" id="kredit_account_id">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="openModal('kredit')">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Nominal Transaksi</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" value="{{ old('amount') }}"
                                                    class="form-control form-control-lg fw-bold text-end" name="amount"
                                                    placeholder="0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end gap-2">
                        <a href="{{ route('transactions.index') }}" class="btn btn-link link-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-5">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-device-floppy me-1" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                <circle cx="12" cy="14" r="2" />
                                <polyline points="14 4 14 8 8 8 8 4" />
                            </svg>
                            Simpan Jurnal Transaksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
                            placeholder="Cari Kode atau Nama...">
                    </div>
                    <div class="table-responsive" style="max-height: 450px;">
                        <table class="table table-vcenter table-hover" id="account_table">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
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
                                                class="badge {{ $opt['kelompok'] == 'Belanja' ? 'bg-blue-lt' : 'bg-green-lt' }}">
                                                {{ $opt['kelompok'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-muted small">{{ $opt['kode'] }}</div>
                                            <div>{{ $opt['display'] }}</div>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary">Pilih</button>
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
        let currentSide = 'debit'; // Penanda apakah sedang pilih debit atau kredit

        function openModal(side) {
            currentSide = side;
            const rows = document.querySelectorAll('.account-row');

            rows.forEach(row => {
                const kelompok = row.getAttribute('data-kelompok');

                if (currentSide === 'kredit') {
                    // Jika KREDIT, sembunyikan yang kategori Belanja
                    row.style.display = (kelompok === 'belanja') ? 'none' : '';
                } else {
                    // Jika DEBIT, tampilkan semua (karena debit bisa belanja atau pindah kas)
                    row.style.display = '';
                }
            });

            const myModal = new bootstrap.Modal(document.getElementById('modal-search-account'));
            myModal.show();

            setTimeout(() => {
                document.getElementById('table_filter').value = ''; // Reset filter teks
                document.getElementById('table_filter').focus();
            }, 500);
        }

        function selectAccount(accountId, subId, displayText) {
            if (currentSide === 'debit') {
                document.getElementById('debit_account_id').value = accountId;
                document.getElementById('sub_activity_id').value = subId; // ID Sub Kegiatan hanya untuk debit
                document.getElementById('debit_display').value = displayText;
            } else {
                document.getElementById('kredit_account_id').value = accountId;
                document.getElementById('kredit_display').value = displayText;
            }

            // Tutup modal secara manual
            const modalElement = document.getElementById('modal-search-account');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
        }

        // Fitur Filter Pencarian Tabel
        document.getElementById('table_filter').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#account_table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const kelompok = row.getAttribute('data-kelompok'); // Pastikan atribut ini ada

                // Logika Pencocokan Teks
                const isMatch = text.includes(value);

                // Logika Filter Kredit (Jika sedang di sisi kredit, belanja tetap harus mati)
                let isAllowed = true;
                if (currentSide === 'kredit' && kelompok === 'belanja') {
                    isAllowed = false;
                }

                // Baris hanya tampil jika (Teks Cocok) DAN (Kategori Diizinkan)
                if (isMatch && isAllowed) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

@endsection
