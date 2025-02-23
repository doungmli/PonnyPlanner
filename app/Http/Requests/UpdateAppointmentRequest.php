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
            'end_time' => 'required|date_format:H:i',
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
            $end_time = $this->input('end_time');
            $this->validationService->validatePoniesAvailability(
                $validator,
                $appointmentId,
                $this->appointment_date,
                $this->start_time,
                $end_time,
                $this->input('ponies', []),

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
}
