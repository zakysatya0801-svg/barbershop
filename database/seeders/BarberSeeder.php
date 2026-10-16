<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarberSeeder extends Seeder
{
    /**
     * Menambahkan data awal barber ke database.
     */
    public function run(): void
    {
        // Mengambil satu data barbershop yang sudah tersedia.
        $shop = DB::table('go_barbershops')->first();

        // Menghentikan proses jika belum ada data barbershop.
        if (!$shop) {
            throw new \Exception(
                'Data go_barbershop belum tersedia.'
            );
        }

        // Menambahkan tiga data barber yang terhubung
        // dengan barbershop yang ditemukan sebelumnya.
        DB::table('barbers')->insert([
            [
                'go_barbershop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Andi',
                'specialty' => 'Classic Haircut',
                'photo' => 'barber-andi.jpg',
            ],
            [
                'go_barbershop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Budi',
                'specialty' => 'Modern Haircut',
                'photo' => 'barber-budi.jpg',
            ],
            [
                'go_barbershop_id' => $shop->go_barbershop_id,
                'barber_name' => 'Rizky',
                'specialty' => 'Fade Haircut',
                'photo' => 'barber-rizky.jpg',
            ],
        ]);
    }
}