<?php

namespace App\Http\Controllers;

use App\Events\AppointmentCreated;
use App\Http\Requests\AssignPonyEmployeeRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Pony;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Appointment::class);
        $appointments = Appointment::where('appointment_date', '=', \Carbon\Carbon::today()->toDateString())
            ->paginate(5);



        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();


        return view('appointments.index', compact('appointments', 'clients', 'ponies', 'employees'));
    }


    public function all(Request $request)
    {
        $this->authorize('viewAny', Appointment::class);
        $appointments = Appointment::with(['group.client', 'ponies', 'employees'])
            ->when($request->client_id, function ($query, $clientId) {
                return $query->whereHas('group.client', fn($q) => $q->where('id', $clientId));
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('appointment_date', $date);
            })
            ->when($request->employee_id, function ($query, $employeeId) {
                return $query->whereHas('employees', fn($q) => $q->where('employees.id', $employeeId));
            })
            ->paginate(5);

        return view('appointments.all', [
            'appointments' => $appointments,
            'clients' => Client::orderBy('last_name')->get(), // Liste des clients triés par nom
            'employees' => Employee::orderBy('last_name')->get(), // Liste des employés triée
        ]);
    }


    public function show($id)
    {

        $appointment = Appointment::with('group.client', 'ponies', 'employees')->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function create()
    {
        $this->authorize('create', Appointment::class);
        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();
        return view('appointments.create', compact('clients', 'ponies', 'employees'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $this->authorize('create', Appointment::class);

        // Utiliser un client existant ou créer un nouveau client
        if ($request->filled('client_id')) {
            $client = Client::find($request->client_id);
        } else {
            $client = Client::create($request->only('last_name', 'first_name', 'address','email'));
        }

        // Créer un groupe
        $group = Group::create([
            'number_of_people' => $request->number_of_people,
            'client_id' => $client->id
        ]);
        $start_time = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = $start_time->copy()->addHours($request->input('duration', 1));
        $request->merge(['end_time' => $end_time->format('H:i')]);



                // Créer un rendez-vous
        $appointment = Appointment::create([
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            //'end_time' => $request->end_time,
            'end_time' => $request->end_time,
            'group_id' => $group->id,
            'assigned_ponies_count' => $request->assigned_ponies_count
        ]);
        Log::info('Rendez-vous créé : ' . $appointment->id);

        // Assigner les employés et poneys au rendez-vous
        $appointment->employees()->sync($request->employees);
        $appointment->ponies()->sync($request->ponies);
        Log::info('Employés et poneys assignés');
        $appointment->load('group.client', 'employees', 'ponies');
        event(new AppointmentCreated($appointment));

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous crée avec succès.');;
    }

    public function edit($id)
    {
        $appointment = Appointment::with('group.client', 'ponies', 'employees')->findOrFail($id);
        $this->authorize('update', $appointment);
        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();
        return view('appointments.edit', compact('appointment', 'clients', 'ponies', 'employees'));
    }


    public function update(UpdateAppointmentRequest $request, $id)
    {

        $appointment = Appointment::findOrFail($id);
        $this->authorize('update', $appointment);


        // Mettre à jour les informations du rendez-vous
        $appointment->update($request->only('appointment_date', 'start_time', 'end_time', 'assigned_ponies_count'));

        // Mettre à jour les employés et poneys assignés
        $appointment->employees()->sync($request->employees);
        $appointment->ponies()->sync($request->ponies);

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }


        public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return redirect()->route('appointments.all');
    }

    public function assign(AssignPonyEmployeeRequest $request)
    {
        \Log::info('Entrée dans la méthode assign');

        $appointmentId = $request->appointment_id;
        $appointment = Appointment::findOrFail($appointmentId);

        \Log::info('Rendez-vous trouvé : ' . $appointment->id);

        // Assigner les employés et poneys au rendez-vous
        $appointment->employees()->sync($request->employees);
        $appointment->ponies()->sync($request->ponies);

        \Log::info('Employés et poneys assignés');

        return redirect()->route('appointments.index')->with('success', 'Assignations mises à jour avec succès.');
    }

    public function validatePonyCount(Request $request)
    {
        $request->validate([
            'assigned_ponies_count' => 'required|integer|min:1'
        ]);

        return redirect()->back()
            ->withInput($request->all())
            ->with('ponies_fields', $request->assigned_ponies_count);
    }


    public function today()
    {
        $today = Carbon::today()->toDateString();
        $appointments = Appointment::with('group.client')->where('appointment_date', $today)->get();

        return view('appointments.today', compact('appointments'));
    }

}


