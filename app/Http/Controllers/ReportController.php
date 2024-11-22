<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Administrador;
use App\Models\Paciente;
use App\Models\Sintoma;
use App\Models\Diagnostico_Sintoma;
use App\Models\Cita;


use Barryvdh\DomPDF\Facade\Pdf;



use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function generateAdminReport()
    {
        try {
            $administradores = Administrador::all();
            // Genera el PDF desde una vista
            $pdf = Pdf::loadView('admins', compact('administradores'));
            // Configura el nombre del archivo y lo envía como respuesta para descargar
            return $pdf->download('reporte_administradores.pdf');
        } catch (\Exception $e) {
            // Registrar el error en el log
            Log::error('Error al generar el reporte de administradores: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            // Devolver una respuesta de error
            return response()->json(['error' => 'Error al generar el reporte de administradores'], 500);
        }
    }

    public function generatePacientesReport()
    {
        $pacientes = Paciente::all();

        // Genera el PDF desde una vista
        $pdf = Pdf::loadView('pacientes', compact('pacientes'));

        // Configura el nombre del archivo y lo envía como respuesta para descargar
        return $pdf->download('reporte_pacientes.pdf');
    }

    public function generarPorcentajePacientesHomYMujReport()
    {
        $pacientes = Paciente::all();

        // Cuenta la cantidad de pacientes hombres y mujeres
        $totalPacientes = $pacientes->count();
        $totalHombres = $pacientes->where('GenPac', 'masculino')->count();
        $totalMujeres = $pacientes->where('GenPac', 'femenino')->count();
        $totalOtros = $pacientes->where('GenPac', '!=', 'masculino')->where('GenPac', '!=', 'femenino')->count();

        // Calcula el porcentaje de pacientes hombres y mujeres
        $porcentajeHombres = ($totalHombres / $totalPacientes) * 100;
        $porcentajeMujeres = ($totalMujeres / $totalPacientes) * 100;
        $porcentajeOtros = ($totalOtros / $totalPacientes) * 100;


        // Genera el PDF desde una vista
        $pdf = Pdf::loadView('porcentaje_pacientes_hom_y_muj', compact('totalPacientes', 'totalHombres', 'totalMujeres', 'totalOtros', 'porcentajeHombres', 'porcentajeMujeres', 'porcentajeOtros'));

        // Configura el nombre del archivo y lo envía como respuesta para descargar
        return $pdf->download('porcentaje_pacientes_hom_y_muj.pdf');
    }


    public function generarPorcPorEnfermedadesReport()
    {

        $totalPacientes = Paciente::count();
        $sintomas = Sintoma::withCount('diagnosticos')->get();

        $totalDiagnosticos = $sintomas->sum('diagnosticos_count');

        $porcentajes = $sintomas->map(function ($sintoma) use ($totalPacientes) {
            $porcentaje = $totalPacientes > 0 ? ($sintoma->diagnosticos_count / $totalPacientes) * 100 : 0;
            return [
                'nombre' => $sintoma->NomSintoma,
                'porcentaje' => $porcentaje,
                'total' => $sintoma->diagnosticos_count
            ];
        });

        $sinEnfermedad = $totalPacientes - $totalDiagnosticos;
        $porcentajeSinEnfermedad = $totalPacientes > 0 ? ($sinEnfermedad / $totalPacientes) * 100 : 0;

        $porcentajes->push([
            'nombre' => 'Sin Enfermedad',
            'porcentaje' => $porcentajeSinEnfermedad,
            'total' => $sinEnfermedad
        ]);

        // Convert the collection to an array before using array_column
        $porcentajesArray = $porcentajes->toArray();

        // Generar la imagen de la gráfica de pastel
        $graficaPath = $this->generarGraficaDePastel($porcentajesArray);

        // Genera el PDF desde una vista
        $pdf = Pdf::loadView('porcentaje_enfermedades', compact('totalPacientes', 'porcentajes', 'graficaPath'));

        // Configura el nombre del archivo y lo envía como respuesta para descargar
        return $pdf->download('porcentaje_enfermedades.pdf');
    }

    public function generarGraficaDePastel($porcentajes)
    {
        $width = 300; // Ancho más grande para agregar margen
        $height = 500; // Alto más grande para agregar margen
        $image = imagecreate($width, $height);

        // Colores
        $background = imagecolorallocate($image, 255, 255, 255); // Fondo blanco
        $colors = [
            imagecolorallocate($image, 255, 99, 132),
            imagecolorallocate($image, 54, 162, 235),
            imagecolorallocate($image, 255, 206, 86),
            imagecolorallocate($image, 75, 192, 192),
            imagecolorallocate($image, 153, 102, 255),
            imagecolorallocate($image, 255, 159, 64),
            imagecolorallocate($image, 201, 203, 207)
        ];

        $porcentajes = array_filter($porcentajes, function ($item) {
            return $item['porcentaje'] > 0;
        });

        $total = array_sum(array_column($porcentajes, 'porcentaje'));
        $startAngle = 0;
        $colorIndex = 0;
        $radius = ($width - 100) / 2; // Radio ajustado para dejar espacio para el margen

        $font = public_path('fonts/Arial.ttf');

        foreach ($porcentajes as $porcentaje) {
            $endAngle = $startAngle + ($porcentaje['porcentaje'] / $total) * 360;
            imagefilledarc($image, $width / 2, $height / 2, $width - 100, $height - 100, $startAngle, $endAngle, $colors[$colorIndex], IMG_ARC_PIE);

            // Calcular el ángulo medio para colocar la etiqueta fuera del borde de la gráfica
            $midAngle = deg2rad(($startAngle + $endAngle) / 2);
            $labelX = ($width / 2) + cos($midAngle) * $radius * 1.3; // Distancia ajustada para etiquetas
            $labelY = ($height / 2) + sin($midAngle) * $radius * 1.3;

            // Agregar línea de conexión
            imageline(
                $image,
                ($width / 2) + cos($midAngle) * $radius * 0.7,  // Punto inicial en el borde de la gráfica
                ($height / 2) + sin($midAngle) * $radius * 0.7, // Punto inicial en el borde de la gráfica
                $labelX, // Punto final en la etiqueta
                $labelY, // Punto final en la etiqueta
                imagecolorallocate($image, 0, 0, 0)
            );

            // Escribir el nombre de la enfermedad y el porcentaje fuera de la gráfica
            $text = $porcentaje['nombre'];
            imagettftext($image, 7, 0, $labelX, $labelY, imagecolorallocate($image, 0, 0, 0), $font, $text);

            $startAngle = $endAngle;
            $colorIndex = ($colorIndex + 1) % count($colors);
        }

        $filePath = public_path('images/grafica_pastel.png');
        imagepng($image, $filePath);
        imagedestroy($image);

        return $filePath;
    }






    public function reporteCitasPorRangoFecha(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Validar las fechas
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Convertir las fechas a formato DateTime para asegurar la comparación correcta
        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        // Obtener las citas en el rango de fechas
        $citas = Cita::with(['paciente', 'doctor'])
            ->whereBetween('FechaYHoraInicioCita', [$startDate, $endDate])
            ->get();

        // Generar el PDF desde una vista
        $pdf = Pdf::loadView('reporte_citas', compact('citas', 'startDate', 'endDate'));

        // Configurar el nombre del archivo y devolver el PDF como respuesta
        return $pdf->download('reporte_citas_' . $startDate->format('Y-m-d') . '_al_' . $endDate->format('Y-m-d') . '.pdf');
    }
}
