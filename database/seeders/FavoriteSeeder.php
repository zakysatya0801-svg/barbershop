<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $customer = DB::table('customers')->first();
        $shop = DB::table('go_barbershops')->first();

        if (!$customer || !$shop) {
            throw new \Exception(
                'Customer atau go_barbershop belum tersedia.'
            );
        }

        DB::table('favorites')->insert([
            'customer_id' => $customer->customer_id,
            'shop_id' => $shop->go_barbershop_id,
        ]);
    }
}
