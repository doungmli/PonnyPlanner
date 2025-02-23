<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Pony;
use App\Services\AppointmentValidationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class StoreAppointmentRequest extends FormRequest
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
            'client_id' => 'required_without:last_name,first_name,address|exists:clients,id',
            'last_name' => 'required_without:client_id|string|max:255',
            'first_name' => 'required_without:client_id|string|max:255',
            'address' => 'required_without:client_id|string|max:255',
            'email' => 'required_without:client_id|string|max:255',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            //'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:1|max:2', // Validation de la durée
            'number_of_people' => 'required|integer|min:1',
            'assigned_ponies_count' => 'required|integer|min:1',
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,id',

        ];
    }
    public function messages(): array
    {
        return [
            'client_id.required_without' => 'Veuillez sélectionner un client existant ou fournir les informations d\'un nouveau client.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            'last_name.required_without' => 'Le nom du nouveau client est requis si aucun client existant n\'est sélectionné.',
            'first_name.required_without' => 'Le prénom du nouveau client est requis si aucun client existant n\'est sélectionné.',
            'address.required_without' => 'L\'adresse du nouveau client est requise si aucun client existant n\'est sélectionné.',
            'email.required_without' => 'L\'adresse mail du nouveau client est requise si aucun client existant n\'est sélectionné.',
            'appointment_date.required' => 'La date du rendez-vous est requise.',
            'start_time.required' => 'L\'heure de début du rendez-vous est requise.',
            'end_time' => 'required|date_format:H:i|after:start_time', // Garder cette règle
            'duration' => 'required|integer|min:1|max:2', // Validation de la durée
            'number_of_people' => 'required|integer|min:1',
            'number_of_people.required' => 'Le nombre de personnes est requis.',
            'assigned_ponies_count.required' => 'Le nombre de poneys assignés est requis.',
            'employees.required' => 'Veuillez assigner au moins un employé.',
            'employees.*.exists' => 'L\'employé sélectionné n\'existe pas.',
            'ponies' => 'array',
            'ponies.*' => 'exists:ponies,id'

        ];
    }

    public function withValidator(Validator $validator): void
    {
        $start_time = \Carbon\Carbon::createFromFormat('H:i', $this->start_time);
        $end_time = $start_time->copy()->addHours($this->input('duration', 1));
        $this->merge(['end_time' => $end_time->format('H:i')]); // Ajouter l'heure de fin avant la validation

        $validator->after(function ($validator) use ($end_time) {
            $appointmentId = null; // Nouvel rendez-vous sans ID
            $this->validationService->validateEmployeesAvailability(
                $validator,
                $appointmentId,
                $this->appointment_date,
                $this->start_time,
                $end_time->format('H:i'),
                $this->input('employees', [])
            );
            $this->validationService->validatePoniesAvailability(
                $validator,
                $appointmentId,
                $this->appointment_date,
                $this->start_time,
                $end_time,
                $this->input('ponies', []),

            );

            // Validation des heures de travail des poneys
            foreach ($this->input('ponies', []) as $ponyId) {
                $pony = Pony::find($ponyId);
                $workingHours = $pony->working_hours + $this->input('duration', 1);
                if ($workingHours > $pony->max_working_hours) {
                    $validator->errors()->add('ponies', "Le poney {$pony->name} ne peut pas être assigné à plus de {$pony->max_working_hours} heures de travail.");
                }
            }
            $ponies = $this->input('ponies', []);
            if (count($ponies) !== count(array_unique($ponies))) {
                $validator->errors()->add('ponies', 'Chaque poney doit être unique dans le même rendez-vous.');
            }
            $employees = $this->input('employees', []);
            if (count($employees) !== count(array_unique($employees))) {
                $validator->errors()->add('employees', 'Chaque employé doit être unique dans le même rendez-vous.');
            }
        });
    }
}
