@extends('layouts.app')
{{--<pre>{{ print_r(session()->all(), true) }}</pre>--}}
@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Gestion Journalière</h1>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('appointments.all') }}" class="btn btn-secondary">Voir Tous les Rendez-vous</a>
        </div>

        <div class="row">
            <!-- Colonne Gauche: Rendez-vous prévus -->
            <div class="col-md-6">
                <div class="border p-4 mb-4">
                    <h2>{{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('l d F Y') }}</h2>
                    <div class="appointments">
                        <h3 class="mb-4">Rendez-vous prévus :</h3>
                        @foreach($appointments as $appointment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}</h5>
                                    <p class="card-text">{{ $appointment->start_time }} à {{ $appointment->end_time }}</p>
{{--                                    <a href="?show={{ $appointment->id }}" class="btn btn-info">Détails</a>--}}
                                    <a href="{{ request()->fullUrlWithQuery(['show' => $appointment->id, 'page' => request('page')]) }}#appointment-{{ $appointment->id }}" class="btn btn-info">Détails</a>                                    @if(request('show') == $appointment->id)
                                        <div class="mt-3">
                                            <form action="{{ route('appointments.assign') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                                                <label>Assigner des poneys :</label>
                                                <div class="row">
                                                    @for ($i = 0; $i < $appointment->assigned_ponies_count; $i++)
                                                        <div class="col-md-6">
                                                            <select name="ponies[]" class="form-control mb-2">
                                                                @foreach($ponies as $pony)
                                                                    <option value="{{ $pony->id }}" @if(isset($appointment->ponies[$i]) && $pony->id == $appointment->ponies[$i]->id) selected @endif>{{ $pony->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <label>Assigner des employés :</label>
                                                <div class="row">
                                                    @for ($i = 0; $i < $appointment->employees->count(); $i++)
                                                        <div class="col-md-6">
                                                            <select name="employees[]" class="form-control mb-2">
                                                                @foreach($employees as $employee)
                                                                    <option value="{{ $employee->id }}" @if(isset($appointment->employees[$i]) && $employee->id == $appointment->employees[$i]->id) selected @endif>{{ $employee->last_name }} {{ $employee->first_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">Confirmer</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>

            <!-- Colonne Droite: Enregistrer un nouveau rendez-vous et client -->
            <div class="col-md-6">
                <div class="border p-4">
                    <h3>Créer un Nouveau Rendez-Vous</h3>
                    <form action="{{ route('appointments.validatePonyCount') }}" method="POST">
                        @csrf
                        @if (!request('new_client'))
                            <h4>Choisir un client existant :</h4>
                            <select name="client_id" class="form-control" value="{{ old('client_id') }}">
                                <option value="">--- Sélectionner un client ---</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->last_name }} {{ $client->first_name }}</option>
                                @endforeach
                            </select>
                            <a href="{{ request()->fullUrlWithQuery(['new_client' => true]) }}" class="btn btn-primary mt-2">+ Nouveau Client</a>
                        @else
                            <div class="mt-3">
                                <h4>Créer un nouveau client :</h4>
                                <label>Nom :</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Nom du nouveau client" class="form-control">
                                <label>Prénom :</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Prénom du nouveau client" class="form-control">
                                <label>Adresse :</label>
                                <input type="text" name="address" value="{{ old('address') }}" placeholder="Adresse du nouveau client" class="form-control">
                                <label>Email :</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email du nouveau client" class="form-control">
                                <a href="{{ request()->fullUrlWithoutQuery(['new_client']) }}" class="btn btn-secondary mt-2">Annuler</a>

                            </div>
                        @endif

                        <h4 class="mt-3">Informations sur le Rendez-Vous</h4>
                        <label>Date :</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required class="form-control">
                        <label>Heure de Début :</label>
{{--                        <input type="time" name="start_time" value="{{ old('start_time') }}" required class="form-control" >--}}
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="form-control" required min="10:00" max="18:00" >

                        <label>Durée :</label>
                        <select name="duration" required class="form-control">
                            <option value="1" {{ old('duration') == 1 ? 'selected' : '' }}>1 heure</option>
                            <option value="2" {{ old('duration') == 2 ? 'selected' : '' }}>2 heures</option>
                        </select>

                        <label>Nombre de Personnes :</label>
                        <input type="number" name="number_of_people" value="{{ old('number_of_people') }}" required class="form-control">

                        <label>Nombre de Poneys Assignés :</label>
                        <input type="number" name="assigned_ponies_count" value="{{ old('assigned_ponies_count', 1) }}" required class="form-control">

                        <button type="submit" class="btn btn-primary mt-3">Valider les informations</button>
                    </form>

                    @if(session('ponies_fields') || old('assigned_ponies_count'))
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf

                            @if (!request('new_client'))
                                <input type="hidden" name="client_id" value="{{ old('client_id') }}">
                            @else
                                <input type="hidden" name="last_name" value="{{ old('last_name') }}">
                                <input type="hidden" name="first_name" value="{{ old('first_name') }}">
                                <input type="hidden" name="address" value="{{ old('address') }}">
                                <input type="hidden" name="email" value="{{ old('email') }}">


                            @endif

                            <input type="hidden" name="appointment_date" value="{{ old('appointment_date') }}">
                            <input type="hidden" name="start_time" value="{{ old('start_time') }}">
                            <input type="hidden" name="duration" value="{{ old('duration') }}">
                            <input type="hidden" name="number_of_people" value="{{ old('number_of_people') }}">
                            <input type="hidden" name="assigned_ponies_count" value="{{ old('assigned_ponies_count') ?? session('ponies_fields', 1) }}">

                            <h4 class="mt-3">Assigner des Poneys :</h4>
                            <div class="row">
                                @for ($i = 0; $i < (old('assigned_ponies_count') ?? session('ponies_fields', 1)); $i++)
                                    <div class="col-md-6 mb-2">
                                        <select name="ponies[]" class="form-control">
                                            @foreach($ponies as $pony)
                                                <option value="{{ $pony->id }}" {{ old('ponies.' . $i) == $pony->id ? 'selected' : '' }}>{{ $pony->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                            </div>

                            <h4 class="mt-3">Assigner des Employés :</h4>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <select name="employees[]" class="form-control" multiple>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ in_array($employee->id, old('employees', [])) ? 'selected' : '' }}>{{ $employee->last_name }} {{ $employee->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection









