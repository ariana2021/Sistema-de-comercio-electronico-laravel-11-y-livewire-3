<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Finanzas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #2196F3;
            color: white;
        }

        .ingreso {
            background-color: #C8E6C9;
        }

        .egreso {
            background-color: #FFCDD2;
        }

        .saldo-total {
            background-color: #28a745;
            /* Verde */
            color: white;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2 style="color: #2196F3; text-align: center;">Reporte de Finanzas</h2>
    <table>
        <thead>
            <tr>
                <th>Monto</th>
                <th>Tipo</th>
                <th>Cuenta</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIngresos = 0;
                $totalEgresos = 0;
                $accountTotals = [];
            @endphp
            @foreach ($finances as $finance)
                @php
                    $amount = $finance->amount;

                    if ($finance->type === 'Ingreso') {
                        $totalIngresos += $amount;
                        $accountTotals[$finance->account->name]['ingresos'] =
                            ($accountTotals[$finance->account->name]['ingresos'] ?? 0) + $amount;
                    } else {
                        $totalEgresos += $amount;
                        $accountTotals[$finance->account->name]['egresos'] =
                            ($accountTotals[$finance->account->name]['egresos'] ?? 0) + $amount;
                    }
                @endphp
                <tr class="{{ $finance->type === 'Ingreso' ? 'ingreso' : 'egreso' }}">
                    <td>${{ number_format($amount, 2) }}</td>
                    <td>{{ $finance->type }}</td>
                    <td>{{ $finance->account->name }}</td>
                    <td>{{ $finance->description }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total General</strong></td>
                <td><strong>Ingresos</strong></td>
                <td><strong>Egresos</strong></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td><strong>S/{{ number_format($totalIngresos, 2) }}</strong></td>
                <td><strong>S/{{ number_format($totalEgresos, 2) }}</strong></td>
            </tr>
            @foreach ($accountTotals as $accountName => $totals)
                <tr>
                    <td colspan="2"><strong>Total en {{ $accountName }}</strong></td>
                    <td><strong>S/{{ number_format($totals['ingresos'] ?? 0, 2) }}</strong></td>
                    <td><strong>S/{{ number_format($totals['egresos'] ?? 0, 2) }}</strong></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Saldo Total</strong></td>
                <td colspan="2" class="saldo-total">
                    <strong>S/{{ number_format($totalIngresos - $totalEgresos, 2) }}</strong>
                </td>
            </tr>
        </tfoot>

    </table>

</body>

</html>
