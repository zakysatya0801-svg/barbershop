<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USER 1 - Admin
        |--------------------------------------------------------------------------
        */
        $adminUserId = DB::table('users')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@gobarber.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        $adminId = DB::table('admins')->insertGetId([
            'user_id' => $adminUserId,
            'role' => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | USER 2 - Owner
        |--------------------------------------------------------------------------
        */
        DB::table('users')->insert([
            'name' => 'Budi Santoso',
            'email' => 'owner@gobarber.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | USER 3 - Barber
        |--------------------------------------------------------------------------
        */
        DB::table('users')->insert([
            'name' => 'Andi Barber',
            'email' => 'barber@gobarber.com',
            'password' => Hash::make('password'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | OWNER
        |--------------------------------------------------------------------------
        */
        DB::table('owners')->insert([
            'nama_owners' => 'Budi Santoso',
            'email' => 'owner@gobarber.com',
            'phonr' => '081234567890',
            'admin_id' => $adminId,
        ]);
    }
}
