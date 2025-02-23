<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Pony;
use App\Models\Employee;
use Illuminate\Validation\Validator;

class AppointmentValidationService
{

    public function validatePoniesAvailability(Validator $validator, $appointmentId, $date, $startTime, $endTime, $ponies)
    {
        foreach ($ponies as $ponyId) {
            $conflicts = Appointment::where('id', '!=', $appointmentId)
                ->where('appointment_date', $date)
                ->whereHas('ponies', function($query) use ($ponyId) {
                    $query->where('pony_id', $ponyId);
                })
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime]);
                })
                ->exists();

            if ($conflicts) {
                $validator->errors()->add('ponies', "Le poney sélectionné est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }
    }


    public function validateEmployeesAvailability(Validator $validator, $appointmentId, $appointment_date, $start_time, $end_time, $employees)
    {
        foreach ($employees as $employeeId) {
            $employee = Employee::find($employeeId);
            if ($employee->appointments()->where('id', '!=', $appointmentId)
                ->where('appointment_date', $appointment_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->where('start_time', '<', $end_time)
                        ->where('end_time', '>', $start_time);
                })->exists()) {
                $employeeName = $employee->first_name . ' ' . $employee->last_name;
                $validator->errors()->add('employees', "L'employé \"$employeeName\" est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }
    }
}
