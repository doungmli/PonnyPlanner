<!-- resources/views/invoices/index.blade.php -->
@extends('layouts.app')

{{--
@section('content')
    <div class="container">
        <h1>Gestion des Factures</h1>

        <!-- Liste des factures -->
        <div class="invoices-list">
            @foreach($invoices as $invoice)
                <div class="invoice">
                    <a href="{{ route('invoices.show', $invoice->id) }}">
                        <strong>{{ $invoice->month }} {{ $invoice->year }}</strong>: {{ $invoice->total_amount }} €
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Résumé mensuel -->
        <div class="monthly-summary mt-5">
            <h3>Résumé Mensuel</h3>
            <select id="month-selector" class="form-control">
                @foreach($months as $month)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endforeach
            </select>
            <div id="summary-details"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('month-selector').addEventListener('change', function() {
            var month = this.value;
            fetch(`/invoices/summary/${month}`)
                .then(response => response.json())
                .then(data => {
                    var detailsDiv = document.getElementById('summary-details');
                    detailsDiv.innerHTML = '<h4>Détails pour ' + month + '</h4>';
                    data.forEach(appointment => {
                        detailsDiv.innerHTML += '<p>' + appointment.group.client.last_name + ' ' + appointment.group.client.first_name + ': ' + appointment.appointment_date + ' ' + appointment.start_time + ' - ' + appointment.end_time + '</p>';
                    });
                });
        });
    </script>
@endsection
--}}

<!-- resources/views/invoices/index.blade.php -->
<!-- Dernières modification -->

{{--@section('content')
    <div class="container">
        <h1>Gestion des Factures</h1>

        <!-- Liste des factures -->
        <div class="invoices-list">
            @foreach($invoices as $invoice)
                <div class="invoice">
                    <a href="{{ route('invoices.show', $invoice->id) }}">
                        <strong>{{ $invoice->month }} {{ $invoice->year }}</strong>: {{ $invoice->total_amount }} €
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Résumé mensuel -->
        <div class="monthly-summary mt-5">
            <h3>Résumé Mensuel</h3>
            <select id="month-selector" class="form-control">
                @foreach($months as $month)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endforeach
            </select>
            <div id="summary-details"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('month-selector').addEventListener('change', function() {
            var month = this.value;
            fetch(`/invoices/summary/${month}`)
                .then(response => response.json())
                .then(data => {
                    var detailsDiv = document.getElementById('summary-details');
                    detailsDiv.innerHTML = '<h4>Détails pour ' + month + '</h4>';
                    data.forEach(appointment => {
                        detailsDiv.innerHTML += '<p>' + appointment.group.client.last_name + ' ' + appointment.group.client.first_name + ': ' + appointment.appointment_date + ' ' + appointment.start_time + ' - ' + appointment.end_time + '</p>';
                    });
                });
        });
    </script>
@endsection--}}

<!-- resources/views/invoices/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Factures</h1>

        <!-- Liste des factures -->
        <div class="invoices-list">
            @foreach($invoices as $invoice)
                <div class="invoice">
                    <a href="{{ route('invoices.show', $invoice->id) }}">
                        <strong>{{ $invoice->month }} {{ $invoice->year }}</strong>: {{ $invoice->total_amount }} €
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
