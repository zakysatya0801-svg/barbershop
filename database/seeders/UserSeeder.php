<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat atau memperbarui akun Admin.
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gobarber.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Mengambil ID akun Admin berdasarkan email.
        $adminUserId = DB::table('users')
            ->where('email', 'admin@gobarber.com')
            ->value('user_id');

        // Membuat atau memperbarui data Admin.
        DB::table('admins')->updateOrInsert(
            ['user_id' => $adminUserId],
            [
                'role' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Membuat atau memperbarui akun Owner.
        DB::table('users')->updateOrInsert(
            ['email' => 'owner@gobarber.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Mengambil ID akun Owner.
        $ownerUserId = DB::table('users')
            ->where('email', 'owner@gobarber.com')
            ->value('user_id');

        // Membuat atau memperbarui data akun Owner pada tabel admins.
        DB::table('admins')->updateOrInsert(
            ['user_id' => $ownerUserId],
            [
                'role' => 'owner',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Mengambil ID admin yang terkait dengan akun Owner.
        $ownerAdminId = DB::table('admins')
            ->where('user_id', $ownerUserId)
            ->value('admin_id');

        // Membuat atau memperbarui data Owner.
        DB::table('owners')->updateOrInsert(
            ['email' => 'owner@gobarber.com'],
            [
                'nama_owners' => 'Budi Santoso',
                'phone' => '081234567890',
                'admin_id' => $ownerAdminId,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
