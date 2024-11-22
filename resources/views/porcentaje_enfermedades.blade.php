<!DOCTYPE html>
<html>


<head>
    <title>Porcentaje de Enfermedades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1,
        {
        text-align: center;
        /* Centrar el texto de los encabezados */
        color: #333;
        /* Color del texto de los encabezados */
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
    <h2>Porcentaje de Enfermedades:</h2>
    <p>Total de Pacientes: {{ $totalPacientes }}</p>



    <table>
        <thead>
            <tr>
                <th>Enfermedad</th>
                <th>Porcentaje</th>
                <th>Pacientes con Enfermedad</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($porcentajes as $porcentaje)
                <tr>
                    <td>{{ $porcentaje['nombre'] }}</td>
                    <td>{{ number_format($porcentaje['porcentaje'], 2) }}%</td>
                    <td>{{ $porcentaje['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>





    <h2>Gráfica de Distribución</h2><img src="{{ public_path('images/grafica_pastel.png') }}"
        alt="Gráfica de Porcentaje de Enfermedades" width="500" height="500">
</body>

</html>
