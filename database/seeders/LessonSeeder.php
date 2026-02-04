<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $modules = DB::table('modules')->pluck('module', 'module');

        // Insert default data
        DB::table('lessons')->insert([
            [
                'module' => $modules['Introducción'],
                'hierarchy' => 1,
                'title' => 'Leccion introductoria a C++',
                'description' => 'C++ es un lenguaje de programación orientado a objetos que se utiliza para desarrollar aplicaciones de todo tipo, desde juegos hasta sistemas operativos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => $modules['Introducción'],
                'hierarchy' => 2,
                'title' => 'Leccion introductoria a C++ 2',
                'description' => 'C++ 2 es un lenguaje de programación orientado a objetos que se utiliza para desarrollar aplicaciones de todo tipo, desde juegos hasta sistemas operativos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => $modules['Introducción'],
                'hierarchy' => 3,
                'title' => 'Leccion introductoria a C++ 3',
                'description' => 'C++ 3 es un lenguaje de programación orientado a objetos que se utiliza para desarrollar aplicaciones de todo tipo, desde juegos hasta sistemas operativos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => $modules['Fundamentos'],
                'hierarchy' => 1,
                'title' => 'Leccion introductoria a Python',
                'description' => 'Python se utiliza para desarrollar aplicaciones de todo tipo, desde aplicaciones web hasta aplicaciones de escritorio y científicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => $modules['Fundamentos'],
                'hierarchy' => 2,
                'title' => 'Leccion introductoria a Python 2',
                'description' => 'Python se utiliza para desarrollar aplicaciones de todo tipo, desde aplicaciones web hasta aplicaciones de escritorio y científicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => $modules['Fundamentos'],
                'hierarchy' => 3,
                'title' => 'Leccion introductoria a Python 3',
                'description' => 'Python se utiliza para desarrollar aplicaciones de todo tipo, desde aplicaciones web hasta aplicaciones de escritorio y científicas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
