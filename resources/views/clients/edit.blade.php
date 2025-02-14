<!-- resources/views/clients/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Éditer le Client</h1>
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nom :</label>
            <input type="text" name="last_name" value="{{ $client->last_name }}" class="form-control" required>
            <label>Prénom :</label>
            <input type="text" name="first_name" value="{{ $client->first_name }}" class="form-control" required>
            <label>Adresse :</label>
            <input type="text" name="address" value="{{ $client->address }}" class="form-control" required>
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
