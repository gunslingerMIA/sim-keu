@extends('layouts.app')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <h2 class="page-title text-primary">Input Jurnal Transaksi</h2>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="row row-cards">
                    {{-- KIRI: INFORMASI UTAMA --}}
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">ID Transaksi</label>
                                        <input type="text" class="form-control bg-light" name="batch_id"
                                            value="B{{ date('ymdHis') }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Jurnal</label>
                                        <select class="form-select" name="type" id="type">
                                            <option value="JU">Jurnal Umum</option>
                                            <option value="JKM">Jurnal Kas Masuk</option>
                                            <option value="JKK" selected>Jurnal Kas Keluar</option>
                                            <option value="JAK">Jurnal Antar Kas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="date"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Bukti</label>
                                        <input type="text" class="form-control" name="evidence_number" placeholder="#M#">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Uraian / Keterangan</label>
                                        <textarea class="form-control" name="description" rows="2"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 bg-primary-lt border border-primary rounded">
                                            <label class="form-label fw-bold text-primary">DEBIT</label>
                                            <select class="form-select mb-2" name="account_id" id="account_debit_select">
                                                <option value="">-- Pilih Rekening Debit --</option>
                                                @foreach ($allOptions as $option)
                                                    <option value="{{ $option['id'] }}"
                                                        data-sub="{{ $option['sub_activity_id'] }}">
                                                        {{ $option['display'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="sub_activity_id" id="sub_activity_id_hidden">

                                            <hr class="my-2">

                                            <label class="form-label fw-bold text-danger">KREDIT</label>
                                            <select class="form-select" name="cash_account_id" id="account_kredit_select">
                                                <option value="">-- Pilih Rekening Kredit --</option>
                                                @foreach ($nonBudgetData as $option)
                                                    {{-- Kita tampilkan semua, nanti di-disable lewat JS jika dipilih di debit --}}
                                                    <option value="{{ $option['id'] }}">
                                                        {{ $option['display'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-3" id="save_transaction_btn">Simpan Jurnal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT KALKULASI OTOMATIS --}}
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const debitSelect = document.getElementById('account_debit_select');
            const kreditSelect = document.getElementById('account_kredit_select');
            const hiddenSubId = document.getElementById('sub_activity_id_hidden');

            debitSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                // 1. Update Sub Activity ID Hidden
                const selectedOption = this.options[this.selectedIndex];
                hiddenSubId.value = selectedOption.getAttribute('data-sub');

                // 2. Filter Dropdown Kredit
                // Reset dulu: tampilkan semua pilihan di kredit
                Array.from(kreditSelect.options).forEach(option => {
                    option.disabled = false;
                    option.style.display = 'block';
                });

                // Jika ada yang dipilih di debit, sembunyikan di kredit
                if (selectedValue) {
                    Array.from(kreditSelect.options).forEach(option => {
                        if (option.value === selectedValue) {
                            option.disabled = true;
                            option.style.display = 'none'; // Biar beneran hilang dari pandangan
                        }
                    });

                    // Jika akun yang sama sedang terpilih di kredit, reset pilihannya
                    if (kreditSelect.value === selectedValue) {
                        kreditSelect.value = '';
                    }
                }
            });
        });
    </script>
@endsection
