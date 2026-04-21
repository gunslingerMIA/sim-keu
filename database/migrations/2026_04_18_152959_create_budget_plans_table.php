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
        
        //Tabel Program

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_program')->unique();
            $table->string('nama_program');
            $table->timestamps();
        });

        //Tabel Kegiatan

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('kode_kegiatan')->unique();
            $table->string('nama_kegiatan');
            $table->timestamps();
        });

        //Tabel Sub Kegiatan

        Schema::create('sub_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->string('kode_sub_kegiatan')->unique();
            $table->string('nama_sub_kegiatan');
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_plans');
    }
};
