@extends('layouts.app')
@section('content')
    
<form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $transaction->tanggal }}">
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label">No. Bukti</label>
            <input type="text" name="nobukti" class="form-control" value="{{ $transaction->nobukti }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Akun Debit</label>
            <div class="input-group">
                <input type="text" id="debit_display" class="form-control" readonly 
                       value="{{ $selectedDebit['display'] ?? '' }}">
                <input type="hidden" name="debit_account_id" id="debit_account_id" value="{{ $transaction->account_debit }}">
                <input type="hidden" name="sub_activity_id" id="sub_activity_id" value="{{ $transaction->sub_activity_id }}">
                <button class="btn btn-primary" type="button" onclick="openModal('debit')"><i class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Akun Kredit</label>
            <div class="input-group">
                <input type="text" id="kredit_display" class="form-control" readonly 
                       value="{{ $selectedKredit['display'] ?? '' }}">
                <input type="hidden" name="kredit_account_id" id="kredit_account_id" value="{{ $transaction->account_kredit }}">
                <button class="btn btn-primary" type="button" onclick="openModal('kredit')"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Nominal</label>
        <input type="number" name="amount" class="form-control" value="{{ $transaction->jumlah }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control">{{ $transaction->keterangan }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Transaksi</button>
</form>

@endsection