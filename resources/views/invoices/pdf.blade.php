<!-- resources/views/invoices/pdf.blade.php -->
{{--<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
<h1>Facture</h1>
<p>Mois : {{ $invoice->month }} {{ $invoice->year }}</p>
<p>Total : {{ $invoice->total_amount }} €</p>
<p>Groupe : {{ $invoice->group->id }}</p>

<h3>Détails des Rendez-Vous</h3>
<table>
    <thead>
    <tr>
        <th>Client</th>
        <th>Date</th>
        <th>Heure</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->appointments as $appointment)
        <tr>
            <td>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>--}}
<!-- resources/views/invoices/pdf.blade.php -->
{{--
<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
<h1>Facture</h1>
<p>Mois : {{ $invoice->month }} {{ $invoice->year }}</p>
<p>Total : {{ $invoice->total_amount }} €</p>
<p>Groupe : {{ $invoice->group->id }}</p>

<h3>Détails des Rendez-Vous</h3>
<table>
    <thead>
    <tr>
        <th>Client</th>
        <th>Date</th>
        <th>Heure</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->appointments as $appointment)
        <tr>
            <td>{{ $appointment->group->client->last_name }} {{ $appointment->group->client->first_name }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
--}}

{{--    <!DOCTYPE html> dernier update
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
        }
        .header h1 {
            margin: 0;
        }
        .details {
            width: 100%;
            margin-bottom: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            margin-top: 30px;
        }
        .total h3 {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Facture N° {{ $invoice->id }}</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="details">
        <table>
            <tr>
                <th>Description</th>
                <th>Prix Unitaire HTVA</th>
                <th>Unité</th>
                <th>Nombre de personnes</th>
                <th>Montant Total HTVA</th>
                <th>Montant Total TVAC</th>
            </tr>
            <tr>
                <td>Séance hypnothérapie</td>
                <td>{{ number_format($prixUnitaireHTVA, 2) }} €</td>
                <td>
                    {{ \Carbon\Carbon::parse($invoice->group->appointments->first()->start_time)
                        ->diffInHours(\Carbon\Carbon::parse($invoice->group->appointments->first()->end_time)) }} heures
                </td>
                <td>{{ $quantite }}</td>
                <td>{{ number_format($totalHTVA, 2) }} €</td>
                <td>{{ number_format($totalTVAC, 2) }} €</td>
            </tr>
        </table>
    </div>
    <div class="total">
        <h3>Total HTVA : {{ number_format($totalHTVA, 2) }} €</h3>
    </div>
    <div class="total">
        <h3>Total TVAC : {{ number_format($totalTVAC, 2) }} €</h3>
    </div>
</div>
</body>
</html>--}}
{{--
    <!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
        }
        .header h1 {
            margin: 0;
        }
        .client-info {
            margin-bottom: 20px;
        }
        .details {
            width: 100%;
            margin-bottom: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .status {
            font-size: 24px;
            font-weight: bold;
            text-align: left;
            margin-top: 30px;
        }
        .total {
            text-align: right;
            margin-top: 30px;
        }
        .total h3 {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Facture N° {{ $invoice->id }}</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="client-info">
        <p><strong>Client :</strong> {{ $invoice->group->client->first_name }} {{ $invoice->group->client->last_name }}</p>
        <p><strong>Email :</strong> {{ $invoice->group->client->email }}</p>
        <p><strong>Adresse :</strong> {{ $invoice->group->client->address }}</p>
    </div>
    <div class="details">
        <table>
            <tr>
                <th>Description</th>
                <th>Prix Unitaire HTVA</th>
                <th>Unité</th>
                <th>Nombre de personnes</th>
                <th>Montant Total HTVA</th>
                <th>Montant Total TVAC</th>
            </tr>
            <tr>
                <td>Séance hypnothérapie</td>
                <td>{{ number_format($prixUnitaireHTVA, 2) }} €</td>
                <td>
                    {{ \Carbon\Carbon::parse($invoice->group->appointments->first()->start_time)
                        ->diffInHours(\Carbon\Carbon::parse($invoice->group->appointments->first()->end_time)) }} heures
                </td>
                <td>{{ $quantite }}</td>
                <td>{{ number_format($totalHTVA, 2) }} €</td>
                <td>{{ number_format($totalTVAC, 2) }} €</td>
            </tr>
        </table>
    </div>
    <div class="status">
        Statut : {{ strtoupper($invoice->status) }}
    </div>
    <div class="total">
        <h3>Total HTVA : {{ number_format($totalHTVA, 2) }} €</h3>
    </div>
    <div class="total">
        <h3>Total TVAC : {{ number_format($totalTVAC, 2) }} €</h3>
    </div>
    <div class="reference">
        <h3>Référence : {{ $invoice->reference }}</h3>
    </div>
</div>
</body>
</html>--}}

    <!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
        }
        .header h1 {
            margin: 0;
        }
        .client-info {
            margin-bottom: 20px;
        }
        .details {
            width: 100%;
            margin-bottom: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .status {
            font-size: 24px;
            font-weight: bold;
            text-align: left;
            margin-top: 30px;
        }
        .total {
            text-align: right;
            margin-top: 30px;
        }
        .total h3 {
            margin: 0;
        }
        .reference {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Facture N° {{ $invoice->id }}</h1>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="client-info">
        <p><strong>Client :</strong> {{ $invoice->group->client->first_name }} {{ $invoice->group->client->last_name }}</p>
        <p><strong>Email :</strong> {{ $invoice->group->client->email }}</p>
        <p><strong>Adresse :</strong> {{ $invoice->group->client->address }}</p>
    </div>
    <div class="details">
        <table>
            <tr>
                <th>Description</th>
                <th>Prix Unitaire TVAC</th>
                <th>Durée Totale</th>
                <th>Nombre de personnes</th>
                <th>Montant Total HTVA</th>
                <th>Montant Total TVAC</th>
            </tr>
            <tr>
                <td>Séance hypnothérapie</td>
                <td>{{ number_format($prixUnitaireTTC, 2) }} €</td>
                <td>{{ $dureeTotale }} heures</td>
                <td>{{ $quantite }}</td>
                <td>{{ number_format($totalHTVA, 2) }} €</td>
                <td>{{ number_format($totalTVAC, 2) }} €</td>
            </tr>
        </table>
    </div>
    <div class="status">
        Statut : {{ mb_strtoupper($invoice->status) }}
    </div>
    <div class="total">
        <h3>Total HTVA : {{ number_format($totalHTVA, 2) }} €</h3>
    </div>
    <div class="total">
        <h3>Total TVAC : {{ number_format($totalTVAC, 2) }} €</h3>
    </div>
    <div class="reference">
        <h3>Référence : {{ $invoice->reference }}</h3>
    </div>
</div>
</body>
</html>
