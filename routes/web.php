<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::post('/custom-login', [AuthController::class, 'login'])->name('custom-login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/api/asistencia/guardar/{dni}', [AsistenciaController::class, 'save']);
Route::post('/api/asistencia/eliminar/{id}', [AsistenciaController::class, 'eliminar']);

Route::get('page/programacion', [AsistenciaController::class, 'page_programacion'])->name('page_programacion');
Route::post('programacion/actualizar-estado', [AsistenciaController::class, 'actualizarEstado'])->name('actualizar_estado');

Route::get('/reporte/aula', [\App\Http\Controllers\AsistenciaController::class, 'reporte_aula']);
Route::get('/reporte/postulantes', [\App\Http\Controllers\AsistenciaController::class, 'reporte_postulantes']);
Route::get('/reporte/postulantes/user', [\App\Http\Controllers\AsistenciaController::class, 'reporte_postulantes_user']);
Route::get('/reporte/asistencia/resumen', [AsistenciaController::class, 'resumen_asistencia']);


Route::get('postulantes', function () {
    $postulantes = \App\Models\Postulante::join('programacions', 'programacion_id', 'programacions.id')->orderBy('postulantes.id', 'DESC')->get();

    echo '<table style="font-size:9px;width:100%">';
    foreach ($postulantes as $index => $postulante) {
        echo '<tr><td  style="border-top:1px solid black;">'.++$index.'</td><td  style="border-top:1px solid black;"><strong>'.$postulante->dni.'</strong></td>';
        echo '<td  style="border-top:1px solid black;">'.$postulante->apellidos.'</td>';
        echo '<td  style="border-top:1px solid black;">'.$postulante->nombres.'</td>';
        echo '<td  style="border-top:1px solid black;">'.$postulante->aula.'</td>';
        echo '<td  style="border-top:1px solid black;">'.$postulante->pabellon.'</td>';
        echo '<td  style="border-top:1px solid black;">'.$postulante->sede.'</td></tr>';
    }
    echo '</table>';
});
