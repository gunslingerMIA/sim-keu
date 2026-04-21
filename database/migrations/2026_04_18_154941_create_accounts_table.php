<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rekening')->unique(); // Contoh: 5.1.02... (Belanja) atau PJR-01 (Panjar)
            $table->string('nama_rekening');           // Nama Rekening / Nama Pegawai
            
            // Kita kasih kategori supaya sistem nggak bingung
            // belanja = DPA, kas = Duit di brankas/bank, panjar = Uang muka kerja
            $table->enum('kelompok', ['belanja', 'kas', 'panjar', 'pajak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
