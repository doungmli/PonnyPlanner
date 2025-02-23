<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAppointmentEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        $group = $appointment->group;

        // Vérifiez que toutes les relations sont bien chargées
        if (!$group || !$group->client || !$appointment->ponies || $appointment->employees->isEmpty()) {
            // Si l'un des éléments est nul ou vide, journalisez une erreur ou traitez l'erreur de manière appropriée
            \Log::error('Le rendez-vous créé n\'a pas toutes les relations nécessaires.');
            return;
        }

        $details = [
            'client_name' => $group->client->first_name . ' ' . $group->client->last_name,
            'appointment_date' => $appointment->appointment_date,
            'start_time' => $appointment->start_time,
            'end_time' => $appointment->end_time,
            'number_of_people' => $group->number_of_people,
            'assigned_pony_count' => $appointment->assigned_ponies_count,
            'ponies' => $appointment->ponies->pluck('name')->toArray()
        ];

        foreach ($appointment->employees as $employee) {
            Mail::send('emails.appointment', $details, function ($message) use ($employee) {
                $message->to($employee->email)
                    ->subject('Nouveau Rendez-vous Assigné');
            });
        }
    }
}
