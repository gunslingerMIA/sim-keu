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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_activity_id')->constrained();
            $table->foreignId('account_id')->constrained();
            $table->double('nominal', 15, 2);
            
            // Tahapan: murni, geser_awal, perubahan, geser_akhir
            $table->foreignId('stage_id')->constrained(); 
            
            // Untuk melacak ini pergeseran ke berapa (misal: Geser 1, Geser 2)
            $table->integer('versi')->default(1); 
            
            $table->string('dasar_hukum')->nullable(); // No. Perkada atau SK
            $table->year('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
