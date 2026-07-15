<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ubah constraint UNIQUE global pada kolom kode menjadi
     * UNIQUE kombinasi (kode + tahun) agar kode yang sama boleh
     * dipakai di tahun anggaran yang berbeda.
     *
     * Tabel yang diubah:
     *   - programs        : kode_program
     *   - activities      : kode_kegiatan
     *   - sub_activities  : kode_sub_kegiatan
     *   - accounts        : kode_rekening
     */
    public function up(): void
    {
        // ── programs ─────────────────────────────────────────────────
        Schema::table('programs', function (Blueprint $table) {
            $table->dropUnique(['kode_program']);                        // hapus unique global
            $table->unique(['kode_program', 'tahun'], 'programs_kode_tahun_unique'); // unique per tahun
        });

        // ── activities ───────────────────────────────────────────────
        Schema::table('activities', function (Blueprint $table) {
            $table->dropUnique(['kode_kegiatan']);
            $table->unique(['kode_kegiatan', 'tahun'], 'activities_kode_tahun_unique');
        });

        // ── sub_activities ───────────────────────────────────────────
        Schema::table('sub_activities', function (Blueprint $table) {
            $table->dropUnique(['kode_sub_kegiatan']);
            $table->unique(['kode_sub_kegiatan', 'tahun'], 'sub_activities_kode_tahun_unique');
        });

        // ── accounts ─────────────────────────────────────────────────
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropUnique(['kode_rekening']);
            $table->unique(['kode_rekening', 'tahun'], 'accounts_kode_tahun_unique');
        });
    }

    /**
     * Kembalikan ke constraint unique global (rollback).
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropUnique('programs_kode_tahun_unique');
            $table->unique('kode_program');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropUnique('activities_kode_tahun_unique');
            $table->unique('kode_kegiatan');
        });

        Schema::table('sub_activities', function (Blueprint $table) {
            $table->dropUnique('sub_activities_kode_tahun_unique');
            $table->unique('kode_sub_kegiatan');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropUnique('accounts_kode_tahun_unique');
            $table->unique('kode_rekening');
        });
    }
};

