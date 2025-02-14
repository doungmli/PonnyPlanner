<?php

namespace App\Http\Controllers;

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
//    public function __construct()
//    {
//        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
//        $this->middleware('role:staff')->only(['index', 'show']);
//    }
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
/*        $appointments = Appointment::whereDate('appointment_date', $today)
            ->with('group.client', 'ponies', 'employees')
            ->get();*/
        $appointments = Appointment::where('appointment_date', '=', \Carbon\Carbon::today()->toDateString())
            ->paginate(5);



        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();


        return view('appointments.index', compact('appointments', 'clients', 'ponies', 'employees'));
    }

/*
    public function all()
    {
        $appointments = Appointment::with('group.client', 'ponies', 'employees')->get();
        dd($appointments);
        return view('appointment.all', compact('appointments'));
    }*/


    public function all()
    {
        $appointments = Appointment::paginate(5);
        return view('appointments.all', compact('appointments'));
    }



    public function show($id)
    {
        $appointment = Appointment::with('group.client', 'ponies', 'employees')->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function create()
    {
        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();
        return view('appointments.create', compact('clients', 'ponies', 'employees'));
    }

/*    public function store(Request $request)
    {
        // Utiliser un client existant ou créer un nouveau client
        if ($request->filled('client_id')) {
            $client = Client::find($request->client_id);
        } else {
            $client = Client::create($request->only('last_name', 'first_name', 'address'));
        }

        // Créer un groupe
        $group = Group::create([
            'number_of_people' => $request->number_of_people,
            'client_id' => $client->id
        ]);

        // Créer un rendez-vous
        $appointment = Appointment::create([
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'group_id' => $group->id,
            'assigned_ponies_count' => $request->assigned_ponies_count
        ]);

        // Assigner les employés et poneys au rendez-vous
        $appointment->employees()->sync($request->employees);
        $appointment->ponies()->sync($request->ponies);

        return redirect()->route('appointments.index');
    }*/

    public function store(StoreAppointmentRequest $request)
    {
        // Utiliser un client existant ou créer un nouveau client
        if ($request->filled('client_id')) {
            $client = Client::find($request->client_id);
        } else {
            $client = Client::create($request->only('last_name', 'first_name', 'address'));
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

        return redirect()->route('appointments.index');
    }

    public function edit($id)
    {
        $appointment = Appointment::with('group.client', 'ponies', 'employees')->findOrFail($id);
        $clients = Client::all();
        $ponies = Pony::all();
        $employees = Employee::all();
        return view('appointments.edit', compact('appointment', 'clients', 'ponies', 'employees'));
    }

/*    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        $appointment->employees()->sync($request->employees);
        $appointment->ponies()->sync($request->ponies);
        return redirect()->route('appointments.all');
    }*/

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

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
        $appointment->delete();
        return redirect()->route('appointments.all');
    }





/*    public function assign(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->ponies()->sync($request->ponies);
        $appointment->employees()->sync($request->employees);

        return redirect()->route('appointments.index')->with('success', 'Les poneys et employés ont été assignés avec succès.');
    }*/

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
        $validated = $request->validate([
            'assigned_ponies_count' => 'required|integer|min:1'
        ]);

        return redirect()->back()
            ->withInput($request->all())
            ->with('ponies_fields', $request->assigned_ponies_count);
    }
    public function validateEmployeeCount(Request $request)
    {
        $validated = $request->validate([
            'assigned_employees_count' => 'required|integer|min:1'
        ]);

        return redirect()->back()
            ->withInput($request->all())
            ->with('employees_fields', $request->assigned_employees_count);
    }
/*    public function validateCounts(Request $request)
    {
        $validated = $request->validate([
            'assigned_ponies_count' => 'required|integer|min:1',
            'assigned_employees_count' => 'required|integer|min:1'
        ]);

        return redirect()->back()
            ->withInput($request->all())
            ->with('ponies_fields', $request->assigned_ponies_count)
            ->with('employees_fields', $request->assigned_employees_count);
    }*/

}


