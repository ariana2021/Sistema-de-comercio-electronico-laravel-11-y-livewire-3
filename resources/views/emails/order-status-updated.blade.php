<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de tu Pedido</title>
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
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
        }
        .status {
            font-weight: bold;
            color: #007bff;
        }
        .note {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
            margin-top: 15px;
            font-style: italic;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888888;
            padding: 15px;
            background-color: #f8f9fa;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            🚀 Actualización de Pedido
        </div>
        <div class="content">
            <p>Hola <strong>{{ $order->user->name }}</strong>,</p>
            <p>Tu pedido <strong>#{{ $order->id }}</strong> ha cambiado de estado.</p>
            <p><strong>Nuevo Estado:</strong> <span class="status">{{ $status }}</span></p>

            @if($note)
                <div class="note">
                    <p><strong>Nota del Administrador:</strong> {{ $note }}</p>
                </div>
            @endif

            <p>Puedes ver más detalles en tu cuenta.</p>
            <p style="text-align: center;">
                <a href="{{ url('/orders/'.$order->id) }}" class="button">Ver Pedido</a>
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Tu Tienda | Todos los derechos reservados
        </div>
    </div>
</body>
</html>
