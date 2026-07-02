<?php

namespace Database\Seeders;

use App\Models\Voluntario;
use Illuminate\Database\Seeder;

class VoluntarioSeeder extends Seeder
{
    public function run(): void
    {
        $voluntarios = [
            [
                'nombre' => 'Maria Alejandra',
                'apellido' => 'Gonzalez',
                'cedula' => '12345678',
                'telefono' => '0414-1234567',
                'email' => 'maria.gonzalez@example.com',
                'profesion' => 'Enfermera',
                'cargo' => 'Coordinadora de Salud',
                'ubicacion' => 'Caracas',
                'organismo' => 'ASONACOP',
                'estatus' => 'Activo',
                'observaciones' => 'Voluntaria de prueba para consulta publica.',
            ],
            [
                'nombre' => 'Jose Antonio',
                'apellido' => 'Perez',
                'cedula' => '87654321',
                'telefono' => '0424-7654321',
                'email' => 'jose.perez@example.com',
                'profesion' => 'Abogado',
                'cargo' => 'Asesor Legal',
                'ubicacion' => 'Miranda',
                'organismo' => 'ASONACOP',
                'estatus' => 'Activo',
                'observaciones' => 'Registro de prueba activo.',
            ],
            [
                'nombre' => 'Carolina',
                'apellido' => 'Rodriguez',
                'cedula' => '11223344',
                'telefono' => '0412-3344556',
                'email' => 'carolina.rodriguez@example.com',
                'profesion' => 'Docente',
                'cargo' => 'Facilitadora',
                'ubicacion' => 'La Guaira',
                'organismo' => 'ASONACOP',
                'estatus' => 'Activo',
                'observaciones' => 'Registro para probar datos con profesion y cargo.',
            ],
            [
                'nombre' => 'Luis Miguel',
                'apellido' => 'Hernandez',
                'cedula' => '55667788',
                'telefono' => '0416-5566778',
                'email' => 'luis.hernandez@example.com',
                'profesion' => 'Ingeniero',
                'cargo' => 'Soporte Operativo',
                'ubicacion' => 'Aragua',
                'organismo' => 'ASONACOP',
                'estatus' => 'Inactivo',
                'observaciones' => 'Este registro no debe aparecer en la consulta publica.',
            ],
        ];

        foreach ($voluntarios as $voluntario) {
            Voluntario::updateOrCreate(
                ['cedula' => $voluntario['cedula']],
                $voluntario
            );
        }
    }
}
