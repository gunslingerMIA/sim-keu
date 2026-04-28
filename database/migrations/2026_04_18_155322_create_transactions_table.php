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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('pkjur'); // Menggunakan nama asli dari makro agar familiar
            $table->date('tanggal');
            $table->string('nobukti');
            $table->text('keterangan'); // Pakai text agar bisa uraian panjang
            
            // Relasi Sisi Debit (Rekening Belanja/Pajak/Panjar)
            $table->foreignId('account_debit')->constrained('accounts');
            
            // Relasi Sisi Kredit (Sumber Dana/Kas/Bank)
            $table->foreignId('account_kredit')->constrained('accounts');
            
            // Relasi ke Sub-Kegiatan (Nullable untuk Non-Kegiatan)
            $table->foreignId('sub_activity_id')->nullable()->constrained();
            
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
