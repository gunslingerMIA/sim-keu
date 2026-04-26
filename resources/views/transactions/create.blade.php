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
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">ID Transaksi</label>
                                    <input type="text" class="form-control bg-light" name="batch_id" value="B{{ date('ymdHis') }}" readonly>
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
                                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
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
                                        <label class="form-label fw-bold text-primary">Sub Kegiatan & Rekening</label>
                                        <select class="form-select mb-2" name="sub_activity_id" id="sub_activity">
                                            <option value="">-- Pilih Sub Kegiatan --</option>
                                            {{-- Loop Sub Activities --}}
                                        </select>
                                        <select class="form-select" name="account_id" id="account">
                                            <option value="">-- Pilih Rekening Belanja --</option>
                                            {{-- Loop Accounts --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: NOMINAL & PAJAK --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-start border-azure border-3">
                        <div class="card-header bg-azure-lt">
                            <h3 class="card-title">Kalkulasi Pajak</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Bruto (Rp)</label>
                                <input type="number" class="form-control form-control-lg text-end fw-bold" id="jumlah" name="amount" value="0">
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input pajak-check" type="checkbox" id="ppn_check">
                                <label class="form-check-label">PPN (11%)</label>
                                <input type="number" class="form-control form-control-sm text-end bg-light mt-1" id="ppn_val" readonly value="0">
                            </div>

                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input pajak-check" type="checkbox" id="pph_check">
                                        <label class="form-check-label">PPh</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select class="form-select form-select-sm" id="pph_percent">
                                        <option value="2">21 (2%)</option>
                                        <option value="4">22 (4%)</option>
                                    </select>
                                </div>
                                <input type="number" class="form-control form-control-sm text-end bg-light mt-1" id="pph_val" readonly value="0">
                            </div>

                            <div class="h3 mt-4 mb-0 text-muted">Jumlah Bersih (Net)</div>
                            <div class="h1 fw-bold text-azure text-end" id="net_display">Rp 0</div>
                            <input type="hidden" name="net_amount" id="net_input">
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <button type="button" class="btn btn-link text-danger">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan Jurnal</button>
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
    const jumlahInput = document.getElementById('jumlah');
    const ppnCheck = document.getElementById('ppn_check');
    const pphCheck = document.getElementById('pph_check');
    const pphPercent = document.getElementById('pph_percent');
    
    function calculate() {
        let bruto = parseFloat(jumlahInput.value) || 0;
        let ppn = ppnCheck.checked ? Math.round(bruto * 0.11) : 0;
        let pph = pphCheck.checked ? Math.round(bruto * (parseFloat(pphPercent.value) / 100)) : 0;
        
        let net = bruto - ppn - pph;

        document.getElementById('ppn_val').value = ppn;
        document.getElementById('pph_val').value = pph;
        document.getElementById('net_display').innerText = 'Rp ' + net.toLocaleString('id-ID');
        document.getElementById('net_input').value = net;
    }

    [jumlahInput, ppnCheck, pphCheck, pphPercent].forEach(el => {
        el.addEventListener('input', calculate);
    });
});
</script>
@endsection