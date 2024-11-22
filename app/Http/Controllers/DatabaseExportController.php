<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseExportController extends Controller
{
    public function exportCSV()
    {
        //nombre del archivo
        $filename = "database_backup_" . now()->format('Y-m-d_H-i-s') . ".csv";

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            $data = DB::table('administrador')->get();

            //Encabezados
            fputcsv($handle, [
                'idAdmin',
                'NomAdmin',
                'ApePatAdmin',
                'ApeMatAdmin',
                'FechaNacAdmin',
                'email',
                'password',
                'created_at',
                'updated_at'
            ]);

            //Agregamos los registros
            foreach ($data as $row) {
                fputcsv($handle, (array) $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
