@extends('layouts.app')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11v6" /><path d="M9 14h6" /></svg>
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
                    <div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg></div>
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
                            <input type="text" class="form-control bg-light fw-bold" name="pkjur" value="B{{ date('ymdHis') }}" readonly>
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
                            <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">No. Bukti</label>
                            <input type="text" class="form-control" name="nobukti" value="{{ old('nobukti') }}" placeholder="Contoh: 001/SPJ/2026" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Uraian / Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2" value="" placeholder="Masukkan detail transaksi..." required>{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- SEKTOR BAWAH: AKUNTANSI --}}
                        <div class="col-12">
                            <div class="p-4 bg-primary-lt border border-primary rounded-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">1. Rekening DEBIT (Belanja/Kegiatan)</label>
                                        <select class="form-select select-search" name="account_id" id="account_debit_select" required>
                                            <option value="">-- Pilih Rekening --</option>
                                            @foreach ($allOptions as $option)
                                                <option value="{{ $option['id'] }}" data-sub="{{ $option['sub_activity_id'] }}">
                                                    {{ $option['display'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- Hidden input untuk sub_activity_id --}}
                                        <input type="hidden" name="sub_activity_id" id="sub_activity_id_hidden">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-danger">2. Rekening KREDIT (Sumber Dana)</label>
                                        <select class="form-select" name="cash_account_id" id="account_kredit_select" required>
                                            <option value="">-- Pilih Sumber Dana --</option>
                                            @foreach ($nonBudgetData as $option)
                                                <option value="{{ $option['id'] }}">
                                                    {{ $option['display'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">3. Nominal Transaksi</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" value="{{ old('amount') }}" class="form-control form-control-lg fw-bold text-end" name="amount" placeholder="0" required>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><circle cx="12" cy="14" r="2" /><polyline points="14 4 14 8 8 8 8 4" /></svg>
                        Simpan Jurnal Transaksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const debitSelect = document.getElementById('account_debit_select');
        const kreditSelect = document.getElementById('account_kredit_select');
        const hiddenSubId = document.getElementById('sub_activity_id_hidden');

        debitSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const selectedValue = this.value;
            
            // 1. Update Sub Activity ID Hidden
            hiddenSubId.value = selectedOption.getAttribute('data-sub') || '';

            // 2. Reset Kredit Select
            Array.from(kreditSelect.options).forEach(option => {
                option.disabled = false;
                option.style.display = 'block';
            });

            // 3. Filter: Jangan biarkan akun yang sama dipilih di Kredit
            if (selectedValue) {
                Array.from(kreditSelect.options).forEach(option => {
                    if (option.value === selectedValue) {
                        option.disabled = true;
                        option.style.display = 'none';
                    }
                });

                if (kreditSelect.value === selectedValue) {
                    kreditSelect.value = '';
                }
            }
        });
    });
</script>
@endsection