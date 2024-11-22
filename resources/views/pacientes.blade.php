<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Pacientes</title>
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
    <h2>Reporte de Pacientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Fecha de nacimiento</th>
                <th>Género</th>

                <!-- Agrega más columnas según tus necesidades -->
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->id }}</td>
                    <td>{{ $paciente->NomPac }} {{ $paciente->ApePatPac }} {{ $paciente->ApeMatPac }}</td>
                    <td>{{ $paciente->FechNacPac->format('Y-m-d') }}</td>
                    <td>{{ $paciente->GenPac }}</td>


                    <!-- Agrega más datos si es necesario -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
