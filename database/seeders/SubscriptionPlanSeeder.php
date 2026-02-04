<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get User roles
        $roles = DB::table('user_roles')->pluck('role_name', 'role_id');

        // Insert default data
        DB::table('subscription_plans')->insert([
            [
                'plan_token' => 'P-F'.strtoupper(Str::random(23)),
                'name' => 'Plan Básico',
                'role_name' => $roles[1],
                'price' => 0.00,
                'currency' => 'USD',
                'frequency' => null,
                'description' => 'Acceso básico y con anuncios. Intentos y asistencia en los ejercicios limitada. Perfecto si quieres probar Hello World',
                'benefits' => '{"benefits": ["Acceso a todo el plan de estudio", "Acceso a toda la documentación", "Acceso limitado al asistente virtual", "Intentos limitados por día", "Anuncios"]}',
                'status' => 'active',
                'created_at' => '2024-07-11 15:00:25',
                'updated_at' => now()
            ],
            [
                'plan_token' => 'P-1FA15094XV4735329M3KUK7Y',
                'name' => 'VIP Mensual',
                'role_name' => $roles[2],
                'price' => 7.99,
                'currency' => 'USD',
                'frequency' => 'monthly',
                'description' => 'Acceso completo y sin anuncios. Ideal para quienes quieren probar las funcionalidades de Hello World.',
                'benefits' => '{"benefits": ["Acceso ilimitado al asistente virtual.", "Intentos ilimitados por día.", "Herramientas VIP.", "Sin anuncios."]}',
                'status' => 'active',
                'created_at' => '2024-07-11 15:00:26',
                'updated_at' => now()
            ],
            [
                'plan_token' => 'P-6RX959131C487880TM3KUPOI',
                'name' => 'VIP Anual',
                'role_name' => $roles[2],
                'price' => 69.99,
                'currency' => 'USD',
                'frequency' => 'yearly',
                'description' => 'Acceso completo y sin anuncios con descuento anual. Perfecto para un uso prolongado de Hello World.',
                'benefits' => '{"benefits": ["Acceso ilimitado al asistente virtual.", "Intentos ilimitados por día.", "Herramientas VIP.", "Un año de servicio", "Sin anuncios."]}',
                'status' => 'active',
                'created_at' => '2024-07-11 15:00:27',
                'updated_at' => now()
            ],
            [
                'plan_token' => 'P-69Y29266P84317231M3KUSBI',
                'name' => 'Organizacional Anual',
                'role_name' => $roles[3],
                'price' => 699.99,
                'currency' => 'USD',
                'frequency' => 'yearly',
                'description' => 'Acceso ilimitado para instituciones educativas con descuento anual. Apoya a usuarios sin anuncios.',
                'benefits' => '{"benefits": ["Minimo 100 licencias listas para compartir", "Soporte personalizado", "Etadisticas de los usuarios", "Todos los beneficios del plan VIP"]}',
                'status' => 'active',
                'created_at' => '2024-07-11 15:00:28',
                'updated_at' => now()
            ],   
        ]);
    }
}
