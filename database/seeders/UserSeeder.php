<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener los roles y organizaciones
        $roles = DB::table('user_roles')->pluck('role_id', 'role_name');
        $organizations = DB::table('organizations')->pluck('organization_id', 'organization_name');

        // Crear los usuarios
        DB::table('users')->insert([
            [
                'user_token' => Str::uuid(),
                'username' => 'user_basico',
                'email' => 'basico@hello-world.space',
                'verified_at' => now(),
                'password' => Hash::make('HelloW0r!d'),
                'role_id' => $roles['Básico'],
                'organization_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_token' => Str::uuid(),
                'username' => 'user_vip',
                'email' => 'vip@hello-world.space',
                'verified_at' => now(),
                'password' => Hash::make('HelloW0r!d'),
                'role_id' => $roles['VIP'],
                'organization_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_token' => Str::uuid(),
                'username' => 'user_organizacional',
                'email' => 'organizacional@hello-world.space',
                'verified_at' => now(),
                'password' => Hash::make('HelloW0r!d'),
                'role_id' => $roles['Organizacional'],
                'organization_id' => $organizations['Hello-World'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_token' => Str::uuid(),
                'username' => 'user_asociado',
                'email' => 'asociado@hello-world.space',
                'verified_at' => now(),
                'password' => Hash::make('HelloW0r!d'),
                'role_id' => $roles['Asociado'],
                'organization_id' => $organizations['Hello-World'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_token' => Str::uuid(),
                'username' => 'user_administrador',
                'email' => 'administrador@hello-world.space',
                'verified_at' => now(),
                'password' => Hash::make('HelloW0r!d'),
                'role_id' => $roles['Administrador'],
                'organization_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
