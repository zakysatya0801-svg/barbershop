<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $shop = DB::table('go_barbershops')->first();

        if (!$shop) {
            throw new \Exception('Data go_barbershop belum tersedia.');
        }

        DB::table('services')->insert([
            [
                'shop_id' => $shop->go_barbershop_id,
                'service_name' => 'Classic Haircut',
                'photo' => 'classic-haircut.jpg',
                'price' => 25000,
                'duration' => 30,
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'service_name' => 'Fade Haircut',
                'photo' => 'fade-haircut.jpg',
                'price' => 35000,
                'duration' => 45,
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'service_name' => 'Hair Wash',
                'photo' => 'hair-wash.jpg',
                'price' => 15000,
                'duration' => 15,
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'service_name' => 'Haircut + Hair Wash',
                'photo' => 'haircut-wash.jpg',
                'price' => 45000,
                'duration' => 60,
            ],
        ]);
    }
}
