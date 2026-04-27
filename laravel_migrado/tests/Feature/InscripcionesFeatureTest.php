<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscripcionesFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_permite_inscripcion_duplicada_por_alumno_y_horario(): void
    {
        $user = User::factory()->create();
        $alumno = Alumno::create([
            'nombre' => 'Carlos',
            'apellido' => 'Ruiz',
            'email' => 'carlos@example.com',
            'codigo' => 'ALU100',
            'codigo_carrera' => '1',
        ]);
        $docente = Docente::create([
            'nombre' => 'Paula',
            'apellido' => 'Soto',
            'email' => 'paula@example.com',
        ]);
        $materia = Materia::create(['nombre_materia' => 'Programacion']);
        $horario = Horario::create([
            'id_docente' => $docente->id,
            'id_materia' => $materia->id_materia,
            'dia' => 'lunes',
            'bloque' => 'matutino',
            'hora_inicio' => '08:00',
            'hora_fin' => '10:00',
        ]);

        Inscripcion::create([
            'id_alumno' => $alumno->id,
            'horario_id' => $horario->id,
            'id_materia' => $materia->id_materia,
        ]);

        $response = $this->actingAs($user)->post(route('inscripciones.store'), [
            'id_alumno' => $alumno->id,
            'horario_id' => $horario->id,
            'id_materia' => $materia->id_materia,
        ]);

        $response->assertSessionHasErrors('horario_id');
        $this->assertDatabaseCount('inscripcions', 1);
    }

    public function test_listado_materias_aplica_fallback_a_horario_cuando_id_materia_es_null(): void
    {
        $user = User::factory()->create();
        $alumno = Alumno::create([
            'nombre' => 'Marta',
            'apellido' => 'Diaz',
            'email' => 'marta@example.com',
            'codigo' => 'ALU200',
            'codigo_carrera' => '1',
        ]);
        $docente = Docente::create([
            'nombre' => 'Luis',
            'apellido' => 'Mora',
            'email' => 'luismora@example.com',
        ]);
        $materia = Materia::create(['nombre_materia' => 'Bases de Datos']);
        $horario = Horario::create([
            'id_docente' => $docente->id,
            'id_materia' => $materia->id_materia,
            'dia' => 'martes',
            'bloque' => 'vespertino',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
        ]);

        Inscripcion::create([
            'id_alumno' => $alumno->id,
            'horario_id' => $horario->id,
            'id_materia' => null,
        ]);

        $response = $this->actingAs($user)->get(route('inscripciones.index'));

        $response->assertOk();
        $response->assertSee('Bases de Datos');
    }
}
