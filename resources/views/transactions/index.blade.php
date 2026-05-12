@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <ol class="breadcrumb mb-3" aria-label="breadcrumbs">
                <li class="breadcrumb-item active">
                    <a href="{{ route('transactions.index') }}">Transaksi / </a>
                </li>
            </ol>
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book me-2" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                            <line x1="3" y1="6" x2="3" y2="19" />
                            <line x1="12" y1="6" x2="12" y2="19" />
                            <line x1="21" y1="6" x2="21" y2="19" />
                        </svg>
                        Jurnal Transaksi
                    </h2>
                    <div class="text-muted small mt-1">Daftar mutasi kas dan realisasi anggaran tahun {{ $tahun }}
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('transactions.add') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped table-hover" id="table">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 10%">Tanggal</th>
                                <th style="width: 5%">Tipe</th>
                                <th style="width: 25%">No. Bukti / Keterangan</th>
                                <th style="width: 25%">Debit (Penerima/Belanja)</th>
                                <th style="width: 25%">Kredit (Sumber Dana)</th>
                                <th class="text-end" style="width: 10%">Jumlah</th>
                                <th class="text-center" style="width: 5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $t)
                                <tr>
                                    <td class="text-nowrap fw-bold">
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $badgeColor =
                                                [
                                                    'JKK' => 'bg-red-lt',
                                                    'JKM' => 'bg-green-lt',
                                                    'JAK' => 'bg-azure-lt',
                                                    'JU' => 'bg-secondary-lt',
                                                ][$t->type] ?? 'bg-gray-lt';
                                        @endphp
                                        <span class="badge {{ $badgeColor }}">{{ $t->type }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-azure">{{ $t->nobukti }}</div>
                                        <div class="text-muted small lh-sm">{{ $t->keterangan }}</div>
                                    </td>
                                    <td>
                                        {{-- Menampilkan Akun Debit & Sub Kegiatan jika ada --}}
                                        <div class="fw-bold text-uppercase" style="font-size: 0.75rem">
                                            {{ $t->debitAccount->nama_rekening ?? 'N/A' }}
                                        </div>
                                        @if ($t->subActivity)
                                            <div class="text-muted x-small italic" style="font-size: 0.7rem">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-corner-down-right-double"
                                                    width="12" height="12" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 5v6a3 3 0 0 0 3 3h7" />
                                                    <path d="M10 10l4 4l-4 4m5 -8l4 4l-4 4" />
                                                </svg>
                                                {{ $t->subActivity->nama_sub_kegiatan }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Menampilkan Akun Kredit --}}
                                        <div class="fw-bold text-uppercase" style="font-size: 0.75rem">
                                            {{ $t->kreditAccount->nama_rekening ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-dark">
                                        {{ number_format($t->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="">
                                        <button class="btn btn-sm btn-warning" onclick="openEditModal(this)"
                                            data-id="{{ $t->id }}" data-tanggal="{{ $t->tanggal }}"
                                            data-nobukti="{{ $t->nobukti }}" data-keterangan="{{ $t->keterangan }}"
                                            data-debit_id="{{ $t->account_debit }}"
                                            data-kredit_id="{{ $t->account_kredit }}"
                                            data-sub_id="{{ $t->sub_activity_id }}" data-jumlah="{{ $t->jumlah }}"
                                            data-debit_display="{{ optional($t->subActivity)->nama_sub_kegiatan ? $t->subActivity->nama_sub_kegiatan . ' - ' : '' }}{{ $t->debitAccount->nama_rekening ?? 'N/A' }}"
                                            data-kredit_display="{{ $t->kreditAccount->nama_rekening }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="{{ url('/transactions/delete/' . $t->id) }}"
                                            class="btn btn-sm btn-danger" title="Hapus Transaksi"
                                            onclick="confirmDelete(event, this.href)"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="card-footer d-flex align-items-center">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-edit-transaction" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="form-edit-transaction" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">No. Bukti</label>
                            <input type="text" name="nobukti" id="edit_nobukti" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Debit</label>
                            <div class="input-group">
                                <input type="text" id="edit_debit_display" class="form-control" readonly>
                                <input type="hidden" name="debit_account_id" id="edit_debit_id">
                                <input type="hidden" name="sub_activity_id" id="edit_sub_id">
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="openSearchModal('debit', 'edit')">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Kredit</label>
                            <div class="input-group">
                                <input type="text" id="edit_kredit_display" class="form-control" readonly>
                                <input type="hidden" name="kredit_account_id" id="edit_kredit_id">
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="openSearchModal('kredit', 'edit')">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="number" name="amount" id="edit_jumlah" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

        function openSearchModal(side) {
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

        function openEditModal(btn) {
            console.log(btn.dataset); // Debug: Pastikan data atribut tersedia
            const data = btn.dataset; // Mengambil semua data-* atribut

            // 1. Set URL Action Form
            const form = document.getElementById('form-edit-transaction');
            form.action = `/transactions/update/${data.id}`;

            // 2. Isi Input
            document.getElementById('edit_nobukti').value = data.nobukti;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_jumlah').value = data.jumlah;
            document.getElementById('edit_keterangan').value = data.keterangan;

            // 3. Isi Rekening & Hidden ID
            document.getElementById('edit_debit_id').value = data.debit_id;
            document.getElementById('edit_kredit_id').value = data.kredit_id;
            document.getElementById('edit_sub_id').value = data.sub_id;
            document.getElementById('edit_debit_display').value = data.debit_display;
            document.getElementById('edit_kredit_display').value = data.kredit_display;

            // 4. Tampilkan Modal
            new bootstrap.Modal(document.getElementById('modal-edit-transaction')).show();
        }

        function selectAccount(accountId, subId, displayText) {
            console.log(accountId, subId, displayText); // Debug: Pastikan data yang dipilih benar
            if (currentSide === 'debit') {
                document.getElementById('edit_debit_id').value = accountId;
                document.getElementById('edit_sub_id').value = subId; // ID Sub Kegiatan hanya untuk debit
                document.getElementById('edit_debit_display').value = displayText;
            } else {
                document.getElementById('edit_kredit_id').value = accountId;
                document.getElementById('edit_kredit_display').value = displayText;
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



        function confirmDelete(event, url) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Transaksi yang sudah dihapus tidak bisa dikembalikan!",
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
            })
        }
    </script>
@endsection
