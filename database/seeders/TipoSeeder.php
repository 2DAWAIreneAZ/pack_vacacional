<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Playa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Montaña', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Crucero', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ciudad', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Safari', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Aventura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cultural', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Relax', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tipo')->insert($tipos);
    }
}