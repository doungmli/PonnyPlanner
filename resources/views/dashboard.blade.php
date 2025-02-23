@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Tableau de Bord</h1>

        <div class="row">
            <!-- Carte : Nombre de rendez-vous aujourd'hui -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Rendez-vous Aujourd'hui</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $appointmentsTodayCount }}</h5>
                        <p class="card-text">Nombre de rendez-vous aujourd'hui.</p>
                        <a href="{{ route('appointments.index') }}" class="btn btn-light">Voir</a>
                    </div>
                </div>
            </div>
            @can('viewAny', App\Models\Pony::class)
            <!-- Carte : Nombre de poneys -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Nombre de Poneys</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $poniesCount }}</h5>
                        <p class="card-text">Nombre total de poneys.</p>
                        <a href="{{ route('ponies.index') }}" class="btn btn-light">Voir</a>
                    </div>
                </div>
            </div>
            @endcan

            <!-- Carte : Factures clôturées ce mois-ci -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Factures Clôturées</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $invoicesClosedCount }}</h5>
                        <p class="card-text">Factures clôturées ce mois-ci.</p>
                        <a href="{{ route('invoices.index') }}" class="btn btn-light">Voir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
