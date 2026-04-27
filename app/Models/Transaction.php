<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'batch_id',
    'type',
    'date',
    'evidence_number',
    'description',
    'account_id',
    'sub_activity_id',
    'debit',
    'credit'
];
    //
    // Mencari nama akun dari transaksi
    public function account() {
        return $this->belongsTo(Account::class);
    }

    // Mencari nama sub-kegiatan dari transaksi
    public function subActivity() {
        return $this->belongsTo(SubActivity::class);
    }
}
