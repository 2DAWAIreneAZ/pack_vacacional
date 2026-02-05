<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador
        User::updateOrCreate(
					  ['email' => 'admin@example.com'],
            ['name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

				User::updateOrCreate(
					['email' => 'advanced@example.com'],
					['name' => 'Advanced',
					'password' => Hash::make('password'),
					'role' => 'advanced'
				]);

        // Usuario Normal
        User::updateOrCreate(
            ['email' => 'normal@example.com'],
            ['name' => 'Normal',
            'password' => Hash::make('password'),
            'role' => 'normal'
        ]);
    }
}
