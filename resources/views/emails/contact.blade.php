<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            color: #333;
            font-size: 16px;
        }
        .content p {
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .info-box {
            background: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
            margin: 10px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        📩 Nuevo Mensaje de Contacto
    </div>

    <div class="content">
        <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
        <p><strong>Correo Electrónico:</strong> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
        <p><strong>Asunto:</strong> {{ $data['subject'] }}</p>
        <div class="info-box">
            <p><strong>Mensaje:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Este mensaje fue enviado desde el formulario de contacto de tu sitio web.</p>
        <p><a href="{{ url('/') }}">Ir al sitio web</a></p>
    </div>
</div>

</body>
</html>
