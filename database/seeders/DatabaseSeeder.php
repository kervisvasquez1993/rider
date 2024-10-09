<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear vehículos de ejemplo
        $vehicles = [
            ['name' => 'Toyota Corolla', 'base_fare' => 10.00, 'rate_per_km' => 1.50, 'max_passengers' => 4],
            ['name' => 'Honda Civic', 'base_fare' => 12.00, 'rate_per_km' => 1.75, 'max_passengers' => 5],
            // Agrega más vehículos si es necesario
        ];
        DB::table('vehicles')->insert($vehicles);

        // Crear usuarios de ejemplo
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'username' => 'driver1',
                'email' => 'driver1@example.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
            ],
            [
                'username' => 'client1',
                'email' => 'client1@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
            ],
            // Agrega más usuarios si es necesario
        ];

        // Insertar usuarios y crear perfiles, wallets, etc.
        foreach ($users as $user) {
            // Insertar el usuario y obtener su ID
            $userId = DB::table('users')->insertGetId($user);

            // Crear perfil asociado
            $profileId = DB::table('profiles')->insertGetId([
                'name' => ucfirst($user['username']),
                'last_name' => 'Doe',
                'phone' => '1234567890',
                'img_url' => null,
                'user_id' => $userId, // Referencia al ID del usuario creado
                'date_of_birth' => '1990-01-01',
                'gender' => 'hombre', // o 'mujer'
            ]);

            // Crear wallet para el usuario
            DB::table('wallets')->insert([
                'user_id' => $userId, // Usar el ID del usuario insertado
                'balance' => 100.00, // Balance inicial
            ]);

            // Crear clients solo para usuarios de rol client
            if ($user['role'] === 'client') {
                DB::table('clients')->insert([
                    'profile_id' => $profileId,
                    'loyalty_points' => 10,
                    'preferences' => json_encode(['preferencia1', 'preferencia2']),
                ]);
            }

            // Crear drivers solo para usuarios de rol driver
            if ($user['role'] === 'driver') {
                DB::table('drivers')->insert([
                    'profile_id' => $profileId,
                    'vehicle_id' => 1, // ID del vehículo, ajusta según tu necesidad
                    'license_plate' => 'ABC123',
                    'rating' => 5.00,
                    'status' => 'available',
                ]);
            }
        }
    }
}
