<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionAsistencia;
use App\Models\Postulante;
use App\Models\Asistencia;
use App\Models\Programacion;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AsistenciaController extends Controller
{
    public function save($dni)
    {
        return DB::transaction(function () use ($dni) {

            // Buscar el postulante por DNI
            $postulante = Postulante::where('dni', $dni)
                ->first();

            if ($postulante) {

                // Verificar si el turno del postulante coincide con la configuración

                $programacion = Programacion::where('id', $postulante->programacion_id)
                    ->first();

                if ($programacion->estado === 1) {

                    //Bloqueamos la fila para evitar concurrencia y verifica si ya existe una asistencia para este postulante
                    $asistenciaExistente = Asistencia::where('postulante_id', $postulante->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$asistenciaExistente) {
                        // Si no existe, registra la asistencia
                        $asistencia = Asistencia::create([
                            'postulante_id' => $postulante->id,
                            'user_id' => Auth::id(),
                            'fecha_asistencia' => now(),
                        ]);

                        // Retornar los datos del postulante y la asistencia
                        return response()->json([
                            'mensaje' => 'DNI CORRECTO.',
                            'postulante' => $postulante,
                            'asistencia' => $asistencia,
                            'programacion' => $programacion,
                            'estado' => 'nuevo',
                        ]);
                    } else {
                        // Si ya existe una asistencia para este postulante, devolver los datos existentes
                        return response()->json([
                            'mensaje' => 'ERROR: POSTULANTE YA REGISTRO SU ASISTENCIA.',
                            'postulante' => $postulante,
                            'asistencia' => $asistenciaExistente,
                            'programacion' => $programacion,
                            'estado' => 'registrado',
                        ]);
                    }
                } else {
                    // El turno del postulante no coincide con la configuración
                    return response()->json([
                        'mensaje' => 'ERROR: NO ES EL TURNO DE REGISTRO DEL POSTULANTE.',
                        'postulante' => $postulante,
                        'programacion' => $programacion,
                        'estado' => 'turno_incorrecto',
                    ]);
                }
            } else {
                // El postulante no existe en la base de datos
                return response()->json(['mensaje' => 'Postulante no encontrado'], 404);
            }
        });

    }

    public function reporte_aula()
    {
        $programacion = Programacion::where('estado', 1)
            ->first();
        // Obtén el número de postulantes ingresados por aula (todos)
        $postulantesPorAula = Postulante::join('asistencias', 'postulantes.id', '=', 'asistencias.postulante_id')
            ->select('postulantes.aula', \DB::raw('count(*) as total_postulantes'))
            ->where('postulantes.programacion_id', $programacion->id)
            ->groupBy('postulantes.aula')
            ->get();

        return view('reporte.rpt_asistencia_aula', ['postulantes_aula' => $postulantesPorAula]);
    }

    public function reporte_postulantes()
    {
        $programacion = Programacion::where('estado', 1)
            ->first();

        $asistencias = Asistencia::with('postulante')
            ->whereHas('postulante', function ($query) use ($programacion) {
                $query->where('programacion_id', $programacion->id);
            })
            ->orderBy('fecha_asistencia', 'desc')->get();
        return view('reporte.rpt_asistencia_postulantes', compact('asistencias'));
    }

    public function reporte_postulantes_user()
    {
        $programacion = Programacion::where('estado', 1)
            ->first();

        $asistencias = Asistencia::with('postulante')
            ->whereHas('postulante', function ($query) use ($programacion) {
                $query->where('programacion_id', $programacion->id);
            })
            ->where('user_id', Auth::id())
            ->orderBy('fecha_asistencia', 'desc')->get();
        return view('reporte.rpt_asistencia_postulantes', compact('asistencias'));
    }

    public function page_programacion()
    {
        $programaciones = Programacion::all();
        return view('programacion', compact('programaciones'));
    }

    public function actualizarEstado(Request $request){
        $programacionId = $request->get('programacion');

        // Actualizar el estado en la base de datos
        $programacion = Programacion::find($programacionId);
        $programacion->estado = 1;
        $programacion->save();

        // Desactivar el resto de elementos
        Programacion::where('id', '!=', $programacionId)->update(['estado' => 0]);

        return redirect(route('page_programacion'));
    }
}
