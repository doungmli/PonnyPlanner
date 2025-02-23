<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Group;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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
        $faker = Faker::create();
        $groups = Group::with('appointments')->get();

        foreach ($groups as $group) {
            foreach ( $group->appointments as $appointment){
                $month = Carbon::parse($appointment->appointment_date)->month;
                $year = Carbon::parse($appointment->appointment_date)->year;
                $total_amount = $group->calculateTotalAmount($month,$year);

                Invoice::create([
                    'month' => $month,
                    'year' => $year,
                    'total_amount' => $total_amount,
                    'group_id' => $group->id,
                    'reference' => $faker->uuid,
                    'status' => $faker->randomElement(['à payer', 'payé']),
                    'prix_unitaire_tvac' => 30.00
                ]);
            }
        }
    }
}

