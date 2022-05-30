<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table='pacientes';

    protected $primaryKey='id';

    public $timestamps=true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
