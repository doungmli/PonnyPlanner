
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border p-4 mb-4">
            <h1 class="text-center mb-4">Détails du Rendez-vous</h1>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('d F Y') }}
                </div>
                <div class="col-md-6">
                    <strong>Heure de début :</strong> {{ $appointment->start_time }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Heure de fin :</strong> {{ $appointment->end_time }}
                </div>
                <div class="col-md-6">
                    <strong>Groupe ID :</strong> {{ $appointment->group->id }}
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('appointments.all') }}" class="btn btn-secondary">Retour à la Liste</a>
            </div>
        </div>
    </div>
@endsection

