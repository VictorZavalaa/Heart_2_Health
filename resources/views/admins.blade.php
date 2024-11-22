<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Administradores</title>
    <style>
        /* Puedes agregar estilos para el PDF aquí */
    </style>
</head>

<body>
    <h1>Reporte de Administradores</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <!-- Agrega más columnas según tus necesidades -->
            </tr>
        </thead>
        <tbody>
            @foreach ($administradores as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->NomAdmin }}</td>
                    <td>{{ $admin->email }}</td>
                    <!-- Agrega más datos si es necesario -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
