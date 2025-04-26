<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .ticket {
            width: 100%;
            max-width: 80mm;
            margin: auto;
        }

        .logo {
            max-width: 60mm;
            margin-bottom: 5px;
        }

        .business-info {
            margin-bottom: 10px;
        }

        .order-info,
        .footer {
            text-align: left;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 2px 0;
            text-align: left;
        }

        .total {
            font-weight: bold;
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
            <p>{{ $business->legal_name }}</p>
            <p>RUC: {{ $business->tax_id }}</p>
            <p>{{ $business->address }}, {{ $business->city }}, {{ $business->country }}</p>
            <p>Tel: {{ $business->phone }} | {{ $business->email }}</p>
        </div>

        <div class="order-info">
            <p><strong>Ticket N°:</strong> {{ $business->invoice_series }}-{{ $order->id }}</p>
            <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cliente:</strong> {{ Auth::user()->name }}</p>
        </div>

        <div class="line"></div>

        <table class="table">
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->quantity }}x {{ $item->name ?? 'Producto' }}</td>
                        <td>{{ config('app.currency_symbol') }}. {{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>

        <table class="table">
            <tr>
                <td>Envío:</td>
                <td>{{ config('app.currency_symbol') }} {{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td>Subtotal:</td>
                <td>
                    {{ config('app.currency_symbol') }}
                    {{ number_format($order->subtotal / (1 + $business->tax_percentage / 100), 2) }}
                </td>
            </tr>
            <tr>
                <td>IGV ({{ $business->tax_percentage }}%):</td>
                <td>
                    {{ config('app.currency_symbol') }}
                    {{ number_format($order->subtotal - $order->subtotal / (1 + $business->tax_percentage / 100), 2) }}
                </td>
            </tr>
            <tr class="total">
                <td><strong>Total:</strong></td>
                <td>
                    <strong>{{ config('app.currency_symbol') }}
                        {{ number_format($order->subtotal + $order->shipping_cost, 2) }}</strong>
                </td>
            </tr>
        </table>


        <div class="line"></div>

        <p>¡Gracias por su compra!</p>
        <p>Visítanos en {{ $business->website }}</p>
    </div>
</body>

</html>
