<?php

namespace Database\Seeders;

use App\Models\Pony;
use App\Models\PonyBreak;
use Illuminate\Database\Seeder;

class PonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pony::create(['name' => 'Bébert', 'max_working_hours' => 6]);
        Pony::create(['name' => 'Anastallion', 'max_working_hours' => 6]);
    }

/*    public function run()
    {
        $ponies = [
            ['name' => 'Bébert', 'max_working_hours' => 6],
            ['name' => 'Anastallion', 'max_working_hours' => 6],
        ];*/

/*        foreach ($ponies as $ponyData) {
            $pony = Pony::create($ponyData);
            $this->scheduleBreaks($pony);
        }
    }

    private function scheduleBreaks(Pony $pony)
    {
        PonyBreak::where('pony_id', $pony->id)->delete();
        $workingHours = $pony->max_working_hours;
        $currentTime = now();

        while ($workingHours > 0) {
            // Planification des heures de travail
            if ($workingHours >= 2) {
                $startTime = $currentTime;
                $endTime = $currentTime->copy()->addHours(2);
                $currentTime = $endTime->copy()->addMinutes(15); // Ajouter 15 minutes de pause
                $workingHours -= 2;
            } else {
                $startTime = $currentTime;
                $endTime = $currentTime->copy()->addHours($workingHours);
                $currentTime = $endTime;
                $workingHours = 0;
            }

            // Enregistrement de la pause
            PonyBreak::create([
                'pony_id' => $pony->id,
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
        }
    }*/
}
