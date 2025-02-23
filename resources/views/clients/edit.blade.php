

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border p-4 mb-4">
            <h1 class="text-center mb-4">Éditer le Client</h1>

            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Nom :</label>
                        <input type="text" name="last_name" value="{{ $client->last_name }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Prénom :</label>
                        <input type="text" name="first_name" value="{{ $client->first_name }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Adresse :</label>
                        <input type="text" name="address" value="{{ $client->address }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Email :</label>
                        <input type="email" name="address" value="{{ $client->email }}" class="form-control" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour à la Liste</a>
                    <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection

