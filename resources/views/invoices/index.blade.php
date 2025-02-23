@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-4">Gestion des Factures</h1>

        <!-- Date actuelle et bouton de création de facture alignés -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Date actuelle : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h2>
            <a href="{{ route('invoices.create') }}" class="btn btn-success">Créer une Facture</a>
        </div>

        <div class="row">
            <!-- Colonne Gauche: Historique des factures -->
            <div class="col-md-6">
                <div class="border p-4 mb-4">
                    <h3 class="mb-4">Historique des Factures</h3>
                    @foreach($allInvoices as $month => $invoices)
                        <div class="mb-3">
                            <h5>
                                <a href="{{ route('invoices.index', ['month' => Carbon\Carbon::parse($month . '-01')->month, 'year' => Carbon\Carbon::parse($month . '-01')->year]) }}" class="text-decoration-none">
                                    {{ Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y') }}: {{ $invoices->sum('total_amount') }} €
                                </a>
                            </h5>
                            @if($selectedMonth == Carbon\Carbon::parse($month . '-01')->month && $selectedYear == Carbon\Carbon::parse($month . '-01')->year)
                                <div class="ml-3">
                                    @foreach($selectedMonthInvoices as $invoice)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $invoice->group->client->first_name }} {{ $invoice->group->client->last_name }} - {{ $invoice->total_amount }} € - Statut : {{ $invoice->status }}</span>
                                            <span>
                                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">Afficher</a>
                                                <a href="{{ route('invoices.downloadPDF', $invoice->id) }}" class="btn btn-secondary btn-sm">Télécharger</a>
                                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    @can('delete', $invoice)
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">Supprimer</button>
                                                    @endcan
                                                </form>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Colonne Droite: Factures du mois en cours -->
            <div class="col-md-6">
                <div class="border p-4">
                    <h3 class="mb-4">Factures du Mois en Cours</h3>
                    @if($currentMonthInvoices->isEmpty())
                        <p>Aucune facture pour le mois en cours.</p>
                    @else
                        @foreach($currentMonthInvoices as $invoice)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $invoice->group->client->first_name }} {{ $invoice->group->client->last_name }} - {{ $invoice->total_amount }} € - Statut : {{ $invoice->status }}</span>
                                <span>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">Afficher</a>
                                    <a href="{{ route('invoices.downloadPDF', $invoice->id) }}" class="btn btn-secondary btn-sm">Télécharger</a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        @can('delete', $invoice)
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">Supprimer</button>
                                        @endcan
                                    </form>
                                </span>
                            </div>
                        @endforeach
                        <div class="mt-3">
                            <h5>Total: {{ $currentMonthInvoices->sum('total_amount') }} €</h5>
                            <form action="{{ route('invoices.sendCurrentMonth') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mb-3">Envoyer les Factures du Mois en Cours</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
