<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Voluntario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'qr_token',
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

    protected static function booted(): void
    {
        static::creating(function (Voluntario $voluntario): void {
            if (! $voluntario->qr_token) {
                $voluntario->qr_token = (string) Str::uuid();
            }
        });
    }
}
