<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentPonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointment_ponies')->insert([
            ['appointment_id' => 1, 'pony_id' => 1],
            ['appointment_id' => 1, 'pony_id' => 2],
            ['appointment_id' => 2, 'pony_id' => 1],
            ['appointment_id' => 2, 'pony_id' => 2],
        ]);
    }
}
