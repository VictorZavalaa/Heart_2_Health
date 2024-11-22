<!DOCTYPE html>
<html>

<head>
    <title>Historial Clínico</title>
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
            width: 180px;
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

    @if ($citas->isNotEmpty())
        <h1>Historial clínico: {{ $citas->first()['Pac'] }}</h1>
    @else
        <h1>Historial clínico: Sin citas para este paciente</h1>
    @endif

    @foreach ($citas as $cita)
        <hr>

        <div class="cita">
            <p><strong>Cita:</strong> {{ $cita['start'] }}</p>
            <p><strong>Motivo:</strong> {{ $cita['motivo'] }}</p>
            <p><strong>Atendida por:</strong> {{ $cita['Doc'] }}</p>

            <br>

            <p><strong>Seguimiento:</strong></p>
            @if ($cita['Seguimientos']->isNotEmpty())
                @foreach ($cita['Seguimientos'] as $seguimiento)
                    <p><strong>Fecha:</strong>{{ $seguimiento['FechSeg'] }}</p>
                    <p><strong>Detalle:</strong>{{ $seguimiento['DetalleSeg'] }}</p>
                    <p><strong>Glucosa:</strong>{{ $seguimiento['Glucosa'] }}</p>
                    <p><strong>Ritmo Cardiaco:</strong>{{ $seguimiento['Ritmo_Cardiaco'] }}</p>
                    <p><strong>Presion:</strong>{{ $seguimiento['Presion'] }}</p>
                @endforeach
            @else
                <p>Sin seguimientos</p>
            @endif

            <br>

            <p><strong>Recomendaciones del doctor:</strong></p>
            @if ($cita['Recomendaciones']->isNotEmpty())
                @foreach ($cita['Recomendaciones'] as $recomendacion)
                    <p>* {{ $recomendacion['DesRec'] }}</p>
                @endforeach
            @else
                <p>Sin recomendaciones</p>
            @endif
        </div>
    @endforeach
    <br />
    <br />
    <p><strong>Promedio de Glucosa:</strong> {{ $promedioGlucosa }}</p>
</body>

</html>