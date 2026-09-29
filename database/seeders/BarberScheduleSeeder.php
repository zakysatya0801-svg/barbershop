<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarberScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $barbers = DB::table('barbers')->get();

        foreach ($barbers as $barber) {
            DB::table('barber_schedules')->insert([
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Senin',
                    'start_time' => '09:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Selasa',
                    'start_time' => '09:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Rabu',
                    'start_time' => '09:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Kamis',
                    'start_time' => '09:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Jumat',
                    'start_time' => '13:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
                [
                    'barber_id' => $barber->barber_id,
                    'day' => 'Sabtu',
                    'start_time' => '09:00:00',
                    'end_time' => '21:00:00',
                    'status' => true,
                ],
            ]);
        }
    }
}
