<?php
namespace App\Controllers;

use App\Models\DocenteModel;

class Docentes extends BaseController
{
    protected $docenteModel;
    protected $validation;

    public function __construct()
    {
        $this->docenteModel = new DocenteModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        
        if (!empty($search)) {
            $docentes = $this->docenteModel
                ->like('nombre', $search)
                ->orLike('apellido', $search)
                ->findAll();
        } else {
            $docentes = $this->docenteModel->findAll();
        }

        $data = [
            'docentes' => $docentes,
            'search' => $search,
            'title' => 'Docentes'
        ];

        return view('docentes/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Crear Docente'
        ];
        return view('docentes/create', $data);
    }

    public function store()
    {
        $rules = config('Validation')->docente;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->docenteModel->save([
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
        ]);

        return redirect()->to('/docentes')->with('success', 'Docente creado exitosamente');
    }

    public function edit($id)
    {
        $docente = $this->docenteModel->find($id);
        
        if (!$docente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'docente' => $docente,
            'title' => 'Editar Docente'
        ];
        return view('docentes/edit', $data);
    }

    public function update($id)
    {
        $docente = $this->docenteModel->find($id);
        
        if (!$docente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = config('Validation')->docente;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->docenteModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
        ]);

        return redirect()->to('/docentes')->with('success', 'Docente actualizado exitosamente');
    }

    public function delete($id)
    {
        $docente = $this->docenteModel->find($id);
        
        if (!$docente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->docenteModel->delete($id);
        return redirect()->to('/docentes')->with('success', 'Docente eliminado exitosamente');
    }

    public function show($id)
    {
        $docente = $this->docenteModel->find($id);
        
        if (!$docente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'docente' => $docente,
            'title' => 'Ver Docente'
        ];
        return view('docentes/show', $data);
    }
}
