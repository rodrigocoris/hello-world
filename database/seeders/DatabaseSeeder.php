<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ApiKeySeeder::class,
            OrgCategorySeeder::class,
            OrganizationSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            SubscriptionPlanSeeder::class,
            LanguageSeeder::class,
            CompilationRequestSeeder::class,
          # ModuleSeeder::class,
          # LessonSeeder::class,
            DifficultySeeder::class,
          # ExerciseSeeder::class,
          # NodeExerciseSeeder::class,
        ]);
    }
}