<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = DB::table('languages')->pluck('language', 'language');

        DB::table('modules')->insert([
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Introducción',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Fundamentos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Variables y tipos de datos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Operadores',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Estructuras de control',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'language' => $languages['C++'],
                'token' => Str::uuid(),
                'module' => 'Funciones',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
