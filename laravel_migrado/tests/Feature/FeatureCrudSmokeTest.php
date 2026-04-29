<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureCrudSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_crud_indexes_are_accessible(): void
    {
        $routes = [
            'home',
            'alumnos.index',
            'docentes.index',
            'carreras.index',
            'horarios.index',
            'inscripciones.index',
            'alumno_carrera.index',
            'materias.index',
        ];
        foreach ($routes as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}
