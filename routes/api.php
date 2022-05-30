<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('logout', 'App\Http\Controllers\AuthController@logout');

Route::group(['middleware' => ['jwt.verify']], function() {


    Route::group(['prefix' => 'especialidad'], function() {
        Route::get('traer', 'App\Http\Controllers\EspecialidadController@traerEspecialidades');
    });

    Route::group(['prefix' => 'horario'], function() {
        Route::post('create', 'App\Http\Controllers\HorarioController@crearHorario');
    });

    Route::group(['prefix' => 'medico'], function() {
        Route::get('traer', 'App\Http\Controllers\MedicoController@traerMedicos');
        Route::post('crear', 'App\Http\Controllers\MedicoController@crearMedico');
    });

    Route::group(['prefix' => 'citas'], function() {
        Route::get('traer-disponibles', 'App\Http\Controllers\CitaController@citasDisponibles');
        Route::get('mis-citas/{paciente_id}', 'App\Http\Controllers\CitaController@misCitasAgendadas');
        Route::get('traer-disponibles-medico/{medico_id}', 'App\Http\Controllers\CitaController@citasDisponiblesMedico');
        Route::get('mis-citas-medico/{medico_id}', 'App\Http\Controllers\CitaController@misCitasAgendadasMedico');
        Route::put('agendar/{paciente_id}', 'App\Http\Controllers\CitaController@agendarCita');
        Route::put('cancelar/{paciente_id}', 'App\Http\Controllers\CitaController@cancelarCita');
    });
});
