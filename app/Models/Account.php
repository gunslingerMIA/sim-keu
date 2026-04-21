<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = ['kode_rekening', 'nama_rekening', 'kelompok'];

    public function up(){
        Schema::create('accounts', function (Blueprint $table) {
                $table->id();
                $table->string('kode_rekening')->unique(); // Contoh: 5.1.02.01.0026
                $table->string('nama_rekening');           // Contoh: Belanja Bahan Cetak
                $table->enum('kelompok', ['belanja', 'kas', 'panjar', 'pajak']); 
                $table->timestamps();
        });
    }
   
}
