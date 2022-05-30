<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @class EspecialidadController
 * @author ANGIE CELESTE PAEZ MONTEJO
 */

class EspecialidadController extends Controller
{
    public function traerEspecialidades(){
        return Especialidad::all();
    }
}
