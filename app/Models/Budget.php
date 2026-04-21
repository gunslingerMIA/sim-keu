<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    protected $fillable = ['sub_activity_id', 'account_id', 'amount', 'fiscal_year'];

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
}
