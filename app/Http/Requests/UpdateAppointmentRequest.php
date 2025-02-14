<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Services\AppointmentValidationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class UpdateAppointmentRequest extends FormRequest
{
    protected $validationService;

    public function __construct(AppointmentValidationService $validationService)
    {
        $this->validationService = $validationService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'number_of_people' => 'required|integer|min:1',
            'assigned_ponies_count' => 'required|integer|min:1',
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,id',
            'ponies' => 'required|array',
            'ponies.*' => 'exists:ponies,id',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $appointmentId = $this->route('appointment');
            $end_time = \Carbon\Carbon::createFromFormat('H:i', $this->start_time)->addHours($this->input('duration', 1))->format('H:i');
            $this->validationService->validatePoniesAvailability(
                $validator,
                $appointmentId,
                $this->appointment_date,
                $this->start_time,
                $end_time,
                $this->input('ponies', []),
                15
            );
            $this->validationService->validateEmployeesAvailability(
                $validator,
                $appointmentId,
                $this->appointment_date,
                $this->start_time,
                $end_time,
                $this->input('employees', [])
            );
        });
    }
   /* public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $appointmentId = $this->route('appointment');
            $this->validateAvailability($validator, $appointmentId);
        });
    }

    private function validateAvailability(Validator $validator, $appointmentId): void
    {
        $start_time = $this->input('start_time');
        $end_time = $this->input('end_time');
        $appointment_date = $this->input('appointment_date');

        $ponies = $this->input('ponies', []);
        $employees = $this->input('employees', []);

        // Validation des poneys
        foreach ($ponies as $ponyId) {
            $conflictingAppointments = Appointment::where('id', '!=', $appointmentId)
                ->where('appointment_date', $appointment_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($query) use ($start_time, $end_time) {
                            $query->where('start_time', '<=', $start_time)
                                ->where('end_time', '>=', $end_time);
                        });
                })
                ->whereHas('ponies', function ($query) use ($ponyId) {
                    $query->where('pony_id', $ponyId);
                })
                ->exists();

            if ($conflictingAppointments) {
                $validator->errors()->add('ponies', "Le poney avec ID $ponyId est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }

        // Validation des employés
        foreach ($employees as $employeeId) {
            $conflictingAppointments = Appointment::where('id', '!=', $appointmentId)
                ->where('appointment_date', $appointment_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($query) use ($start_time, $end_time) {
                            $query->where('start_time', '<=', $start_time)
                                ->where('end_time', '>=', $end_time);
                        });
                })
                ->whereHas('employees', function ($query) use ($employeeId) {
                    $query->where('employee_id', $employeeId);
                })
                ->exists();

            if ($conflictingAppointments) {
                $validator->errors()->add('employees', "L'employé avec ID $employeeId est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }
    }*/
}
