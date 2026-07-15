<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Stage extends Model
{
    protected $fillable = [
        'tahun',
        'nama_tahapan',
        'urutan',
        'is_active',
        'is_locked',
    ];
 
    protected $casts = [
        'is_active' => 'boolean',
        'is_locked' => 'boolean',
    ];
 
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
 
    // Tahapan sebelumnya (urutan - 1) di tahun yang sama, kalau ada
    public function tahapanSebelumnya()
    {
        return Stage::where('tahun', $this->tahun)
            ->where('urutan', $this->urutan - 1)
            ->first();
    }
}