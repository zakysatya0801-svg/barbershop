<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User, Admin, Owner
        $this->call(UserSeeder::class);

        // 2. Location
        $this->call(LocationSeeder::class);

        // 3. Barbershop
        $this->call(GoBarberShopSeeder::class);

        // 4. Barber dan Service
        $this->call([
            BarberSeeder::class,
            ServiceSeeder::class,
        ]);

        // 5. Customer
        $this->call(CustomerSeeder::class);

        // 6. Booking
        $this->call(BookingSeeder::class);

        // 7. Payment
        $this->call(PaymentSeeder::class);

        // 8. Favorite
        $this->call(FavoriteSeeder::class);

        // 9. Request
        $this->call(RequestSeeder::class);

        // 10. Produk
        $this->call(ProdukSeeder::class);

        // 11. Jadwal Barber
        $this->call(BarberScheduleSeeder::class);
    }
}
