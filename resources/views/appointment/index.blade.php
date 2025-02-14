@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion Journalière</h1>
        <h2>{{ \Carbon\Carbon::now()->format('l d F Y') }}</h2>

        <!-- Rendez-vous prévus -->
        <div class="appointments">
            <h3>Rendez-vous prévus :</h3>
            @foreach($appointments as $appointment)
                <div class="card mb-3">
                    <div class="card-body">
                        <strong>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}</strong>,
                        {{ $appointment->start_time }} à {{ $appointment->end_time }}
                        <a href="?show={{ $appointment->id }}" class="btn btn-info">Détails</a>
                        @if(request('show') == $appointment->id)
                            <div class="mt-3">
                                <form action="{{ route('appointments.assign') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                    <label>Assigner des poneys :</label>
                                    <select name="ponies[]" multiple class="form-control">
                                        @foreach($ponies as $pony)
                                            <option value="{{ $pony->id }}">{{ $pony->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Assigner des employés :</label>
                                    <select name="employees[]" multiple class="form-control">
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->last_name }} {{ $employee->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Confirmer</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Enregistrer un nouveau rendez-vous et client -->
        <div class="new-appointment">
            <h3>Créer un Nouveau Rendez-Vous</h3>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <h4>Choisir un client existant :</h4>
                <select name="client_id" class="form-control">
                    <option value="">--- Sélectionner un client ---</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }}</option>
                    @endforeach
                </select>
                <a href="?new_client=true" class="btn btn-primary mt-2">+ Nouveau Client</a>
                @if(request('new_client'))
                    <div class="mt-3">
                        <h4>Créer un nouveau client :</h4>
                        <label>Nom :</label>
                        <input type="text" name="last_name" placeholder="Nom du nouveau client" class="form-control">
                        <label>Prénom :</label>
                        <input type="text" name="first_name" placeholder="Prénom du nouveau client" class="form-control">
                        <label>Adresse :</label>
                        <input type="text" name="address" placeholder="Adresse du nouveau client" class="form-control">
                    </div>
                @endif

                <h4 class="mt-3">Informations sur le Rendez-Vous</h4>
                <label>Date :</label>
                <input type="date" name="appointment_date" required class="form-control">
                <label>Heure de Début :</label>
                <input type="time" name="start_time" required class="form-control">
                <label>Heure de Fin :</label>
                <input type="time" name="end_time" required class="form-control">
                <label>Nombre de Personnes :</label>
                <input type="number" name="number_of_people" required class="form-control">
                <label>Nombre de Poneys Assignés :</label>
                <input type="number" name="assigned_ponies_count" required class="form-control">

                <label>Assigner des Employés :</label>
                <select name="employees[]" multiple class="form-control">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->last_name }} {{ $employee->first_name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
            </form>
        </div>
    </div>
@endsection
