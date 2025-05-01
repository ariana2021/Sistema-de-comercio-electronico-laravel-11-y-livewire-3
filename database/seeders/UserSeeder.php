<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear dos usuarios con rol admin
        User::create([
            'name' => 'Admin User 1',
            'email' => 'admin@gmail.com',
            'phone' => '123456789',
            'address' => 'Direccion Admin 1',
            'website' => 'https://admin1.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('admin');

        User::create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'phone' => '987654321',
            'address' => 'Direccion Admin 2',
            'website' => 'https://admin2.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('admin');

        // Crear dos usuarios con rol soporte
        User::create([
            'name' => 'Soporte User 1',
            'email' => 'soporte1@example.com',
            'phone' => '1122334455',
            'address' => 'Direccion Soporte 1',
            'website' => 'https://soporte1.com',
            'password' => Hash::make('soporte123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('soporte');

        User::create([
            'name' => 'Soporte User 2',
            'email' => 'soporte2@example.com',
            'phone' => '2233445566',
            'address' => 'Direccion Soporte 2',
            'website' => 'https://soporte2.com',
            'password' => Hash::make('soporte123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('soporte');

        // Crear dos usuarios con rol asistente
        User::create([
            'name' => 'Asistente User 1',
            'email' => 'asistente1@example.com',
            'phone' => '3344556677',
            'address' => 'Direccion Asistente 1',
            'website' => 'https://asistente1.com',
            'password' => Hash::make('asistente123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('asistente');

        User::create([
            'name' => 'Asistente User 2',
            'email' => 'asistente2@example.com',
            'phone' => '4455667788',
            'address' => 'Direccion Asistente 2',
            'website' => 'https://asistente2.com',
            'password' => Hash::make('asistente123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('asistente');

        // Crear dos usuarios con rol trabajador
        User::create([
            'name' => 'Trabajador User 1',
            'email' => 'trabajador1@example.com',
            'phone' => '5566778899',
            'address' => 'Direccion Trabajador 1',
            'website' => 'https://trabajador1.com',
            'password' => Hash::make('trabajador123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('trabajador');

        User::create([
            'name' => 'Trabajador User 2',
            'email' => 'trabajador2@example.com',
            'phone' => '6677889900',
            'address' => 'Direccion Trabajador 2',
            'website' => 'https://trabajador2.com',
            'password' => Hash::make('trabajador123'),
            'email_verified_at' => date('Y-m-d H:i')
        ])->assignRole('trabajador');
    }
}
