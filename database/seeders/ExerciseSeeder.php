<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('exercises')->insert([
            [
                'lesson_id' => 1,
                'title' => 'Hello World 1',
                'description' => 'Este es un ejercicio de Hello World',
                'difficulty_level_id' => 1,
                'body_code' => 'print("Hello World")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 1,
                'title' => 'Hello World 2',
                'description' => 'Este es un ejercicio de Hello World 2',
                'difficulty_level_id' => 2,
                'body_code' => 'print("Hello World 2")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 1,
                'title' => 'Hello World 3',
                'description' => 'Este es un ejercicio de Hello World 3',
                'difficulty_level_id' => 1,
                'body_code' => 'print("Hello World 3")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 1,
                'title' => 'Hello World 4',
                'description' => 'Este es un ejercicio de Hello World 4',
                'difficulty_level_id' => 2,
                'body_code' => 'print("Hello World 4")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 2,
                'title' => 'Hello World 5',
                'description' => 'Este es un ejercicio de Hello World 5',
                'difficulty_level_id' => 1,
                'body_code' => 'print("Hello World 5")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 2,
                'title' => 'Hello World 6',
                'description' => 'Este es un ejercicio de Hello World 6',
                'difficulty_level_id' => 3,
                'body_code' => 'print("Hello World 6")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 2,
                'title' => 'Hello World 7',
                'description' => 'Este es un ejercicio de Hello World 7',
                'difficulty_level_id' => 1,
                'body_code' => 'print("Hello World 7")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 2,
                'title' => 'Hello World 8',
                'description' => 'Este es un ejercicio de Hello World 8',
                'difficulty_level_id' => 2,
                'body_code' => 'print("Hello World 8")',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'lesson_id' => 3,
                'title' => 'Hello World 9',
                'description' => 'Este es un ejercicio de Hello World 9',
                'difficulty_level_id' => 1,
                'body_code' => 'print("Hello World 9")',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
