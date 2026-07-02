<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voluntario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'email',
        'profesion',
        'cargo',
        'ubicacion',
        'organismo',
        'foto',
        'estatus',
        'observaciones',
    ];
}