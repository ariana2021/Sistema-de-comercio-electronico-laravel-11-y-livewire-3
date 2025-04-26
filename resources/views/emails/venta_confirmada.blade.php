<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de tu compra</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
            font-size: 32px;
            margin: 0;
        }
        .content {
            margin-bottom: 20px;
        }
        .content h2 {
            color: #333;
            font-size: 24px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
        .order-summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .order-summary th, .order-summary td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .order-summary th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
        }
        .footer p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gracias por tu compra, {{ $order->user->name }}!</h1>
        </div>
        <div class="content">
            <h2>Detalles de tu venta</h2>
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Descuento:</strong> ${{ number_format($order->discount, 2) }}</p>
            <p><strong>Costo de envío:</strong> ${{ number_format($order->shipping_cost, 2) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <div class="order-summary">
            <h2>Productos comprados:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>¡Gracias por comprar con nosotros!</p>
            <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        </div>
    </div>
</body>
</html>