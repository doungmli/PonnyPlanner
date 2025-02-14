<!-- resources/views/ponies/index.blade.php -->
<!-- resources/views/ponies/index.blade.php -->
{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>Gestion des poneys</h1>--}}

{{--        <!-- Liste des poneys -->--}}
{{--        <div class="ponies-list">--}}
{{--            @foreach($ponies as $pony)--}}
{{--                <div class="pony">--}}
{{--                    <strong>{{ $pony->name }}</strong>: {{ $pony->working_hours }}h sur {{ $pony->max_working_hours }}h--}}
{{--                    <a href="{{ route('ponies.edit', $pony->id) }}" class="btn btn-warning">Éditer</a>--}}
{{--                    <form action="{{ route('ponies.destroy', $pony->id) }}" method="POST" style="display:inline-block;">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger">Supprimer</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}

{{--        <!-- Ajouter un nouveau poney -->--}}
{{--        <div class="new-pony mt-5">--}}
{{--            <h3>Ajouter un nouveau poney</h3>--}}
{{--            <form action="{{ route('ponies.store') }}" method="POST">--}}
{{--                @csrf--}}
{{--                <label>Nom du poney :</label>--}}
{{--                <input type="text" name="name" class="form-control" required>--}}
{{--                <label>Heures de travail max :</label>--}}
{{--                <input type="number" name="max_working_hours" class="form-control" required>--}}
{{--                <button type="submit" class="btn btn-success mt-3">Ajouter</button>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Gestion des Poneys</h1>

        <div class="row">
            <!-- Colonne Gauche: Liste des poneys -->
            <div class="col-md-6">
                <div class="border p-4 mb-4">
                    <h3 class="mb-4">Liste des Poneys</h3>
                    <div class="ponies-list">
                        @foreach($ponies as $pony)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pony->name }}</h5>
                                    <p class="card-text">{{ $pony->working_hours }}h sur {{ $pony->max_working_hours }}h</p>
                                    <a href="{{ route('ponies.edit', $pony->id) }}" class="btn btn-warning">Éditer</a>
                                    <form action="{{ route('ponies.destroy', $pony->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne Droite: Ajouter un nouveau poney -->
            <div class="col-md-6">
                <div class="border p-4">
                    <h3 class="mb-4">Ajouter un Nouveau Poney</h3>
                    <form action="{{ route('ponies.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nom du Poney :</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="max_working_hours">Heures de Travail Max :</label>
                            <input type="number" name="max_working_hours" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@foreach($ponies as $pony)
    <div class="pony">
        <strong>{{ $pony->name }}</strong>: {{ $pony->working_hours }}h sur {{ $pony->max_working_hours }}h
        <br>
        <pre>{{ json_encode($pony->appointments, JSON_PRETTY_PRINT) }}</pre>
    </div>
@endforeach--}}
