<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Inscripcion;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'stats' => [
                'alumnos' => Alumno::query()->count(),
                'docentes' => Docente::query()->count(),
                'carreras' => Carrera::query()->count(),
                'horarios' => Horario::query()->count(),
                'inscripciones' => Inscripcion::query()->count(),
            ],
        ]);
    }
}
