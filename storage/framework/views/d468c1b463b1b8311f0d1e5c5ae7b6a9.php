<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva</title>
</head>
<body>
    <?php if($reservation->user): ?>
        <h1>Hola <?php echo e($reservation->user->name); ?></h1>
    <?php else: ?>
        <h1>Hola <?php echo e($reservation->guest->name); ?></h1>
    <?php endif; ?>

    <p>
        Gracias por elegir nuestro hotel para tu estancia. Tu reserva ha sido confirmada exitosamente. 
        A continuación, encontrarás los detalles de tu reserva. 
        Si necesitas hacer algún cambio, no dudes en contactarnos. ¡Te esperamos con gusto!
    </p>

    <p>Estado de la reserva: <?php echo e($reservation->estado); ?></p>
    <p>Número de habitación: N°<?php echo e($reservation->rooms[0]->numero); ?></p>
    <p>Tipo de habitación: <?php echo e($reservation->rooms[0]->tipo); ?></p>

    <br><br>
    <h3>Servicios adquiridos en la reserva</h3>
    <?php $__currentLoopData = $reservation->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p>Servicio adquirido: <?php echo e($service->nombre); ?></p>
        <p>Tipo de servicio: <?php echo e($service->tipo); ?></p>
        <p>Exclusivo: <?php echo e($service->para_habitacion ? 'Sí' : 'No'); ?></p>
        <p>Valor del servicio: $<?php echo e($service->precio); ?> COP</p>
        <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <br>
    <p>Fecha de inicio: <?php echo e($reservation->fecha_inicio); ?></p>
    <p>Fecha de fin: <?php echo e($reservation->fecha_fin); ?></p>
    <p>Noches a hospedarse: <?php echo e($reservation->noches); ?></p>
    <p>Número de huéspedes: <?php echo e($reservation->huespedes); ?></p>
    <p>Precio de la habitación (1 noche): $<?php echo e($reservation->monto_habitacion); ?> COP</p>
    <p>Precio por huéspedes extra: $<?php echo e($reservation->monto_extra_huesped); ?> COP</p>
    <p>Precio por noches extra: $<?php echo e($reservation->monto_noche_extra); ?> COP</p>
    <p>Precio de todos los servicios: $<?php echo e($reservation->monto_servicios); ?> COP</p>
    <p>Valor total de la reserva: $<?php echo e($reservation->monto_habitacion + $reservation->monto_extra_huesped + $reservation->monto_noche_extra + $reservation->monto_servicios); ?> COP</p>
</body>
</html><?php /**PATH C:\laragon\www\rslodgings\resources\views/emails/reservations.blade.php ENDPATH**/ ?>