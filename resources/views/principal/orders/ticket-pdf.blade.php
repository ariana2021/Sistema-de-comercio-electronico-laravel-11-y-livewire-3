<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: box-sizing;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            text-align: center;
            color: #333;
            padding: 10px;
        }

        .ticket {
            width: 100%;
            max-width: 80mm;
            margin: auto;
            background: #fff;
        }

        .logo {
            max-width: 50mm;
            margin: 5px auto;
        }

        .business-info p {
            margin: 2px 0;
            font-size: 11px;
        }

        .order-info p {
            margin: 3px 0;
            font-size: 11px;
        }

        .line {
            border-top: 1px solid #ccc;
            margin: 8px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .table td {
            padding: 4px 0;
            text-align: left;
            font-size: 11px;
        }

        .table td:last-child {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 12px;
            border-top: 2px solid #000;
            margin-top: 5px;
        }

        .footer p {
            font-size: 10px;
            margin: 2px 0;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="ticket">
        @if ($business->logo)
            <img src="{{ public_path('admin/images/logo-1.png') }}" class="logo">
        @else
            <h3>{{ $business->business_name }}</h3>
        @endif

        <div class="business-info">
            <p><strong>{{ $business->legal_name }}</strong></p>
            <p>RUC: {{ $business->tax_id }}</p>
            <p>{{ $business->address }}, {{ $business->city }}, {{ $business->country }}</p>
            <p>Tel: {{ $business->phone }} | {{ $business->email }}</p>
        </div>

        <div class="line"></div>

        <div class="order-info">
            <p><strong>Ticket N°:</strong> {{ $business->invoice_series }}-{{ $order->id }}</p>
            <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cliente:</strong> {{ Auth::user()->name }}</p>
        </div>

        @if (!empty($order->billing_details))
            <div class="order-info">
                <p><strong>Detalles de Facturación:</strong></p>
                <p>{{ $order->billing_details['first_name'] ?? '' }} {{ $order->billing_details['last_name'] ?? '' }}</p>
                <p>Email: {{ $order->billing_details['email'] ?? '' }}</p>
                <p>Teléfono: {{ $order->billing_details['phone'] ?? '' }}</p>
                <p>Dirección: {{ $order->billing_details['address'] ?? '' }}, {{ $order->billing_details['city'] ?? '' }} {{ $order->billing_details['zip_code'] ?? '' }}</p>
                @if (!empty($order->billing_details['order_notes']))
                    <p>Notas: {{ $order->billing_details['order_notes'] }}</p>
                @endif
            </div>
        @endif

        <div class="line"></div>

        <table class="table">
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->quantity }}x {{ $item->name ?? 'Producto' }}</td>
                        <td>{{ config('app.currency_symbol') }} {{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>

        <table class="table">
            <tr>
                <td>Lugar Envío:</td>
                <td>{{$order->shipping_place }}</td>
            </tr>
            <tr>
                <td>Costo Envío:</td>
                <td>{{ config('app.currency_symbol') }} {{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td>Subtotal:</td>
                <td>{{ config('app.currency_symbol') }} {{ number_format($order->subtotal / (1 + $business->tax_percentage / 100), 2) }}</td>
            </tr>
            <tr>
                <td>IGV ({{ $business->tax_percentage }}%):</td>
                <td>{{ config('app.currency_symbol') }} {{ number_format($order->subtotal - $order->subtotal / (1 + $business->tax_percentage / 100), 2) }}</td>
            </tr>
            <tr class="total">
                <td><strong>Total:</strong></td>
                <td><strong>{{ config('app.currency_symbol') }} {{ number_format($order->subtotal + $order->shipping_cost, 2) }}</strong></td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="footer">
            <p>¡Gracias por su compra!</p>
            <p>Visítanos en {{ $business->website }}</p>
        </div>
    </div>
</body>

</html>