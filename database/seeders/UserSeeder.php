<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'name' => 'Didik Yogo Suro Prasojo, S.Kom',
                'nip' => '199801092022031007',
                'jabatan' => 'Pranata Komputer Ahli Pertama',
                'password' => Hash::make('dpmptsp'),
                'role' => 'admin'
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
