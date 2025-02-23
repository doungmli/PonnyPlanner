@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Gestion de Tous les Rendez-Vous</h1>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Retour</a>

        <!-- Barre de recherche et filtres -->
        <form method="GET" action="{{ route('appointments.all') }}" class="mb-4">
            <div class="row">
                <!-- Recherche par client -->
                <div class="col-md-4">
                    <label for="client_id">Client :</label>
                    <select name="client_id" id="client_id" class="form-control">
                        <option value="">Tous les clients</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->last_name }} {{ $client->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtrer par date -->
                <div class="col-md-3">
                    <label for="date">Date :</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>

                <!-- Filtrer par employé -->
                <div class="col-md-3">
                    <label for="employee_id">Employé :</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Tous les employés</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->last_name }} {{ $employee->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton de soumission -->
                <div class="col-md-2">
                    <label>&nbsp;</label> <!-- Alignement -->
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>

        <!-- Liste des rendez-vous -->
        <div class="appointments">
            <h3 class="mb-4">Rendez-vous :</h3>
            @forelse($appointments as $appointment)
                <div class="card mb-3">
                    <div class="card-body">
                        <strong>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}</strong>,
                        {{ $appointment->appointment_date }} {{ $appointment->start_time }} à {{ $appointment->end_time }}

                        <div class="mt-3">
                            <strong>Poneys assignés :</strong>
                            <ul>
                                @foreach($appointment->ponies as $pony)
                                    <li>{{ $pony->name }}</li>
                                @endforeach
                            </ul>

                            <strong>Employés assignés :</strong>
                            <ul>
                                @foreach($appointment->employees as $employee)
                                    <li>{{ $employee->last_name }} {{ $employee->first_name }}</li>
                                @endforeach
                            </ul>

                            <div class="mt-3">
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info">Voir</a>
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Éditer</a>
                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @can('delete', @$appointment)
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce rendez-vous ?');">Supprimer</button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Aucun rendez-vous trouvé.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $appointments->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
