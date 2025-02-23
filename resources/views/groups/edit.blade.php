@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Éditer le Groupe</h1>
        <form action="{{ route('groups.update', $group->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nombre de personnes :</label>
            <input type="number" name="number_of_people" value="{{ $group->number_of_people }}" class="form-control" required>
            <label>Client :</label>
            <select name="client_id" class="form-control" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @if($client->id == $group->client_id) selected @endif>{{ $client->last_name }} {{ $client->first_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
