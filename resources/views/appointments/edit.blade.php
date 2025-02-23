@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Éditer le Rendez-Vous</h1>
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h4>Informations sur le Client :</h4>
            <label>Nom :</label>
            <input type="text" value="{{ $appointment->group->client->last_name }}" disabled class="form-control">
            <label>Prénom :</label>
            <input type="text" value="{{ $appointment->group->client->first_name }}" disabled class="form-control">
            <label>Adresse :</label>
            <input type="text" value="{{ $appointment->group->client->address }}" disabled class="form-control">
            <label>Email :</label>
            <input type="mail" value="{{ $appointment->group->client->email }}" disabled class="form-control">

            <h4 class="mt-3">Informations sur le Rendez-Vous</h4>
            <label>Date :</label>
            <input type="date" name="appointment_date" value="{{ $appointment->appointment_date }}" required class="form-control">
            <label>Heure de Début :</label>
            <input type="time" name="start_time" value="{{ $appointment->start_time }}" required class="form-control">
            <label>Heure de Fin :</label>
            <input type="time" name="end_time" value="{{ $appointment->end_time }}" required class="form-control">
            <label>Nombre de Personnes :</label>
            <input type="number" name="number_of_people" value="{{ $appointment->group->number_of_people }}" required class="form-control">
            <label>Nombre de Poneys Assignés :</label>
            <input type="number" name="assigned_ponies_count" value="{{ $appointment->assigned_ponies_count }}" required class="form-control">

            <label>Assigner des Employés :</label>
            <select name="employees[]" multiple class="form-control">
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @if(in_array($employee->id, $appointment->employees->pluck('id')->toArray())) selected @endif>{{ $employee->last_name }} {{ $employee->first_name }}</option>
                @endforeach
            </select>

            <label>Assigner des Poneys :</label>
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

            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
