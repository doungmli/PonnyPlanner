<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Group;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
//    public function run(): void
//    {
       /* $groups = DB::table('groups')->get();
        foreach ($groups as $group) {
            $appointments = Appointment::where('group_id', $group->id)
                ->whereYear('appointment_date', 2025)
                ->whereMonth('appointment_date', 4)
                ->get();

            $totalAmount = $appointments->count() * 30; // Supposons que chaque rendez-vous coûte 100

            Invoice::create([
                'month' => 'April',
                'year' => 2025,
                'total_amount' => $totalAmount,
                'group_id' => $group->id
            ]);
        }*/

        public function run()
    {
        $groups = Group::all();

        foreach ($groups as $group) {
            $appointments = $group->appointments()->whereMonth('appointment_date', '04')->whereYear('appointment_date', '2025')->get();
            $totalAmount = $appointments->count() * 100; // Supposons que chaque rendez-vous coûte 100

            Invoice::create([
                'month' => 'April',
                'year' => 2025,
                'total_amount' => $totalAmount,
                'group_id' => $group->id
            ]);
        }
    }
}

