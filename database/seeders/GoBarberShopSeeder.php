<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoBarberSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Owner / User dummy jika belum ada
        $ownerId = DB::table('owners')->value('owner_id');
        if (!$ownerId) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Owner GoBarber',
                'email' => 'owner@gobarber.id',
                'password' => bcrypt('password123'),
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $ownerId = DB::table('owners')->insertGetId([
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Buat Lokasi Kota
        $locJakarta = DB::table('locations')->where('city', 'Jakarta Selatan')->value('location_id')
            ?? DB::table('locations')->insertGetId([
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $locBanyuwangi = DB::table('locations')->where('city', 'Banyuwangi')->value('location_id')
            ?? DB::table('locations')->insertGetId([
                'city' => 'Banyuwangi',
                'province' => 'Jawa Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // 3. Masukkan Data Barbershop sesuai Mockup
        $shop1 = DB::table('go_barbershops')->insertGetId([
            'owner_id' => $ownerId,
            'location_id' => $locJakarta,
            'barbershop_name' => 'Gamoen Barbershop Senopati',
            'description' => 'Studio grooming pria kontemporer dengan sterilisasi UV-C dan hot towel aromaterapi.',
            'photo' => '[suspicious link removed]',
            'open_time' => '09:00:00',
            'close_time' => '22:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shop2 = DB::table('go_barbershops')->insertGetId([
            'owner_id' => $ownerId,
            'location_id' => $locJakarta,
            'barbershop_name' => "King's Cut Barbershop Kemang",
            'description' => 'Spesialis classic gentlemen cut, low-fade presisi, dan signature hot lather shave tradisional.',
            'photo' => '[suspicious link removed]',
            'open_time' => '10:00:00',
            'close_time' => '21:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shop3 = DB::table('go_barbershops')->insertGetId([
            'owner_id' => $ownerId,
            'location_id' => $locBanyuwangi,
            'barbershop_name' => 'Gentleman Studio Genteng',
            'description' => 'Grooming premium pria modern dengan kapster bersertifikat dan free premium coffee.',
            'photo' => '[suspicious link removed]',
            'open_time' => '08:00:00',
            'close_time' => '21:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Masukkan Layanan (Services)
        DB::table('services')->insert([
            [
                'shop_id' => $shop1,
                'service_name' => 'Gentleman Executive Haircut',
                'price' => 85000,
                'duration' => 45,
                'description' => 'Konsultasi model + Cuci Rambut Tonic + Hot Towel + Pomade Styling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_id' => $shop2,
                'service_name' => 'Signature Cut & Beard Trim',
                'price' => 75000,
                'duration' => 40,
                'description' => 'Potong rambut rapi + perapian janggut handuk hangat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_id' => $shop3,
                'service_name' => 'Classic Cut & Head Massage',
                'price' => 50000,
                'duration' => 35,
                'description' => 'Potong klasik + pijat kepala rileks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}