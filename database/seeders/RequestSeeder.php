<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $booking = DB::table('bookings')->first();
        $customer = DB::table('customers')->first();

        if (!$booking || !$customer) {
            throw new \Exception(
                'Data booking atau customer belum tersedia.'
            );
        }

        DB::table('requests')->insert([
            'booking_id' => $booking->booking_id,
            'customer_id' => $customer->customer_id,
            'massage' => 'Mohon menggunakan hair tonic setelah potong rambut.',
            'status' => 'pending',
        ]);
    }
}
