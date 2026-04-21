<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $fillable = ['kode_program', 'nama_program'];

    public function up(){
        Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('kode_program')->unique(); // Contoh: 5.1 (Program)
                $table->string('nama_program');           // Contoh: Pelayanan Perizinan
                $table->timestamps();
        });
    }

    
    
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
