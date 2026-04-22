<?php

namespace Tests\Feature;

use App\Services\HorarioService;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HorarioRulesTest extends TestCase
{
    public function test_rechaza_duracion_distinta_a_dos_horas(): void
    {
        $service = new HorarioService();
        $this->expectException(ValidationException::class);
        $service->validateRules([
            'id_docente' => 1,
            'id_materia' => 1,
            'dia' => 'lunes',
            'hora_inicio' => '08:00',
            'hora_fin' => '09:00',
        ]);
    }
}
