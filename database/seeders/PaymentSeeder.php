<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $booking = DB::table('bookings')->first();
        $service = DB::table('services')->first();

        if (!$booking || !$service) {
            throw new \Exception(
                'Data booking atau service belum tersedia.'
            );
        }

        DB::table('payments')->insert([
            'booking_id' => $booking->booking_id,
            'amount' => $service->price,
            'payment_method' => 'cash',
            'payment_status' => 'pending',
        ]);
    }
}
