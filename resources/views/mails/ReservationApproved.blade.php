<!DOCTYPE html>
<html>

<head>
    <title>Solicitud de Reservación Aprobada</title>
</head>

<body>
    <h1>¡Tu reservación ha sido aprobada!</h1>
    <p>Estimado {{ $reservation->user->name }},</p>
    <p>Tu solicitud de reservación ha sido aprobada.</p>
    <p><strong>Sala: </strong> {{ $reservation->room->name }}</p>
    <p><strong>Fecha de inicio: </strong> {{ $reservation->start_date }}</p>
    <p><strong>Notas extras: </strong>{{ $reservation->notes }}</p>
    <p><strong>Respuesta: </strong>{{ $reservation->answer }}</p>
    <p><strong>Fecha de fin: </strong> {{ $reservation->end_date }}</p>
    <p><strong>Estado: </strong> {{ ucfirst($reservation->status) }}</p>
</body>

</html>
