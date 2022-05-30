<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $table='medicos';

    protected $primaryKey='id';

    public $timestamps=true;


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function especialidad()
    {
        return $this->belongsTo('App\Models\Especialidad', 'especialidad_id');
    }

}
