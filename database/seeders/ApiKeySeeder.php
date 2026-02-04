<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a default API key
        DB::table('api_keys')->insert([
            [
                'app_name' => 'Hello-World-Hub',
                'api_key' => 'HWH-a85b6b6f-9fbb-4fea-b462-c7d43e996b7b',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
