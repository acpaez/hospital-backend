<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @class MedicoController
 * @author ANGIE CELESTE PAEZ MONTEJO
 */

class MedicoController extends Controller
{
    public function traerMedicos(){
        return Medico::with('user', 'especialidad')->get();
    }

    public function crearMedico(Request $request){
        $user = new User();
        $user->email= $request->email;
        $user->name = $request->nombre;
        $user->password = bcrypt($request->password);
        $user->save();

        $medico = new Medico();
        $medico->user_id = $user->id;
        $medico->especialidad_id = $request->especialidad_id;
        $medico->save();

        return response()->json(["message" => "Medico creado exitosamente", "status"=>201, "data" => $medico] , 201);
    }
}
