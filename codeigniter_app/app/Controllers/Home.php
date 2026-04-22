<?php

namespace App\Controllers;

use App\Models\MateriaModel;
use App\Models\InscripcionModel;

class Home extends BaseController
{
    protected $materiaModel;
    protected $inscripcionModel;

    public function __construct()
    {
        $this->materiaModel = new MateriaModel();
        $this->inscripcionModel = new InscripcionModel();
    }

    public function index(): string
    {
        return view('home/index', ['title' => 'Inicio']);
    }

    public function materias()
    {
        $materias = $this->materiaModel->findAll();
        
        $data = [
            'title' => 'Materias',
            'materias' => $materias
        ];

        return view('materias/index', $data);
    }

    public function alumnosPorMateria($idMateria)
    {
        $materia = $this->materiaModel->find($idMateria);

        if (!$materia) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $alumnos = $this->inscripcionModel->obtenerAlumnosPorMateria((int) $idMateria);

        $data = [
            'title' => 'Alumnos por Materia',
            'materia' => $materia,
            'alumnos' => $alumnos,
        ];

        return view('materias/alumnos', $data);
    }
}
