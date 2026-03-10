<?php
namespace App\Controllers;

use App\Models\AlumnosModel;
use App\Models\CarreraModel;

class Alumnos extends BaseController
{
    protected $alumnoModel;
    protected $carreraModel;
    protected $validation;

    public function __construct()
    {
        $this->alumnoModel = new AlumnosModel();
        $this->carreraModel = new CarreraModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        
        if (!empty($search)) {
            $alumnos = $this->alumnoModel
                ->like('nombre', $search)
                ->orLike('apellido', $search)
                ->orLike('email', $search)
                ->orLike('codigo', $search)
                ->findAll();
        } else {
            $alumnos = $this->alumnoModel->findAll();
        }

        $data = [
            'alumnos' => $alumnos,
            'search' => $search,
            'title' => 'Alumnos'
        ];

        return view('alumnos/index', $data);
    }

    public function create()
    {
        $carreras = $this->carreraModel->findAll();
        $data = [
            'carreras' => $carreras,
            'title' => 'Crear Alumno'
        ];
        return view('alumnos/create', $data);
    }

    public function store()
    {
        $rules = config('Validation')->alumno;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->alumnoModel->save([
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'codigo' => $this->request->getPost('codigo'),
            'codigo_carrera' => $this->request->getPost('codigo_carrera'),
        ]);

        return redirect()->to('/alumnos')->with('success', 'Alumno creado exitosamente');
    }

    public function edit($id)
    {
        $alumno = $this->alumnoModel->find($id);
        
        if (!$alumno) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $carreras = $this->carreraModel->findAll();
        $data = [
            'alumno' => $alumno,
            'carreras' => $carreras,
            'title' => 'Editar Alumno'
        ];
        return view('alumnos/edit', $data);
    }

    public function update($id)
    {
        $alumno = $this->alumnoModel->find($id);
        
        if (!$alumno) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Reglas especiales para actualización (permitir email y código actuales)
        $rules = [
            'nombre' => [
                'label' => 'Nombre',
                'rules' => 'required|string|min_length[2]|max_length[100]',
            ],
            'apellido' => [
                'label' => 'Apellido',
                'rules' => 'required|string|min_length[2]|max_length[100]',
            ],
            'email' => [
                'label' => 'Correo Electrónico',
                'rules' => "required|valid_email|max_length[100]|is_unique[alumnos.email,id,{$id}]",
            ],
            'telefono' => [
                'label' => 'Teléfono',
                'rules' => 'permit_empty|numeric|exact_length[8]',
            ],
            'codigo' => [
                'label' => 'Código de Estudiante',
                'rules' => "required|alphanumeric|max_length[20]|is_unique[alumnos.codigo,id,{$id}]",
            ],
            'codigo_carrera' => [
                'label' => 'Carrera',
                'rules' => 'required|numeric',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->alumnoModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'codigo' => $this->request->getPost('codigo'),
            'codigo_carrera' => $this->request->getPost('codigo_carrera'),
        ]);

        return redirect()->to('/alumnos')->with('success', 'Alumno actualizado exitosamente');
    }

    public function delete($id)
    {
        $alumno = $this->alumnoModel->find($id);
        
        if (!$alumno) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->alumnoModel->delete($id);
        return redirect()->to('/alumnos')->with('success', 'Alumno eliminado exitosamente');
    }

    public function show($id)
    {
        $alumno = $this->alumnoModel->find($id);
        
        if (!$alumno) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Obtener información de la carrera
        $carrera = $this->carreraModel->find($alumno['codigo_carrera']);

        $data = [
            'alumno' => $alumno,
            'carrera' => $carrera,
            'title' => 'Ver Alumno'
        ];
        return view('alumnos/show', $data);
    }
}
