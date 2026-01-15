<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin inicial (solo para desarrollo). Cámbialo en producción.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        // Usuario Kevin para acceder al panel de administración
        User::updateOrCreate(
            ['email' => 'kevin@example.com'],
            [
                'name' => 'Kevin Perez',
                'password' => Hash::make('kevin123'),
            ]
        );
    }
}
