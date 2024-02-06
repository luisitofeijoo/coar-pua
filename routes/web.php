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

Route::get('page/programacion', [AsistenciaController::class, 'page_programacion'])->name('page_programacion');
Route::post('programacion/actualizar-estado', [AsistenciaController::class, 'actualizarEstado'])->name('actualizar_estado');

Route::get('/reporte/aula', [\App\Http\Controllers\AsistenciaController::class, 'reporte_aula']);
Route::get('/reporte/postulantes', [\App\Http\Controllers\AsistenciaController::class, 'reporte_postulantes']);
Route::get('/reporte/postulantes/user', [\App\Http\Controllers\AsistenciaController::class, 'reporte_postulantes_user']);
