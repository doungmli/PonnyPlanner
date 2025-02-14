<!-- resources/views/invoices/show.blade.php -->
{{--
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la Facture</h1>

        <div class="invoice-details">
            <strong>Mois : {{ $invoice->month }} {{ $invoice->year }}</strong>
            <p>Total : {{ $invoice->total_amount }} €</p>
            <p>Groupe : {{ $invoice->group->id }}</p>

            <h3>Détails des Rendez-Vous</h3>
            @foreach($invoice->appointments as $appointment)
                <p>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}: {{ $appointment->appointment_date }} {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
            @endforeach

            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary">Télécharger en PDF</a>
        </div>
    </div>
@endsection
--}}

<!-- resources/views/invoices/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la Facture</h1>

        <div class="invoice-details">
            <strong>Mois : {{ $invoice->month }} {{ $invoice->year }}</strong>
            <p>Total : {{ $invoice->total_amount }} €</p>
            <p>Groupe : {{ $invoice->group->id }}</p>

            <h3>Détails des Rendez-Vous</h3>
            @foreach($invoice->appointments as $appointment)
                <p>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}: {{ $appointment->appointment_date }} {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
            @endforeach

            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary">Télécharger en PDF</a>
        </div>
    </div>
@endsection
