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
