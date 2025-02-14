
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails du Rendez-vous</h1>
        <p>Date : {{ $appointment->appointment_date }}</p>
        <p>Heure de début : {{ $appointment->start_time }}</p>
        <p>Heure de fin : {{ $appointment->end_time }}</p>
        <p>Groupe : {{ $appointment->group->id }}</p>

        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Retour à la Liste</a>
    </div>
@endsection
