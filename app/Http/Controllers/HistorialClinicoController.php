<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class HistorialClinicoController extends Controller
{

    public function getHistorialClinico($id)
    {

        try {

            $citas = Cita::where('idPaciente', $id)
                ->where('EstadoCita', 'Atendida')
                ->with(['doctor:id,NomDoc', 'paciente:id,NomPac', 'recomendaciones:id,idCita,DesRec,FechRec', 'seguimientos:id,idCita,FechSeg,DetalleSeg,Glucosa,Ritmo_Cardiaco,Presion']) // Asegúrate de cargar las recomendaciones y seguimientos
                ->get()
                ->map(function ($cita) {
                    return [
                        'id' => $cita->id,
                        'motivo' => $cita->MotivoCita,
                        'start' => $cita->FechaYHoraInicioCita,
                        'end' => $cita->FechaYHoraFinCita,
                        'title' => $cita->MotivoCita,
                        'Doc' => $cita->doctor->NomDoc,
                        'Pac' => $cita->paciente->NomPac,
                        'Estado' => $cita->EstadoCita,
                        'Recomendaciones' => $cita->recomendaciones,
                        'Seguimientos' => $cita->seguimientos
                    ];
                });

            // Calcular el promedio de glucosa
            $totalGlucosa = 0;
            $totalSeguimientos = 0;
            foreach ($citas as $cita) {
                foreach ($cita['Seguimientos'] as $seguimiento) {
                    $totalGlucosa += $seguimiento['Glucosa'];
                    $totalSeguimientos++;
                }
            }

            $promedioGlucosa = $totalSeguimientos > 0 ? $totalGlucosa / $totalSeguimientos : 0;

            //Generar el pdf desde una vista
            $pdf = Pdf::loadView('historial_clinico', ['citas' => $citas, 'promedioGlucosa' => $promedioGlucosa]);

            //Configurar el nombre del archivo y lo envía como respuesta para descargar
            return $pdf->download('historial_clinico.pdf');
        } catch (\Exception $e) {

            //Registrar el error en el log
            Log::error('Error al generar el historial clínico: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            //Devolver una respuesta de error
            return response()->json(['error' => 'Error al generar el historial clínico'], 500);
        }
    }


    public function getHistorialClinicoPaciente(Request $request)
    {
        try {

            $citas = Cita::where('idPaciente', $request->user()->id)
                ->where('EstadoCita', 'Atendida')
                ->with(['doctor:id,NomDoc', 'paciente:id,NomPac', 'recomendaciones:id,idCita,DesRec,FechRec', 'seguimientos:id,idCita,FechSeg,DetalleSeg,Glucosa,Ritmo_Cardiaco,Presion']) // Asegúrate de cargar las recomendaciones y seguimientos
                ->get()
                ->map(function ($cita) {
                    return [
                        'id' => $cita->id,
                        'motivo' => $cita->MotivoCita,
                        'start' => $cita->FechaYHoraInicioCita,
                        'end' => $cita->FechaYHoraFinCita,
                        'title' => $cita->MotivoCita,
                        'Doc' => $cita->doctor->NomDoc,
                        'Pac' => $cita->paciente->NomPac,
                        'Estado' => $cita->EstadoCita,
                        'Recomendaciones' => $cita->recomendaciones,
                        'Seguimientos' => $cita->seguimientos
                    ];
                });


                // Calcular el promedio de glucosa
            $totalGlucosa = 0;
            $totalSeguimientos = 0;
            foreach ($citas as $cita) {
                foreach ($cita['Seguimientos'] as $seguimiento) {
                    $totalGlucosa += $seguimiento['Glucosa'];
                    $totalSeguimientos++;
                }
            }

            $promedioGlucosa = $totalSeguimientos > 0 ? $totalGlucosa / $totalSeguimientos : 0;

            //Generar el pdf desde una vista
            $pdf = Pdf::loadView('historial_clinico', ['citas' => $citas, 'promedioGlucosa' => $promedioGlucosa]);

            //Configurar el nombre del archivo y lo envía como respuesta para descargar
            return $pdf->download('historial_clinico.pdf');
        } catch (\Exception $e) {

            //Registrar el error en el log
            Log::error('Error al generar el historial clínico: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            //Devolver una respuesta de error
            return response()->json(['error' => 'Error al generar el historial clínico'], 500);
        }
    }
}