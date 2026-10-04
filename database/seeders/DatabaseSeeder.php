<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demoUsers = [
            [
                'name' => 'Admin GoBarber',
                'email' => 'admin@gobarber.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Mitra Barbershop',
                'email' => 'client@gobarber.test',
                'role' => 'client',
            ],
        ];

        foreach ($demoUsers as $data) {
            User::firstOrNew([
                'email' => $data['email'],
            ])->forceFill([
                'name' => $data['name'],
                'role' => $data['role'],
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->save();
        }
    }
}