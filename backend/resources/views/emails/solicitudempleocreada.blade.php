<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Creación de Solicitud de Empleo</title>
    <style>
        /* Estilos CSS para dar formato al correo */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            color: #666;
            line-height: 1.6;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Confirmación de Solicitud de Empleo</h1>
        <p>Estimado/a   {{$distressCall}},</p>
        <p>La solicitud ha sido creada con exito</p>
        <p>Nuestro equipo de recursos humanos revisará cuidadosamente tu solicitud y aprobaremos el colocar la vacante
            en circulación
        </p>
        <p>Si tienes alguna pregunta o necesitas más información, no dudes en contactarnos.</p>
        <div class="footer">
            <p>Atentamente,</p>
            <p>Equipo de Recursos Humanos</p>
        </div>
    </div>
</body>

</html>