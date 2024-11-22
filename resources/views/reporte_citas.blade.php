<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Citas</title>
    <style>
        /* Estilo general de la página */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Estilo de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Estilo para las celdas de encabezado */
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        /* Estilo para las celdas de datos */
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        /* Color alternado para las filas */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover para filas */
        tr:hover {
            background-color: #e9f5e9;
        }

        img.logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 190px;
            height: auto;
            /* Ajusta el tamaño del logo según sea necesario */
        }

        img.center {
            display: block;
            margin: 0 auto;
            /* Centrar la imagen */
        }
    </style>
</head>

<body>
    <img src="{{ public_path('images/chat.jpg') }}" alt="Logo" class="logo">
    <h1>Heart 2 Health</h1>
    <br />
    <br />
    <h2>Reporte de Citas</h2>
    <p>Desde: {{ $startDate->format('Y-m-d') }} Hasta: {{ $endDate->format('Y-m-d') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
                <tr>
                    <td>{{ $cita->id }}</td>
                    <td>{{ $cita->MotivoCita }}</td>
                    <td>{{ $cita->FechaYHoraInicioCita->format('Y-m-d') }}</td>
                    <td>{{ $cita->FechaYHoraInicioCita->format('H:i:s') }}</td>
                    <td>{{ $cita->paciente->NomPac }} {{ $cita->paciente->ApePatPac }}</td>
                    <td>{{ $cita->doctor->NomDoc }} {{ $cita->doctor->ApePatDoc }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
