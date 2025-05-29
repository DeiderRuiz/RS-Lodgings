<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva</title>
</head>
<body>
    @if($reservation->user)
        <h1>Hola {{ $reservation->user->name }}</h1>
    @else
        <h1>Hola {{ $reservation->guest->name }}</h1>
    @endif

    <p>
        Gracias por elegir nuestro hotel para tu estancia. Tu reserva ha sido confirmada exitosamente. 
        A continuación, encontrarás los detalles de tu reserva. 
        Si necesitas hacer algún cambio, no dudes en contactarnos. ¡Te esperamos con gusto!
    </p>

    <p>Estado de la reserva: {{ $reservation->estado }}</p>
    <p>Número de habitación: N°{{ $reservation->rooms[0]->numero }}</p>
    <p>Tipo de habitación: {{ $reservation->rooms[0]->tipo }}</p>

    <br><br>
    <h3>Servicios adquiridos en la reserva</h3>
    @foreach($reservation->service as $service)
        <p>Servicio adquirido: {{ $service->nombre }}</p>
        <p>Tipo de servicio: {{ $service->tipo }}</p>
        <p>Exclusivo: {{ $service->para_habitacion ? 'Sí' : 'No' }}</p>
        <p>Valor del servicio: ${{ $service->precio }} COP</p>
        <br>
    @endforeach

    <br>
    <p>Fecha de inicio: {{ $reservation->fecha_inicio }}</p>
    <p>Fecha de fin: {{ $reservation->fecha_fin }}</p>
    <p>Noches a hospedarse: {{ $reservation->noches }}</p>
    <p>Número de huéspedes: {{ $reservation->huespedes }}</p>
    <p>Precio de la habitación (1 noche): ${{ $reservation->monto_habitacion }} COP</p>
    <p>Precio por huéspedes extra: ${{ $reservation->monto_extra_huesped }} COP</p>
    <p>Precio por noches extra: ${{ $reservation->monto_noche_extra }} COP</p>
    <p>Precio de todos los servicios: ${{ $reservation->monto_servicios }} COP</p>
    <p>Valor total de la reserva: ${{ $reservation->monto_habitacion + $reservation->monto_extra_huesped + $reservation->monto_noche_extra + $reservation->monto_servicios }} COP</p>
</body>
</html>