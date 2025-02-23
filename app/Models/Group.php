<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['number_of_people', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function calculateTotalAmount($month, $year, $prixParHeure = 30.00)
    {
        $appointments = $this->appointments()
            ->whereMonth('appointment_date', $month)
            ->whereYear('appointment_date', $year)
            ->get();

        $totalAmount = $appointments->reduce(function ($carry, $appointment) use ($prixParHeure) {
            $nombreDePersonnes = $appointment->group->number_of_people;

            // Calcul de la durée en heures
            $start = Carbon::createFromFormat('H:i:s', $appointment->start_time);
            $end = Carbon::createFromFormat('H:i:s', $appointment->end_time);

            $duree = $start->diffInHours($end);
            //dd($duree, $nombreDePersonnes,$prixParHeure);

            return $carry + ($nombreDePersonnes * $duree * $prixParHeure);
        }, 0.00);

        return round($totalAmount, 2);
    }
}
