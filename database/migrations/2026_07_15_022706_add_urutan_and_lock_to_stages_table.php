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
        Schema::table('stages', function (Blueprint $table) {
            // Urutan tahapan dalam satu tahun anggaran (1 = Penetapan, 2 = tahapan berikutnya, dst)
            $table->unsignedInteger('urutan')->default(1)->after('nama_tahapan');
 
            // Tahapan yang sudah "dilewati" (ada tahapan baru sesudahnya) otomatis terkunci,
            // sehingga pagu di tahapan ini tidak bisa diubah/dihapus lagi.
            $table->boolean('is_locked')->default(false)->after('is_active');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropColumn(['urutan', 'is_locked']);
        });
    }
};