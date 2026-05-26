<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Budget extends Model
{
    

    protected $fillable = [
        'sub_activity_id',
        'account_id',
        'nominal',
        'tahun',
        'stage_id'
    ];
    //
    

    // Relasi ke Sub-Kegiatan
    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class);
    }

    // Relasi ke Akun
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Helper untuk mempermudah filter tahapan di Controller
    public function scopePerTahap($query, $tahapan)
    {
        return $query->where('tahapan', $tahapan)
                     ->where('tahun', session('tahun_anggaran', date('Y')));
    }

    // TAMBAHKAN RELASI INI: Budget terhubung ke banyak transaksi
    public function transactions()
    {
        // Hubungkan berdasarkan kesamaan account_id DAN sub_activity_id
        return $this->hasMany(Transaction::class, 'account_debit', 'account_id')
                    ->whereColumn('sub_activity_id', 'sub_activity_id');
    }
}
