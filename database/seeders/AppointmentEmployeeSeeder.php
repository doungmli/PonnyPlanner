<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointment_employee')->insert([
            ['appointment_id' => 1, 'employee_id' => 1],
            ['appointment_id' => 2, 'employee_id' => 2],

        ]);
    }
}
