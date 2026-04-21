@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary">Input Jurnal Transaksi Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Bukti</label>
                    <input type="text" name="evidence_number" class="form-control" placeholder="A-xx-xxx">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Uraian / Keterangan</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <hr>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Simpan Transaksi</button>
                <button type="reset" class="btn btn-secondary px-4">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection