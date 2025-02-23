
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border p-4 mb-4">
            <h1 class="text-center mb-4">Détails de la Facture</h1>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nom :</strong> {{ $invoice->group->client->last_name }}
                </div>
                <div class="col-md-6">
                    <strong>Prénom :</strong> {{ $invoice->group->client->first_name }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nombre de personnes :</strong> {{ $invoice->group->number_of_people }}
                </div>
                <div class="col-md-6">
                    <strong>Prix unitaire TVAC :</strong> {{ $invoice->prix_unitaire_tvac }} €
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date du rendez-vous :</strong> {{ \Carbon\Carbon::parse($invoice->group->appointments->first()->appointment_date)->translatedFormat('d F Y') }}
                </div>
                <div class="col-md-6">
                    <strong>Statut :</strong> {{ mb_strtoupper($invoice->status) }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Durée Totale :</strong>
                    {{ $invoice->group->appointments->reduce(function ($carry, $appointment) {
                        $start = Carbon\Carbon::createFromFormat('H:i:s', $appointment->start_time);
                        $end = Carbon\Carbon::createFromFormat('H:i:s', $appointment->end_time);

                        // Si l'heure de fin est plus petite que l'heure de début, cela traverse minuit
                        if ($end < $start) {
                            $end->addDay();
                        }

                        return $carry + $start->diffInHours($end);
                    }, 0) }} heures
                </div>
                <div class="col-md-6">
                    <strong>Total TVAC :</strong> {{ number_format($invoice->total_amount, 2) }} €
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Total TVA :</strong> {{ number_format(($invoice->total_amount * 0.21), 2) }} € <!-- Supposons un taux de TVA de 21% -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Référence :</strong> {{ $invoice->reference }}
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Retour</a>
                <div>
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary">Modifier</a>
                    <a href="{{ route('invoices.downloadPDF', $invoice->id) }}" class="btn btn-secondary">Télécharger</a>
                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        @can('delete', $invoice)
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">Supprimer</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



