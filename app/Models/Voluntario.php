<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Voluntario extends Model
{
    use SoftDeletes;

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
                $voluntario->qr_token = self::makeQrToken();
            }
        });
    }

    public static function makeQrToken(): string
    {
        do {
            $token = (string) Str::uuid();
        } while (self::where('qr_token', $token)->exists());

        return $token;
    }

    public function ensureQrToken(): void
    {
        if ($this->qr_token) {
            return;
        }

        $this->forceFill([
            'qr_token' => self::makeQrToken(),
        ])->saveQuietly();
    }
}
