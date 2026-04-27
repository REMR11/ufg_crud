<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Contracts\View\View;

class MateriasController extends Controller
{
    public function index(): View
    {
        $materias = Materia::orderBy('nombre_materia')->get();
        return view('materias.index', compact('materias'));
    }

    public function alumnosPorMateria(Materia $materia): View
    {
        $inscripciones = Inscripcion::query()
            ->with(['alumno', 'horario.docente', 'materia'])
            ->deMateria($materia->id_materia)
            ->orderByDesc('fecha_inscripcion')
            ->get();

        return view('materias.alumnos', compact('materia', 'inscripciones'));
    }
}
