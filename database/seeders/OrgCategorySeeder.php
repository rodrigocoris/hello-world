<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('org_categories')->insert([
            [
                'org_category' => 'Educacional',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'org_category' => 'Empresarial',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
