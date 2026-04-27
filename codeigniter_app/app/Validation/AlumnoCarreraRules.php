<?php

namespace App\Validation;

class AlumnoCarreraRules
{
    /**
     * Validar que el alumno exista
     */
    public function validAlumno(string $value): bool
    {
        $model = new \App\Models\AlumnosModel();
        return $model->find((int) $value) !== null;
    }

    /**
     * Validar que la carrera exista
     */
    public function validCarrera(string $value): bool
    {
        $model = new \App\Models\CarreraModel();
        return $model->find((int) $value) !== null;
    }
}
