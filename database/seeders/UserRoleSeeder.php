<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert default roles
        DB::table('user_roles')->insert([
            [
                'role_name' => 'Básico',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'VIP',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'Organizacional',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'Asociado',  // Refers to the organization with which the user is associated.
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'Administrador',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
