<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            [
                'language' => 'C++',
                'file_extension' => 'cpp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => 'Python',
                'file_extension' => 'py',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
