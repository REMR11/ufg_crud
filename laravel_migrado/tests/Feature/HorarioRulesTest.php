<?php

namespace Tests\Feature;

use App\Models\Docente;
use App\Models\Horario;
use App\Models\Materia;
use App\Services\HorarioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HorarioRulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_rechaza_duracion_distinta_a_dos_horas(): void
    {
        $docente = Docente::create([
            'nombre' => 'Ana',
            'apellido' => 'Lopez',
            'email' => 'ana@example.com',
        ]);

        $materia = Materia::create([
            'nombre_materia' => 'Matematica',
        ]);

        $service = new HorarioService();
        $this->expectException(ValidationException::class);
        $service->validateRules([
            'id_docente' => $docente->id,
            'id_materia' => $materia->id_materia,
            'dia' => 'lunes',
            'hora_inicio' => '08:00',
            'hora_fin' => '09:00',
        ]);
    }

    public function test_rechaza_solapamiento_para_docente_en_mismo_dia(): void
    {
        $docente = Docente::create([
            'nombre' => 'Luis',
            'apellido' => 'Perez',
            'email' => 'luis@example.com',
        ]);

        $materia1 = Materia::create(['nombre_materia' => 'Fisica']);
        $materia2 = Materia::create(['nombre_materia' => 'Quimica']);

        Horario::create([
            'id_docente' => $docente->id,
            'id_materia' => $materia1->id_materia,
            'dia' => 'martes',
            'bloque' => 'matutino',
            'hora_inicio' => '08:00',
            'hora_fin' => '10:00',
        ]);

        $service = new HorarioService();
        $this->expectException(ValidationException::class);
        $service->validateRules([
            'id_docente' => $docente->id,
            'id_materia' => $materia2->id_materia,
            'dia' => 'martes',
            'hora_inicio' => '09:00',
            'hora_fin' => '11:00',
        ]);
    }

    public function test_rechaza_mas_de_cinco_horarios_por_docente(): void
    {
        $docente = Docente::create([
            'nombre' => 'Mario',
            'apellido' => 'Gomez',
            'email' => 'mario@example.com',
        ]);

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

        foreach ($dias as $index => $dia) {
            $materia = Materia::create(['nombre_materia' => 'Materia '.($index + 1)]);
            Horario::create([
                'id_docente' => $docente->id,
                'id_materia' => $materia->id_materia,
                'dia' => $dia,
                'bloque' => 'matutino',
                'hora_inicio' => '08:00',
                'hora_fin' => '10:00',
            ]);
        }

        $materiaExtra = Materia::create(['nombre_materia' => 'Materia Extra']);
        $service = new HorarioService();
        $this->expectException(ValidationException::class);
        $service->validateRules([
            'id_docente' => $docente->id,
            'id_materia' => $materiaExtra->id_materia,
            'dia' => 'sabado',
            'hora_inicio' => '08:00',
            'hora_fin' => '10:00',
        ]);
    }

    public function test_rechaza_misma_materia_en_mismo_dia_para_docente(): void
    {
        $docente = Docente::create([
            'nombre' => 'Sofia',
            'apellido' => 'Diaz',
            'email' => 'sofia@example.com',
        ]);
        $materia = Materia::create(['nombre_materia' => 'Historia']);

        Horario::create([
            'id_docente' => $docente->id,
            'id_materia' => $materia->id_materia,
            'dia' => 'jueves',
            'bloque' => 'matutino',
            'hora_inicio' => '08:00',
            'hora_fin' => '10:00',
        ]);

        $service = new HorarioService();
        $this->expectException(ValidationException::class);
        $service->validateRules([
            'id_docente' => $docente->id,
            'id_materia' => $materia->id_materia,
            'dia' => 'jueves',
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
        ]);
    }
}
