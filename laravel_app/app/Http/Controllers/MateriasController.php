<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Materia;

class MateriasController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre_materia')->get();
        return view('materias.index', compact('materias'));
    }

    public function alumnosPorMateria(Materia $materia)
    {
        $inscripciones = Inscripcion::query()
            ->with(['alumno', 'horario'])
            ->where(function ($q) use ($materia): void {
                $q->where('id_materia', $materia->id_materia)
                    ->orWhereHas('horario', fn ($h) => $h->where('id_materia', $materia->id_materia));
            })
            ->get();

        return view('materias.alumnos', compact('materia', 'inscripciones'));
    }
}
