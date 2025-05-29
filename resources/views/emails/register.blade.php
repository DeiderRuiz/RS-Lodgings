<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de empleado</title>
</head>
<body>
    <h1>Hola {{ $employee->name }},</h1>

    <p>
        Te damos la bienvenida a RS Lodgings. Hemos creado tu cuenta en nuestro sistema para que puedas acceder a las herramientas y recursos que necesitarás en tu día a día.
    </p>
    <p>Para iniciar sesión, utiliza los siguientes datos:</p>

    <p>Correo electrónico: {{ $employee->email }}</p>
    <p>Contraseña temporal: Tu numero de identidad ({{ $employee->cedula }})</p>
    <p>
        Por razones de seguridad, te recomendamos cambiar tu contraseña en cuanto inicies sesión por primera vez. Si tienes algún problema con el acceso, no dudes en comunicarte con el área de soporte.
    </p>
    <p>¡Bienvenido/a a bordo! Estamos felices de contar contigo en nuestro equipo.</p>
    <p>Saludos,</p>
    <p>RS Lodgings</p>
</body>
</html>