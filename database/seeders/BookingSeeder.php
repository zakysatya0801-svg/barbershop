<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customer = DB::table('customers')->first();
        $shop = DB::table('go_barbershops')->first();
        $service = DB::table('services')->first();
        $barber = DB::table('barbers')->first();

        if (!$customer || !$shop || !$service || !$barber) {
            throw new \Exception(
                'Customer, shop, service, atau barber belum tersedia.'
            );
        }

        DB::table('bookings')->insert([
            'customer_id' => $customer->customer_id,
            'shop_id' => $shop->go_barbershop_id,
            'service_id' => $service->service_id,
            'barber_id' => $barber->barber_id,
            'booking_date' => now()->addDay()->toDateString(),
            'time_slot' => '10:00:00',
            'status' => 'pending',
        ]);
    }
}
