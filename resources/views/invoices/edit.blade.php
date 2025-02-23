
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la Facture</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="group_id">Groupe :</label>
                <select name="group_id" id="group_id" class="form-control"  disabled>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $invoice->group_id == $group->id ? 'selected' : '' }}>{{ $group->client->first_name }} {{ $group->client->last_name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="group_id" value="{{ $invoice->group_id }}">
            </div>
            <div class="form-group">
                <label for="month">Mois :</label>
                <input type="number" name="month" id="month" class="form-control" value="{{ $invoice->month }}" readonly>
            </div>
            <div class="form-group">
                <label for="year">Année :</label>
                <input type="number" name="year" id="year" class="form-control" value="{{ $invoice->year }}" readonly>
            </div>
            <div class="form-group">
                <label for="prix_unitaire_tvac">Prix Unitaire TVAC :</label>
                <input type="number" name="prix_unitaire_tvac" id="prix_unitaire_tvac" class="form-control" step="0.01" value="{{ $invoice->prix_unitaire_tvac }}" readonly>
            </div>
            <div class="form-group">
                <label for="status">Statut :</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="à payer" {{ $invoice->status == 'à payer' ? 'selected' : '' }}>À payer</option>
                    <option value="payé" {{ $invoice->status == 'payé' ? 'selected' : '' }}>Payé</option>
                </select>
            </div>
            <button href="{{ route('invoices.index') }}" class="btn btn-secondary">Retour à la Liste</button>
            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        </form>
    </div>
@endsection
