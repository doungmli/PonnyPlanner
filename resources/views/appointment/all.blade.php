@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion de Tous les Rendez-Vous</h1>
        <div class="appointments">
            <h3>Rendez-vous :</h3>
            @foreach($appointments as $appointment)
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
                                @if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'staff')
                                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Éditer</a>
                                @endif
                                @if(auth()->user()->role->name == 'admin')
                                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
