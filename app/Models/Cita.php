<?php

namespace App\Models;

use App\Models\Cita;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;

    protected $table='citas';

    protected $primaryKey='id';

    public $timestamps=true;

    public function medico(){
        return $this->belongsTo('App\Models\Medico', 'medico_id');
    }

    public function paciente(){
        return $this->belongsTo('App\Models\Paciente', 'paciente_id');
    }
}
