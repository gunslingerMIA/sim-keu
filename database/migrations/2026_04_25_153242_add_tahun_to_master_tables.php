<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    $tables = ['programs', 'activities', 'sub_activities', 'accounts'];

    foreach ($tables as $table) {
        Schema::table($table, function (Blueprint $table) {
            // Kita taruh setelah ID agar rapi
            $table->year('tahun')->after('id')->index();
        });
    }
}

public function down()
{
    $tables = ['programs', 'activities', 'sub_activities', 'accounts'];

    foreach ($tables as $table) {
        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
    }
}

};
