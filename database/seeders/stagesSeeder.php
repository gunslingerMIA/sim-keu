<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stage;

class stagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Stage::updateOrCreate([
            'tahun' => 2026,
            'nama_tahapan' => 'APBD Murni',
            'is_active' => true
        ]);
    }
}
