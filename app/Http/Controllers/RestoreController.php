<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RestoreController extends Controller
{

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }


    public function restoreBackup(Request $request)
    {

        // Verificar si se ha enviado un archivo y si tiene la extensión .sql
        if ($request->hasFile('file') && $request->file('file')->getClientOriginalExtension() === 'sql') {
            $file = $request->file('file');

            // Guardar el archivo en storage/app/public/sql_uploads
            $filePath = storage_path('app/' . $file->storeAs('sql_uploads', $file->getClientOriginalName()));

            // Obtener las credenciales de la base de datos
            $dbHost = env('DB_HOST');
            $dbPort = env('DB_PORT');
            $dbDatabase = env('DB_DATABASE');
            $dbUsername = env('DB_USERNAME');
            $dbPassword = env('DB_PASSWORD');

            // Crear el comando para restaurar la base de datos
            $command = "mysql -h$dbHost -P$dbPort -u$dbUsername" . ($dbPassword ? " -p$dbPassword" : "") . " $dbDatabase < \"$filePath\"";



            //Ejecutar el comando usando Symfony Process
            $process = Process::fromShellCommandline($command);


            $process->run();


            // Verificar si hubo un error durante la ejecución del proceso
            if (!$process->isSuccessful()) {
                Log::error('Error al restaurar la base de datos:', ['error' => $process->getErrorOutput()]);
                return response()->json(['message' => 'Error al restaurar la base de datos'], 500);
            }

            // Responder con éxito si la restauración fue correcta
            return response()->json(['message' => 'Base de datos restaurada exitosamente desde el archivo SQL'], 200);
        }

        // Retorna una respuesta de error si no es un archivo SQL
        return response()->json(['message' => 'Error: El archivo no es un archivo SQL'], 400);
    }
}
