@php
    $admin = \App\Models\User::where('id', '1')->first();
@endphp

<h1>Hola {{ $admin ? $admin->name : 'Administrador' }}</h1>

<p>Se ha realizado una nueva solicitud de reservación con los siguientes detalles:</p>

<ul>
    <li><strong>Usuario:</strong> {{ $reservation->user->name }}</li>
    <li><strong>Correo:</strong> {{ $reservation->user->email }}</li>
    <li><strong>Sala:</strong> {{ $reservation->room->name }}</li>
    <li><strong>Distribución:</strong> {{ $reservation->distribution->name }}</li>
    <li><strong>Fecha de inicio:</strong> {{ $reservation->start_date }}</li>
    <li><strong>Fecha de fin:</strong> {{ $reservation->end_date }}</li>
    <li><strong>Notas:</strong> {{ $reservation->notes ?? 'No hay notas' }}</li>
    <li><strong>Estado:</strong> {{ ucfirst($reservation->status) }}</li>
</ul>

<p>Para revisar la solicitud, por favor ingresa al panel de administración.</p>
