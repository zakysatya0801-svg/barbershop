<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {

            // 1. Data User & Owner
            $ownerId = DB::table('owners')->value('owner_id');

            if (! $ownerId) {
                $userId = DB::table('users')->insertGetId([
                    'name' => 'Owner GoBarber',
                    'email' => 'owner@gobarber.id',
                    'password' => Hash::make('password123'),
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

            // 2. Data Lokasi Jakarta Selatan
            $locJakarta = DB::table('locations')
                ->where('city', 'Jakarta Selatan')
                ->value('location_id');

            if (! $locJakarta) {
                $locJakarta = DB::table('locations')->insertGetId([
                    'city' => 'Jakarta Selatan',
                    'province' => 'DKI Jakarta',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 3. Data Lokasi Banyuwangi
            $locBanyuwangi = DB::table('locations')
                ->where('city', 'Banyuwangi')
                ->value('location_id');

            if (! $locBanyuwangi) {
                $locBanyuwangi = DB::table('locations')->insertGetId([
                    'city' => 'Banyuwangi',
                    'province' => 'Jawa Timur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 4. Data Barbershop
            $shops = [
                [
                    'barbershop_name' => 'Gamoen Barbershop Senopati',
                    'location_id' => $locJakarta,
                    'description' => 'Studio grooming pria kontemporer dengan sterilisasi UV-C dan hot towel aromaterapi.',
                    'photo' => null,
                    'open_time' => '09:00:00',
                    'close_time' => '22:00:00',
                ],
                [
                    'barbershop_name' => "King's Cut Barbershop Kemang",
                    'location_id' => $locJakarta,
                    'description' => 'Spesialis classic gentlemen cut, low-fade presisi, dan signature hot lather shave tradisional.',
                    'photo' => null,
                    'open_time' => '10:00:00',
                    'close_time' => '21:00:00',
                ],
                [
                    'barbershop_name' => 'Gentleman Studio Genteng',
                    'location_id' => $locBanyuwangi,
                    'description' => 'Grooming premium pria modern dengan kapster bersertifikat dan free premium coffee.',
                    'photo' => null,
                    'open_time' => '08:00:00',
                    'close_time' => '21:00:00',
                ],
            ];

            $shopIds = [];

            foreach ($shops as $shop) {
                $existingShop = DB::table('go_barbershops')
                    ->where('owner_id', $ownerId)
                    ->where('barbershop_name', $shop['barbershop_name'])
                    ->first();

                if ($existingShop) {
                    $shopId = $existingShop->go_barbershop_id;
                } else {
                    $shopId = DB::table('go_barbershops')->insertGetId([
                        'owner_id' => $ownerId,
                        'location_id' => $shop['location_id'],
                        'barbershop_name' => $shop['barbershop_name'],
                        'description' => $shop['description'],
                        'photo' => $shop['photo'],
                        'open_time' => $shop['open_time'],
                        'close_time' => $shop['close_time'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $shopIds[$shop['barbershop_name']] = $shopId;
            }

            // 5. Data Layanan
            $services = [
                [
                    'go_barbershop_id' => $shopIds['Gamoen Barbershop Senopati'],
                    'service_name' => 'Gentleman Executive Haircut',
                    'price' => 85000,
                    'duration' => 45,
                    'description' => 'Konsultasi model + Cuci Rambut Tonic + Hot Towel + Pomade Styling',
                ],
                [
                    'go_barbershop_id' => $shopIds["King's Cut Barbershop Kemang"],
                    'service_name' => 'Signature Cut & Beard Trim',
                    'price' => 75000,
                    'duration' => 40,
                    'description' => 'Potong rambut rapi + perapian janggut handuk hangat',
                ],
                [
                    'go_barbershop_id' => $shopIds['Gentleman Studio Genteng'],
                    'service_name' => 'Classic Cut & Head Massage',
                    'price' => 50000,
                    'duration' => 35,
                    'description' => 'Potong klasik + pijat kepala rileks',
                ],
            ];

            foreach ($services as $service) {
                $exists = DB::table('services')
                    ->where('go_barbershop_id', $service['go_barbershop_id'])
                    ->where('service_name', $service['service_name'])
                    ->exists();

                if (! $exists) {
                    DB::table('services')->insert([
                        ...$service,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
