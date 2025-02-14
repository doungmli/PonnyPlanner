<!-- resources/views/clients/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Clients</h1>

        <!-- Liste des clients -->
        <div class="clients-list">
            @foreach($clients as $client)
                <div class="client">
                    <strong>{{ $client->last_name }} {{ $client->first_name }}</strong>: {{ $client->address }}
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Éditer</a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Ajouter un nouveau client -->
        <div class="new-client mt-5">
            <h3>Ajouter un nouveau client</h3>
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <label>Nom :</label>
                <input type="text" name="last_name" class="form-control" required>
                <label>Prénom :</label>
                <input type="text" name="first_name" class="form-control" required>
                <label>Adresse :</label>
                <input type="text" name="address" class="form-control" required>
                <button type="submit" class="btn btn-success mt-3">Ajouter</button>
            </form>
        </div>
    </div>
@endsection
