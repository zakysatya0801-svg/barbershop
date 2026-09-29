<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'name' => 'Zaky',
                'phone' => '0895330364298',
            ],
            [
                'name' => 'Dewi',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Rizal',
                'phone' => '081234567892',
            ],
        ]);
    }
}
