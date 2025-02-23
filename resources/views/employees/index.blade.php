
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Gestion des Employés</h1>

        <!-- Affichage des messages de succès -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Colonne Gauche: Liste des employés -->
            <div class="col-md-6">
                <div class="border p-4 mb-4">
                    <h3 class="mb-4">Liste des Employés</h3>
                    <div class="employees-list">
                        @foreach($employees as $employee)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $employee->last_name }} {{ $employee->first_name }}</h5>
                                    <p class="card-text">
                                        <strong>Rôle :</strong> {{ $employee->role }}<br>
                                        <strong>Email :</strong> {{ $employee->email }}
                                    </p>

                                    <!-- Boutons Modifier / Supprimer -->
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Éditer</a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        @can('delete', $employee)
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</button>
                                        @endcan
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne Droite: Ajouter un nouvel employé -->
            <div class="col-md-6">
                <div class="border p-4">
                    <h3 class="mb-4">Ajouter un Nouvel Employé</h3>
                    <form action="{{ route('employees.store') }}" method="POST">
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
                            <label for="role">Rôle :</label>
                            <input type="text" name="role" class="form-control" required>
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
