
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Gestion des Clients</h1>

        <!-- Affichage des messages de succès -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Colonne Gauche: Liste des clients -->
            <div class="col-md-6">
                <div class="border p-4 mb-4">
                    <h3 class="mb-4">Liste des Clients</h3>
                    <div class="clients-list">
                        @foreach($clients as $client)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $client->last_name }} {{ $client->first_name }}</h5>
                                    <p class="card-text"><strong>Adresse :</strong> {{ $client->address }}</p>
                                    <p class="card-text"><strong>Email :</strong> {{ $client->email }}</p>

                                    <!-- Boutons Modifier / Supprimer -->
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Éditer</a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        @can('delete', $client)
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</button>
                                        @endcan
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne Droite: Ajouter un nouveau client -->
            <div class="col-md-6">
                <div class="border p-4">
                    <h3 class="mb-4">Ajouter un Nouveau Client</h3>
                    <form action="{{ route('clients.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="last_name">Nom :</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">Prénom :</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Adresse :</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
