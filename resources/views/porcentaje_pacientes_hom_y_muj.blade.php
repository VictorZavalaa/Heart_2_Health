<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Porcentaje de Pacientes Hombres y Mujeres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            text-align: center;
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
    <div class="container">
        <img src="{{ public_path('images/chat.jpg') }}" alt="Logo" class="logo">
        <h1>Heart 2 Health</h1>
        <br />
        <br />
        <h2>Reporte de Pacientes</h2>
        <p>Total de pacientes: {{ $totalPacientes }}</p>
        <div>
            <table>
                <tr>
                    <th>Sexo</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
                <tr>
                    <td>Hombres</td>
                    <td>{{ $totalHombres }}</td>
                    <td>{{ number_format($porcentajeHombres, 2) }}%</td>
                </tr>
                <tr>
                    <td>Mujeres</td>
                    <td>{{ $totalMujeres }}</td>
                    <td>{{ number_format($porcentajeMujeres, 2) }}%</td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>{{ $totalOtros }}</td>
                    <td>{{ number_format($porcentajeOtros, 2) }}%</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
