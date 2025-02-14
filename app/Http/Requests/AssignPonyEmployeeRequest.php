<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Pony;
use App\Services\AppointmentValidationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AssignPonyEmployeeRequest extends FormRequest
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
            'ponies' => 'required|array',
            'ponies.*' => 'exists:ponies,id',
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,id',
        ];
    }
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $appointmentId = $this->input('appointment_id');
            $appointment = \App\Models\Appointment::find($appointmentId); // Get the existing appointment

            $this->validationService->validatePoniesAvailability(
                $validator,
                $appointmentId,
                $appointment->appointment_date,
                $appointment->start_time,
                $appointment->end_time,
                $this->input('ponies', []),
                0
            );
            $this->validationService->validateEmployeesAvailability(
                $validator,
                $appointmentId,
                $appointment->appointment_date,
                $appointment->start_time,
                $appointment->end_time,
                $this->input('employees', [])
            );
        });
    }
/*    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $appointmentId = $this->input('appointment_id');
            $this->validateAvailability($validator, $appointmentId);
        });
    }

    private function validateAvailability(Validator $validator, $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $start_time = $appointment->start_time;
        $end_time = $appointment->end_time;
        $appointment_date = $appointment->appointment_date;

        $ponies = $this->input('ponies', []);
        $employees = $this->input('employees', []);

        // Validation des poneys
        foreach ($ponies as $ponyId) {
            $conflictingAppointments = Appointment::where('id', '!=', $appointmentId)
                ->where('appointment_date', $appointment_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->where(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<', $end_time)
                            ->where('end_time', '>', $start_time);
                    });
                })
                ->whereHas('ponies', function ($query) use ($ponyId) {
                    $query->where('pony_id', $ponyId);
                })
                ->exists();

            if ($conflictingAppointments) {
                $ponyName = Pony::find($ponyId)->name;
                $validator->errors()->add('ponies', "Le poney \"$ponyName\" est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }

        // Validation des employés
        foreach ($employees as $employeeId) {
            $conflictingAppointments = Appointment::where('id', '!=', $appointmentId)
                ->where('appointment_date', $appointment_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->where(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<', $end_time)
                            ->where('end_time', '>', $start_time);
                    });
                })
                ->whereHas('employees', function ($query) use ($employeeId) {
                    $query->where('employee_id', $employeeId);
                })
                ->exists();

            if ($conflictingAppointments) {
                $employeeName = Employee::find($employeeId)->first_name . ' ' . Employee::find($employeeId)->last_name;
                $validator->errors()->add('employees', "L'employé \"$employeeName\" est déjà assigné à un autre rendez-vous dans la même tranche horaire.");
            }
        }
    }*/
}
