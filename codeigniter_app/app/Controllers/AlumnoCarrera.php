<?php

namespace App\Controllers;

use App\Models\Alumno_carreraModel;
use App\Models\AlumnosModel;
use App\Models\CarreraModel;

class AlumnoCarrera extends BaseController
{
    protected $alumnoCarreraModel;
    protected $alumnosModel;
    protected $carreraModel;
    protected $validation;

    public function __construct()
    {
        $this->alumnoCarreraModel = new Alumno_carreraModel();
        $this->alumnosModel = new AlumnosModel();
        $this->carreraModel = new CarreraModel();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Listar todas las asignaciones alumno-carrera con búsqueda y filtros
     */
    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $idCarrera = $this->request->getGet('id_carrera') ?? '';

        // Obtener datos con filtros
        $alumnoCarrera = $this->alumnoCarreraModel->getAlumnoCarreraWithDetails($search, $idCarrera);

        // Obtener carreras para el selector de filtro
        $carreras = $this->carreraModel->findAll();

        $data = [
            'alumnoCarrera' => $alumnoCarrera,
            'carreras' => $carreras,
            'search' => $search,
            'idCarrera' => $idCarrera,
            'title' => 'Asignación Alumno-Carrera'
        ];

        return view('alumno_carrera/index', $data);
    }

    /**
     * Mostrar formulario para crear nueva asignación
     */
    public function create()
    {
        $alumnos = $this->alumnosModel->findAll();
        $carreras = $this->carreraModel->findAll();

        $data = [
            'alumnos' => $alumnos,
            'carreras' => $carreras,
            'title' => 'Asignar Alumno a Carrera'
        ];

        return view('alumno_carrera/create', $data);
    }

    /**
     * Guardar nueva asignación alumno-carrera
     */
    public function store()
    {
        $rules = config('Validation')->alumno_carrera;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $idAlumno = $this->request->getPost('id_alumno');
        $idCarrera = $this->request->getPost('id_carrera');

        // Verificar si ya existe esta asignación
        if ($this->alumnoCarreraModel->existsAssignment($idAlumno, $idCarrera)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Este alumno ya está asignado a esta carrera');
        }

        $this->alumnoCarreraModel->save([
            'id_alumno' => $idAlumno,
            'id_carrera' => $idCarrera,
        ]);

        return redirect()->to('/alumno_carrera')->with('success', 'Asignación creada exitosamente');
    }

    /**
     * Mostrar formulario para editar asignación
     */
    public function edit($id)
    {
        $asignacion = $this->alumnoCarreraModel->find($id);

        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $alumnos = $this->alumnosModel->findAll();
        $carreras = $this->carreraModel->findAll();

        $data = [
            'asignacion' => $asignacion,
            'alumnos' => $alumnos,
            'carreras' => $carreras,
            'title' => 'Editar Asignación'
        ];

        return view('alumno_carrera/edit', $data);
    }

    /**
     * Actualizar asignación alumno-carrera
     */
    public function update($id)
    {
        $asignacion = $this->alumnoCarreraModel->find($id);

        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'id_alumno' => [
                'label' => 'Alumno',
                'rules' => 'required|numeric|validAlumno',
            ],
            'id_carrera' => [
                'label' => 'Carrera',
                'rules' => 'required|numeric|validCarrera',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $idAlumno = $this->request->getPost('id_alumno');
        $idCarrera = $this->request->getPost('id_carrera');

        // Verificar si ya existe esta asignación (excluyendo el registro actual)
        if ($this->alumnoCarreraModel->existsAssignment($idAlumno, $idCarrera, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe una asignación idéntica');
        }

        $this->alumnoCarreraModel->update($id, [
            'id_alumno' => $idAlumno,
            'id_carrera' => $idCarrera,
        ]);

        return redirect()->to('/alumno_carrera')->with('success', 'Asignación actualizada exitosamente');
    }

    /**
     * Eliminar asignación
     */
    public function delete($id)
    {
        $asignacion = $this->alumnoCarreraModel->find($id);

        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->alumnoCarreraModel->delete($id);
        return redirect()->to('/alumno_carrera')->with('success', 'Asignación eliminada exitosamente');
    }

    /**
     * Ver detalle de una asignación
     */
    public function show($id)
    {
        $asignacion = $this->alumnoCarreraModel->getDetail($id);

        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Obtener otras carreras del mismo alumno
        $otrasCarreras = $this->alumnoCarreraModel->getCarrerasByAlumno($asignacion['id_alumno']);

        $data = [
            'asignacion' => $asignacion,
            'otrasCarreras' => $otrasCarreras,
            'title' => 'Detalle de Asignación'
        ];

        return view('alumno_carrera/show', $data);
    }
}
