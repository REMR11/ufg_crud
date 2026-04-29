<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscripcionesReglasAlumnoTest extends TestCase
{
    use RefreshDatabase;

    public function test_rechaza_sexta_inscripcion_cuando_el_alumno_ya_tiene_cinco(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Ana',
            'apellido' => 'Ibañez',
            'email' => 'ana-ib@example.com',
            'codigo' => 'ALU500',
            'codigo_carrera' => '1',
        ]);
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
        for ($i = 0; $i < 5; $i++) {
            $docente = Docente::create([
                'nombre' => 'Doc',
                'apellido' => (string) $i,
                'email' => "doc{$i}@example.com",
            ]);
            $materia = Materia::create(['nombre_materia' => "Mat {$i}"]);
            $h = Horario::create([
                'id_docente' => $docente->id,
                'id_materia' => $materia->id_materia,
                'dia' => $dias[$i],
                'bloque' => 'vespertino',
                'hora_inicio' => '14:00:00',
                'hora_fin' => '16:00:00',
            ]);
            Inscripcion::create([
                'id_alumno' => $alumno->id,
                'horario_id' => $h->id,
                'id_materia' => $materia->id_materia,
            ]);
        }
        $doc6 = Docente::create(['nombre' => 'Doc6', 'apellido' => 'S', 'email' => 'doc6@example.com']);
        $m6 = Materia::create(['nombre_materia' => 'Mat 6']);
        $h6 = Horario::create([
            'id_docente' => $doc6->id,
            'id_materia' => $m6->id_materia,
            'dia' => 'sabado',
            'bloque' => 'vespertino',
            'hora_inicio' => '14:00:00',
            'hora_fin' => '16:00:00',
        ]);
        $response = $this->post(route('inscripciones.store'), [
            'id_alumno' => $alumno->id,
            'lineas' => [
                ['horario_id' => $h6->id, 'id_materia' => $m6->id_materia],
            ],
        ]);
        $response->assertSessionHasErrors('lineas');
    }

    public function test_rechaza_inscripcion_si_cruza_otro_horario_mismo_dia(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Ben',
            'apellido' => 'Cruz',
            'email' => 'ben@example.com',
            'codigo' => 'ALU501',
            'codigo_carrera' => '1',
        ]);
        $d1 = Docente::create(['nombre' => 'D1', 'apellido' => 'A', 'email' => 'd1@example.com']);
        $d2 = Docente::create(['nombre' => 'D2', 'apellido' => 'B', 'email' => 'd2@example.com']);
        $m1 = Materia::create(['nombre_materia' => 'A']);
        $m2 = Materia::create(['nombre_materia' => 'B']);
        $h1 = Horario::create([
            'id_docente' => $d1->id,
            'id_materia' => $m1->id_materia,
            'dia' => 'lunes',
            'bloque' => 'vespertino',
            'hora_inicio' => '14:00:00',
            'hora_fin' => '16:00:00',
        ]);
        Inscripcion::create([
            'id_alumno' => $alumno->id,
            'horario_id' => $h1->id,
            'id_materia' => $m1->id_materia,
        ]);
        $h2 = Horario::create([
            'id_docente' => $d2->id,
            'id_materia' => $m2->id_materia,
            'dia' => 'lunes',
            'bloque' => 'vespertino',
            'hora_inicio' => '15:00:00',
            'hora_fin' => '17:00:00',
        ]);
        $response = $this->post(route('inscripciones.store'), [
            'id_alumno' => $alumno->id,
            'lineas' => [
                ['horario_id' => $h2->id, 'id_materia' => $m2->id_materia],
            ],
        ]);
        $response->assertSessionHasErrors('lineas');
    }

    public function test_rechaza_cuarto_bloque_matutino_que_cruza_con_inscripcion_existente(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Cid',
            'apellido' => 'Luna',
            'email' => 'cid2@example.com',
            'codigo' => 'ALU502',
            'codigo_carrera' => '1',
        ]);
        $fila = function (int $dIdx, int $mIdx, string $ini, string $fin) {
            $d = Docente::create([
                'nombre' => 'D',
                'apellido' => (string) $dIdx,
                'email' => "doc-j-{$dIdx}-{$mIdx}@e.com",
            ]);
            $m = Materia::create(['nombre_materia' => "Mx{$mIdx}"]);
            $h = Horario::create([
                'id_docente' => $d->id,
                'id_materia' => $m->id_materia,
                'dia' => 'jueves',
                'bloque' => 'matutino',
                'hora_inicio' => $ini,
                'hora_fin' => $fin,
            ]);

            return compact('d', 'm', 'h');
        };
        $fila(0, 0, '14:00:00', '16:00:00');
        $fila(1, 1, '16:00:00', '18:00:00');
        $a = $fila(2, 2, '06:00:00', '08:00:00');
        $b = $fila(3, 3, '08:00:00', '10:00:00');
        $c = $fila(4, 4, '10:00:00', '12:00:00');
        foreach ([$a, $b, $c] as $row) {
            $this->post(route('inscripciones.store'), [
                'id_alumno' => $alumno->id,
                'lineas' => [
                    ['horario_id' => $row['h']->id, 'id_materia' => $row['m']->id_materia],
                ],
            ])->assertSessionHasNoErrors()->assertRedirect(route('inscripciones.index'));
        }
        $d4 = Docente::create(['nombre' => 'DL', 'apellido' => '4', 'email' => 'd4e@e.com']);
        $m4 = Materia::create(['nombre_materia' => 'CuartoBloq']);
        $h4 = Horario::create([
            'id_docente' => $d4->id,
            'id_materia' => $m4->id_materia,
            'dia' => 'jueves',
            'bloque' => 'matutino',
            'hora_inicio' => '06:00:00',
            'hora_fin' => '08:00:00',
        ]);
        $this->post(route('inscripciones.store'), [
            'id_alumno' => $alumno->id,
            'lineas' => [
                ['horario_id' => $h4->id, 'id_materia' => $m4->id_materia],
            ],
        ])->assertSessionHasErrors('lineas');
    }
}
