<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    //
    // app/Models/SubActivity.php

    protected $fillable = ['activity_id','kode_sub_kegiatan', 'nama_sub_kegiatan', 'tahun'];

    public function up(){
        Schema::create('sub_activities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('activity_id')->constrained();
                $table->string('kode_sub_kegiatan')->unique(); // Contoh:           
                $table->string('nama_sub_kegiatan');           // Contoh: Pelayanan Perizinan Terpadu Satu Pintu di Kecamatan
                $table->year('tahun');
                $table->timestamps();   
        });
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Relasi ke Anggaran (Pagu)
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    // Realasi ke Transaksi (Realisasi)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
