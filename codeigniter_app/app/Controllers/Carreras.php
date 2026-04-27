<?php
namespace App\Controllers;

use App\Models\CarreraModel;

class Carreras extends BaseController
{
    protected $carreraModel;
    protected $validation;

    public function __construct()
    {
        $this->carreraModel = new CarreraModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        
        if (!empty($search)) {
            $carreras = $this->carreraModel
                ->like('nombre_carrera', $search)
                ->orLike('codigo_carrera', $search)
                ->findAll();
        } else {
            $carreras = $this->carreraModel->findAll();
        }

        $data = [
            'carreras' => $carreras,
            'search' => $search,
            'title' => 'Carreras'
        ];

        return view('carreras/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Crear Carrera'
        ];
        return view('carreras/create', $data);
    }

    public function store()
    {
        $rules = config('Validation')->carrera;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->carreraModel->save([
            'codigo_carrera' => $this->request->getPost('codigo_carrera'),
            'nombre_carrera' => $this->request->getPost('nombre_carrera'),
        ]);

        return redirect()->to('/carreras')->with('success', 'Carrera creada exitosamente');
    }

    public function edit($id)
    {
        $carrera = $this->carreraModel->find($id);
        
        if (!$carrera) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'carrera' => $carrera,
            'title' => 'Editar Carrera'
        ];
        return view('carreras/edit', $data);
    }

    public function update($id)
    {
        $carrera = $this->carreraModel->find($id);
        
        if (!$carrera) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nombre_carrera' => [
                'label' => 'Nombre de Carrera',
                'rules' => "required|string|min_length[2]|max_length[150]|is_unique[carreras.nombre_carrera,id,{$id}]",
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->carreraModel->update($id, [
            'nombre_carrera' => $this->request->getPost('nombre_carrera'),
        ]);

        return redirect()->to('/carreras')->with('success', 'Carrera actualizada exitosamente');
    }

    public function delete($id)
    {
        $carrera = $this->carreraModel->find($id);
        
        if (!$carrera) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->carreraModel->delete($id);
        return redirect()->to('/carreras')->with('success', 'Carrera eliminada exitosamente');
    }

    public function show($id)
    {
        $carrera = $this->carreraModel->find($id);
        
        if (!$carrera) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'carrera' => $carrera,
            'title' => 'Ver Carrera'
        ];
        return view('carreras/show', $data);
    }
}
