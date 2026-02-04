<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('difficulties')->insert([
            [
                'level' => 'Fácil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'level' => 'Medio',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'level' => 'Dificil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'level' => 'Experto',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'level' => 'Hacker',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
