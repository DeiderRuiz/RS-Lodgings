<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización de Reserva</title>
</head>
<body>
    @if($reserva->user)
        <h1>Hola {{ $reserva->user->name }}</h1>
    @else
        <h1>Hola {{ $reserva->guest->name }}</h1>
    @endif

    <p>
        Tu reserva ha sido actualizada con éxito. A continuación, encontrarás los detalles de los cambios realizados. 
        Si necesitas hacer más ajustes o tienes alguna consulta, no dudes en ponerte en contacto con nosotros. 
        ¡Esperamos verte pronto!
    </p>

    <p>Estado de la reserva: {{ $reserva->estado }}</p>
    <p>Número de habitación: N°{{ $reserva->rooms[0]->numero }}</p>
    <p>Tipo de habitación: {{ $reserva->rooms[0]->tipo }}</p>

    <br><br>
    <h3>Servicios adquiridos en la reserva</h3>
    @foreach($reserva->service as $service)
        <p>Servicio adquirido: {{ $service->nombre }}</p>
        <p>Tipo de servicio: {{ $service->tipo }}</p>
        <p>Exclusivo: {{ $service->para_habitacion ? 'Sí' : 'No' }}</p>
        <p>Valor del servicio: ${{ $service->precio }} COP</p>
        <br>
    @endforeach

    <br>
    <p>Fecha de inicio: {{ $reserva->fecha_inicio }}</p>
    <p>Fecha de fin: {{ $reserva->fecha_fin }}</p>
    <p>Noches a hospedarse: {{ $reserva->noches }}</p>
    <p>Número de huéspedes: {{ $reserva->huespedes }}</p>
    <p>Precio de la habitación (1 noche): ${{ $reserva->monto_habitacion }} COP</p>
    <p>Precio por huéspedes extra: ${{ $reserva->monto_extra_huesped }} COP</p>
    <p>Precio por noches extra: ${{ $reserva->monto_noche_extra }} COP</p>
    <p>Precio de todos los servicios: ${{ $reserva->monto_servicios }} COP</p>
    <p>Valor total de la reserva: ${{ $reserva->monto_habitacion + $reserva->monto_extra_huesped + $reserva->monto_noche_extra + $reserva->monto_servicios }} COP</p>
</body>
</html>