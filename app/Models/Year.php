<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['tahun', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Semua tahapan (Stage) yang dimiliki tahun anggaran ini.
     * Relasi via kolom 'tahun' bukan foreign key integer biasa.
     */
    public function stages()
    {
        return $this->hasMany(Stage::class, 'tahun', 'tahun');
    }

    /**
     * Semua program yang dimiliki tahun anggaran ini.
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'tahun', 'tahun');
    }
}
