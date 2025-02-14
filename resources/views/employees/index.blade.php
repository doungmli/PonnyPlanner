<!-- resources/views/employees/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Employés</h1>

        <!-- Liste des employés -->
        <div class="employees-list">
            @foreach($employees as $employee)
                <div class="employee">
                    <strong>{{ $employee->last_name }} {{ $employee->first_name }}</strong>: {{ $employee->role }} - {{ $employee->email }}
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Éditer</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Ajouter un nouvel employé -->
        <div class="new-employee mt-5">
            <h3>Ajouter un nouvel employé</h3>
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
                <label>Nom :</label>
                <input type="text" name="last_name" class="form-control" required>
                <label>Prénom :</label>
                <input type="text" name="first_name" class="form-control" required>
                <label>Rôle :</label>
                <input type="text" name="role" class="form-control" required>
                <label>Email :</label>
                <input type="email" name="email" class="form-control" required>
                <button type="submit" class="btn btn-success mt-3">Ajouter</button>
            </form>
        </div>
    </div>
@endsection
