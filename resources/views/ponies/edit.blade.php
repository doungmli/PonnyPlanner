
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Éditer le Poney</h1>
        <form action="{{ route('ponies.update', $pony->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nom du poney :</label>
            <input type="text" name="name" value="{{ $pony->name }}" class="form-control" required>
            <label>Heures de travail max :</label>
            <input type="number" name="max_working_hours" value="{{ $pony->max_working_hours }}" class="form-control" required>
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
