<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create([
            'appointment_date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'group_id' => 1,
            'assigned_ponies_count' => 1
        ]);

        Appointment::create([
            'appointment_date' => now()->toDateString(),
            'start_time' => '14:00:00',
            'end_time' => '15:00:00',
            'group_id' => 2,
            'assigned_ponies_count' => 1
        ]);
    }
}
