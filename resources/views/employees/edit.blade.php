
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Éditer l'Employé</h1>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nom :</label>
            <input type="text" name="last_name" value="{{ $employee->last_name }}" class="form-control" required>
            <label>Prénom :</label>
            <input type="text" name="first_name" value="{{ $employee->first_name }}" class="form-control" required>
            <label>Rôle :</label>
            <input type="text" name="role" value="{{ $employee->role }}" class="form-control" required>
            <label>Email :</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
