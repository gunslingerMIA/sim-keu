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
                            @foreach($transactions as $t)
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
                                        <a href="" class="btn btn-sm btn-azure" title="Edit Transaksi"><i
                                                class="bi bi-pencil"></i></a>
                                        <a href="{{ url('/transactions/delete/'.$t->id) }}" class="btn btn-sm btn-danger" title="Hapus Transaksi"
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

    <script>
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
