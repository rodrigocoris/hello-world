<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert default organizations
        DB::table('organizations')->insert([
            [
                'organization_name' => 'Ceti Plantel Colomos',
                'org_category' => 1,
                'location' => 'C. Nueva Escocia 1885, Providencia 5a Secc., 44638 Guadalajara, Jal.',
                'description' => 'El Centro de Enseñanza Técnica Industrial, o CETI, es una institución educativa pública, descentralizada y federal en Guadalajara, en el estado de Jalisco, México.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'organization_name' => 'Hello-World',
                'org_category' => 1,
                'location' => null,
                'description' => 'Hello-World es una plataforma educativa interactiva que ofrece ejercicios de programación y lecciones para aprender a codificar. Diseñada para desarrolladores de todos los niveles, facilita la práctica y mejora de habilidades en diversos lenguajes de programación.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
