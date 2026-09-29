<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'city' => 'Banyuwangi',
                'province' => 'Jawa Timur',
            ],
            [
                'city' => 'Jember',
                'province' => 'Jawa Timur',
            ],
            [
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
        ]);
    }
}
