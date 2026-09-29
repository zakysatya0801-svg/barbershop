<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $shop = DB::table('go_barbershops')->first();

        if (!$shop) {
            throw new \Exception(
                'Data go_barbershop belum tersedia.'
            );
        }

        DB::table('produks')->insert([
            [
                'shop_id' => $shop->go_barbershop_id,
                'name_product' => 'Pomade Premium',
                'price' => 75000,
                'description' => 'Pomade dengan daya tahan kuat untuk styling rambut.',
                'photo' => 'pomade.jpg',
            ],
            [
                'shop_id' => $shop->go_barbershop_id,
                'name_product' => 'Hair Tonic',
                'price' => 50000,
                'description' => 'Hair tonic untuk membantu merawat rambut.',
                'photo' => 'hair-tonic.jpg',
            ],
        ]);
    }
}
