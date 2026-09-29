<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarberSeeder extends Seeder
{
    public function run(): void
    {
        $shop = DB::table('go_barbershops')->first();

        if (!$shop) {
            throw new \Exception('Data go_barbershop belum tersedia.');
        }

        DB::table('barbers')->insert([
            [
                'shop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Andi',
                'specialty' => 'Classic Haircut',
                'photo' => 'barber-andi.jpg',
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Budi',
                'specialty' => 'Modern Haircut',
                'photo' => 'barber-budi.jpg',
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Rizky',
                'specialty' => 'Fade Haircut',
                'photo' => 'barber-rizky.jpg',
            ],
        ]);
    }
}
