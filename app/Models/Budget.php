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
        'tahun'
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
}
