<?php

namespace Tests\Feature;

use App\Models\Voluntario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoluntarioQrTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_volunteer_public_qr_profile_is_visible(): void
    {
        $voluntario = Voluntario::create([
            'nombre' => 'Zenen',
            'apellido' => 'Peraza',
            'cedula' => '14695963',
            'profesion' => 'Informatico',
            'cargo' => 'Analista',
            'estatus' => 'Activo',
        ]);

        $response = $this->get(route('voluntarios.qr', $voluntario->qr_token));

        $response->assertOk();
        $response->assertSee('Zenen');
        $response->assertSee('14695963');
    }

    public function test_inactive_volunteer_public_qr_profile_is_not_visible(): void
    {
        $voluntario = Voluntario::create([
            'nombre' => 'Luis',
            'apellido' => 'Hernandez',
            'cedula' => '55667788',
            'estatus' => 'Inactivo',
        ]);

        $response = $this->get(route('voluntarios.qr', $voluntario->qr_token));

        $response->assertNotFound();
    }
}
