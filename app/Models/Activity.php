<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    // app/Models/Activity.php

    protected $fillable = ['program_id','kode_kegiatan', 'nama_kegiatan', 'tahun'];

    public function up(){
        Schema::create('activities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_id')->constrained();
                $table->string('kode_kegiatan')->unique(); // Contoh: 5.1.02 (Kegiatan)
                $table->string('nama_kegiatan');           // Contoh: Pelayanan Perizinan Terpadu Satu Pintu
                $table->year('tahun');
                $table->timestamps();
        });
    }


    public function subActivities()
    {
        return $this->hasMany(SubActivity::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    
}
