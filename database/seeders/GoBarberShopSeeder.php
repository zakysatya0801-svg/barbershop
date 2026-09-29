<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoBarberShopSeeder extends Seeder
{
    public function run(): void
    {
        $owner = DB::table('owners')->first();

        $location = DB::table('locations')
            ->where('city', 'Banyuwangi')
            ->first();

        if (!$owner) {
            throw new \Exception('Data owner belum tersedia.');
        }

        if (!$location) {
            throw new \Exception('Data location belum tersedia.');
        }

        DB::table('go_barbershops')->insert([
            'owner_id' => $owner->owner_id,
            'location_id' => $location->location_id,
            'barbershop_name' => 'GoBarber Banyuwangi',
            'description' => 'Barbershop modern dengan pelayanan profesional.',
            'photo' => 'gobarber-banyuwangi.jpg',
            'open_time' => '09:00:00',
            'close_time' => '21:00:00',
        ]);
    }
}
