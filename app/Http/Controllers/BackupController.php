<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Dotenv\Dotenv;


class BackupController extends Controller
{

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }

    public function downloadBackup()
    {
        // Definir el nombre del archivo de respaldo
        $fileName = 'backup_' . now()->format('Y_m_d_His') . '.sql';

        // Ruta donde se guardará temporalmente el archivo de respaldo
        $backupPath = storage_path("app/{$fileName}");

        // Comando de mysqldump para crear el respaldo
        $process = new Process([
            'C:\xampp\mysql\bin\mysqldump.exe',
            '--user=' . env('DB_USERNAME'),
            '--password=' . env('DB_PASSWORD'),
            '--host=' . env('DB_HOST'),
            env('DB_DATABASE'),
            "--result-file=$backupPath",
        ]);


        // Ejecutar el comando
        $process->run();

        // Verificar si el comando fue exitoso
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Retornar el archivo como descarga
        return response()->download($backupPath)->deleteFileAfterSend(true);
    }
}
