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
            $table->string('batch_id');          // ID kelompok (pengganti pkjur)
            $table->date('date');
            $table->string('evidence_number');   // Nomor kuitansi (A-03-001)
            $table->string('description');
            
            // Relasi ke Akun (A45308...)
            $table->foreignId('account_id')->constrained();
            
            // Relasi ke Sub-Kegiatan (Kosong jika transaksi non-belanja)
            $table->foreignId('sub_activity_id')->nullable()->constrained();
            
            
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
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
