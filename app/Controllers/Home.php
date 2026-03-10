<?php

namespace App\Controllers;

use App\Models\MateriaModel;

class Home extends BaseController
{
    protected $materiaModel;

    public function __construct()
    {
        $this->materiaModel = new MateriaModel();
    }

    public function index(): string
    {
        return view('welcome_message');
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
}
