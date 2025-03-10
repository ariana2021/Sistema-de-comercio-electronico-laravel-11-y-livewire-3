<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Miembros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; margin: auto; }
        .title { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1976D2; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Reporte de Miembros</div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Estado Civil</th>
                    <th>Ocupación</th>
                    <th>Cargo</th>
                    <th>Iglesia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td>{{ $member->dni }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->marital_status }}</td>
                        <td>{{ $member->occupation->name }}</td>
                        <td>{{ $member->position->name }}</td>
                        <td>{{ $member->church->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
