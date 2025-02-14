<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pony extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_working_hours'];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_pony');
    }

    /*    public function getWorkingHoursAttribute()
        {
            $totalMinutes = $this->appointments->reduce(function ($carry, $appointment) {
                $start = Carbon::createFromFormat('H:i', $appointment->start_time);
                $end = Carbon::createFromFormat('H:i', $appointment->end_time);
                return $carry + $start->diffInMinutes($end);
            }, 0);

            return round($totalMinutes / 60, 2); // Convertir les minutes en heures et arrondir à deux décimales
        }*/


    public function getWorkingHoursAttribute()
    {
        $totalMinutes = $this->appointments->reduce(function ($carry, $appointment) {
            try {
                $start = Carbon::createFromFormat('H:i:s', $appointment->start_time);
                $end = Carbon::createFromFormat('H:i:s', $appointment->end_time);

                // Si l'heure de fin est plus petite que l'heure de début, cela traverse minuit
                if ($end < $start) {
                    $end->addDay();
                }

                return $carry + $start->diffInMinutes($end);
            } catch (\Exception $e) {
                \Log::error('Erreur de format d\'heure: ' . $e->getMessage());
                return $carry;
            }
        }, 0);

        return round($totalMinutes / 60, 2); // Convertir en heures
    }

}
