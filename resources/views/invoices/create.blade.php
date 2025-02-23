@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer une Nouvelle Facture</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="group_id">Groupe :</label>
                <select name="group_id" id="group_id" class="form-control" required onchange="location.href='{{ url('invoices/create') }}?group_id=' + this.value">
                    <option value="">Sélectionnez un groupe</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $selectedGroup && $selectedGroup->id == $group->id ? 'selected' : '' }}>
                            {{ $group->client->first_name }} {{ $group->client->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($selectedGroup)
                <div id="group_details">
                    <p><strong>ID du Groupe :</strong> {{ $selectedGroup->id }}</p>
                    <p><strong>Client :</strong> {{ $selectedGroup->client->first_name }} {{ $selectedGroup->client->last_name }}</p>
                </div>
                <div class="form-group">
                    <label for="appointment_id">Rendez-vous :</label>
                    <select name="appointment_id" id="appointment_id" class="form-control" required onchange="location.href='{{ url('invoices/create') }}?group_id={{ $selectedGroup->id }}&appointment_id=' + this.value">
                        @foreach($appointments as $appointment)
                            @php
                                $start_time = Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time);
                                $end_time = Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time);
                                $duration = $start_time->diffInHours($end_time);
                            @endphp
                            <option value="{{ $appointment->id }}" {{ $selectedAppointment && $selectedAppointment->id == $appointment->id ? 'selected' : '' }}>
                                {{ $appointment->appointment_date }} - {{ $selectedGroup->client->first_name }} {{ $selectedGroup->client->last_name }} - {{ $selectedGroup->number_of_people }} personnes - {{ $duration }} heures
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="form-group">
                <label for="month">Mois :</label>
                <input type="number" name="month" id="month" class="form-control" value="{{ $currentMonth }}" required readonly>
            </div>
            <div class="form-group">
                <label for="year">Année :</label>
                <input type="number" name="year" id="year" class="form-control" value="{{ $currentYear }}" required readonly>
            </div>
            <div class="form-group">
                <label for="prix_unitaire_tvac">Prix Unitaire TVAC :</label>
                <input type="number" name="prix_unitaire_tvac" id="prix_unitaire_tvac" class="form-control" step="0.01" value="30.00">
            </div>
            <div class="form-group">
                <label for="status">Statut :</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="à payer">À payer</option>
                    <option value="payé">Payé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
    </div>
@endsection
