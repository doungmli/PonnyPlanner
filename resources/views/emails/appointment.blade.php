<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Rendez-vous Assigné</title>
</head>
<body>
<h1>Nouveau Rendez-vous Assigné</h1>
<p>Client : {{ $client_name }}</p>
<p>Date : {{ $appointment_date }}</p>
<p>Heure de début : {{ $start_time }}</p>
<p>Heure de fin : {{ $end_time }}</p>
<p>Nombre de personnes : {{ $number_of_people }}</p>
<p>Nombre de poneys assignés : {{ $assigned_pony_count }}</p>
<p>Noms des poneys :</p>
<ul>
    @foreach($ponies as $pony)
        <li>{{ $pony }}</li>
    @endforeach
</ul>
</body>
</html>
