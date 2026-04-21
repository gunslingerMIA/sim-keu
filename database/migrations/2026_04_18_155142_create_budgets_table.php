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
            
            // Nilai Anggaran
            $table->decimal('amount', 15, 2); 
            
            // Penanda Versi: murni, pergeseran_1, pergeseran_2, perubahan
            $table->string('version')->default('murni'); 
            
            $table->year('fiscal_year');
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
