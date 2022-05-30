<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cita;
use App\Models\Horario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @class HorarioController
 * @author ANGIE CELESTE PAEZ MONTEJO
 */

class HorarioController extends Controller
{
    public function crearHorario(Request $request){
        $cont = 0;
        foreach ($request->dias as  $valor) {
            $hora_inicio = $request->hora_inicio[$cont];
            $hora_fin = $request->hora_fin[$cont];
            $horario = new Horario();
            $horario->dia = $valor;
            $horario->hora_inicio = $hora_inicio;
            $horario->hora_fin = $hora_fin;
            $horario->medico_id = 1;
            // $horario->save();
            $cont++;

            $fecha_inicio = Carbon::now()->format('Y-m-d');
            $fecha_fin = Carbon::parse("2022-12-31")->format('Y-m-d');
            while ($fecha_inicio < $fecha_fin) {
                $fecha= $this->extractFecha($valor, $fecha_inicio);
                $fecha_inicio = Carbon::parse($fecha_inicio);
                $fecha_inicio = $fecha_inicio->modify('+1 week');

                $hora_sumada = $hora_inicio;
                while ($hora_sumada < $hora_fin) {
                    $cita = new Cita();
                    $cita->hora_inicio = $hora_sumada;
                    $hora_sumada = Carbon::parse($hora_sumada)->modify('+30 minutes')->format('H:i');
                    $cita->hora_fin =$hora_sumada;
                    $cita->fecha = $fecha;
                    $cita->estado=0;
                    $cita->medico_id=$request->medico_id;
                    $cita->save();
                }
            }
        }

        return response()->json(["message" => "Horario creado con exito", "status"=>201, "data" => $request] , 201);
    }

    public function extractFecha($valor, $fecha_inicio){
        switch ($valor) {
            case 'Lunes':
                return date("Y-m-d", strtotime('Monday this week', strtotime($fecha_inicio)));
                break;
            case 'Martes':
                return date("Y-m-d", strtotime('Tuesday this week', strtotime($fecha_inicio)));
                break;
            case 'Miercoles':
                return date("Y-m-d", strtotime('Wednesday this week', strtotime($fecha_inicio)));
                break;
            case 'Jueves':
                return date("Y-m-d", strtotime('Thursday this week', strtotime($fecha_inicio)));
                break;
            case 'Viernes':
                return date("Y-m-d", strtotime('Friday this week', strtotime($fecha_inicio)));
                break;
            case 'Sabado':
                return date("Y-m-d", strtotime('Saturday this week', strtotime($fecha_inicio)));
                break;
            case 'Domingo':
                return date("Y-m-d", strtotime('Sunday this week', strtotime($fecha_inicio)));
                break;
        }
    }
}
