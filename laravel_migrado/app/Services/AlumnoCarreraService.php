<?php

namespace App\Services;

use App\Models\AlumnoCarrera;
use Illuminate\Validation\ValidationException;

class AlumnoCarreraService
{
    public function ensureUniqueAssignment(int $idAlumno, int $idCarrera, ?int $excludeId = null): void
    {
        $exists = AlumnoCarrera::query()
            ->where('id_alumno', $idAlumno)
            ->where('id_carrera', $idCarrera)
            ->when($excludeId !== null, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'id_alumno' => 'Ya existe una asignación idéntica alumno-carrera.',
            ]);
        }
    }
}
