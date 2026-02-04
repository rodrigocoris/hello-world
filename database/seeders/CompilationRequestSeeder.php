<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CompilationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('compilation_requests')->insert([
            [
                'user_id' => 1,
                'language' => 'C++',
                'source_code' => '#include <iostream>\n\nint fibonacci(int n) {\n    if (n <= 1)\n        return n;\n    return fibonacci(n - 1) + fibonacci(n - 2);\n}\n\nint main() {\n    int terms = 10;\n    std::cout << \"Fibonacci series:\" << std::endl;\n    for (int i = 0; i < terms; ++i) {\n        std::cout << fibonacci(i) << \" \";\n    }\n    std::cout << std::endl;\n    return 0;\n}',
                'status' => 'queued',
                'compilation_token' => Str::uuid(),
                'output' => null,
                'execution_time_ms' => null,
                'error_message' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
