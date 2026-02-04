<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NodeExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('node_exercises')->insert([
            [
                'exercise_id' => 1,
                'token' => Str::random(32),
                'vertex' => 'A',
                'type' => 'exercise',
                'edges' => json_encode(['B', 'C', 'D']),
                'x' => 400,
                'y' => 250,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 2,
                'token' => Str::random(32),
                'vertex' => 'B',
                'type' => 'exercise',
                'edges' => json_encode(['A']),
                'x' => 800,
                'y' => -150,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 3,
                'token' => Str::random(32),
                'vertex' => 'C',
                'type' => 'exercise',
                'edges' => json_encode(['A', 'E', 'F']),
                'x' => 800,
                'y' => 250,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 4,
                'token' => Str::random(32),
                'vertex' => 'D',
                'type' => 'exercise',
                'edges' => json_encode(['A']),
                'x' => 800,
                'y' => 650,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 5,
                'token' => Str::random(32),
                'vertex' => 'E',
                'type' => 'exercise',
                'edges' => json_encode(['C', 'H']),
                'x' => 1200,
                'y' => -150,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 6,
                'token' => Str::random(32),
                'vertex' => 'F',
                'type' => 'exercise',
                'edges' => json_encode(['C', 'G']),
                'x' => 1300,
                'y' => 250,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 7,
                'token' => Str::random(32),
                'vertex' => 'G',
                'type' => 'exercise',
                'edges' => json_encode(['F', 'H']),
                'x' => 1700,
                'y' => 250,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 8,
                'token' => Str::random(32),
                'vertex' => 'H',
                'type' => 'exercise',
                'edges' => json_encode(['E', 'G']),
                'x' => 2200,
                'y' => -150,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exercise_id' => 9,
                'token' => Str::random(32),
                'vertex' => 'I',
                'type' => 'exercise',
                'edges' => json_encode([null]),
                'x' => 1200,
                'y' => 650,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
