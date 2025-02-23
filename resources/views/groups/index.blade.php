@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Groupes</h1>

        <!-- Liste des groups -->
        <div class="groups-list">
            @foreach($groups as $group)
                <div class="group">
                    <strong>Groupe {{ $group->id }}</strong>: {{ $group->number_of_people }} personnes (Client : {{ $group->client->last_name }} {{ $group->client->first_name }})
                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-warning">Éditer</a>
                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Ajouter un nouveau groupe -->
        <div class="new-group mt-5">
            <h3>Ajouter un nouveau groupe</h3>
            <form action="{{ route('groups.store') }}" method="POST">
                @csrf
                <label>Nombre de personnes :</label>
                <input type="number" name="number_of_people" class="form-control" required>
                <label>Client :</label>
                <select name="client_id" class="form-control" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->last_name }} {{ $client->first_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success mt-3">Ajouter</button>
            </form>
        </div>
    </div>
@endsection
