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
}
