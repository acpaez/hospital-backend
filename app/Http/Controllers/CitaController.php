<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @class CitaController
 * @author ANGIE CELESTE PAEZ MONTEJO
 */

class CitaController extends Controller
{
    public function citasDisponibles(){
        return Cita::where('estado', 0)->with('medico.user:id,name')->paginate(20);
    }

    public function agendarCita(Request $request, $id){
        $cita = Cita::find($id);
        $cita->paciente_id = $request->paciente_id;
        $cita->estado = 1;
        $cita->save();

        return response()->json(["message" => "Cita agendada correctamente", "status"=>200, "data" => $cita] , 200);
    }

    public function misCitasAgendadas($paciente_id){
        return Cita::where('paciente_id', $paciente_id)->with('medico.user:id,name')->where('estado', 1)->paginate(20);
    }

    public function cancelarCita(Request $request, $id){
        $cita = Cita::find($id);
        $cita->paciente_id = null;
        $cita->estado = 0;
        $cita->save();

        return response()->json(["message" => "Cita cancelada correctamente", "status"=>200, "data" => $cita] , 200);
    }

    public function citasDisponiblesMedico($medico_id){
        return Cita::where('estado', 0)->where('medico_id', $medico_id)->paginate(20);
    }

    public function misCitasAgendadasMedico($medico_id){
        return Cita::where('medico_id', $medico_id)->with('paciente.user:id,name')->where('estado', 1)->paginate(20);
    }
}
