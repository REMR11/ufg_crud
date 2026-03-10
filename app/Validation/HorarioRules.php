<?php

namespace App\Validation;

class HorarioRules
{
    /**
     * Validar que el docente exista
     */
    public function validDocente(string $value): bool
    {
        $model = new \App\Models\DocenteModel();
        return $model->find((int) $value) !== null;
    }

    /**
     * Validar que la materia exista
     */
    public function validMateria(string $value): bool
    {
        $model = new \App\Models\MateriaModel();
        return $model->find((int) $value) !== null;
    }
}
