<?php
namespace App\Controllers;

use App\Models\HorarioModel;
use App\Models\DocenteModel;
use App\Models\MateriaModel;

class Horario extends BaseController
{
    protected $horarioModel;
    protected $docenteModel;
    protected $materiaModel;
    protected $validation;

    public function __construct()
    {
        $this->horarioModel = new HorarioModel();
        $this->docenteModel = new DocenteModel();
        $this->materiaModel = new MateriaModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $filterDocente = $this->request->getGet('filtro_docente') ?? '';
        
        if (!empty($search) || !empty($filterDocente)) {
            $query = $this->horarioModel->db->table('horarios h')
                ->select('h.id, h.id_docente, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, h.id_materia, m.nombre_materia, h.dia, h.hora_inicio, h.hora_fin')
                ->join('docentes d', 'd.id = h.id_docente')
                ->join('materias m', 'm.id_materia = h.id_materia');
            
            if (!empty($search)) {
                $query->like('m.nombre_materia', $search);
            }
            
            if (!empty($filterDocente)) {
                $query->where('h.id_docente', $filterDocente);
            }
            
            $horarios = $query->orderBy('d.nombre', 'ASC')
                ->orderBy('h.dia', 'ASC')
                ->orderBy('h.hora_inicio', 'ASC')
                ->get()
                ->getResultArray();
        } else {
            $horarios = $this->horarioModel->listarConDetalles();
        }

        $docentes = $this->docenteModel->findAll();
        
        $data = [
            'horarios' => $horarios,
            'docentes' => $docentes,
            'search' => $search,
            'filtro_docente' => $filterDocente,
            'title' => 'Inscripción de Docentes a Materias'
        ];

        return view('horarios/index', $data);
    }

    public function create()
    {
        $docentes = $this->docenteModel->findAll();
        $materias = $this->materiaModel->findAll();
        
        $data = [
            'docentes' => $docentes,
            'materias' => $materias,
            'title' => 'Registrar Horario Docente'
        ];
        return view('horarios/create', $data);
    }

    public function store()
    {
        $idDocente = $this->request->getPost('id_docente');
        $idMateria = $this->request->getPost('id_materia');
        $dia = $this->request->getPost('dia');
        $horaInicio = $this->request->getPost('hora_inicio');
        $horaFin = $this->request->getPost('hora_fin');

        // Validar base de datos
        $rules = config('Validation')->horario;
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Validar que la duración sea 2 horas
        if (!$this->horarioModel->validarDuracion2Horas($horaInicio, $horaFin)) {
            return redirect()->back()->withInput()
                ->with('error', 'La duración de la materia debe ser exactamente 2 horas');
        }

        // Validar que no haya conflicto de horario
        if (!$this->horarioModel->validarConflictoHorario($idDocente, $dia, $horaInicio, $horaFin)) {
            return redirect()->back()->withInput()
                ->with('error', 'El docente tiene conflicto de horario. Ya tiene otra materia en este día y hora');
        }

        // Validar que no exceda 5 materias
        if ($this->horarioModel->contarMateriasDocente($idDocente) >= 5) {
            return redirect()->back()->withInput()
                ->with('error', 'El docente ya tiene 5 materias inscritas. No puede inscribirse en más materias');
        }

        // Validar que no sea materia duplicada para el mismo docente
        $existe = $this->horarioModel->db->table('horarios')
            ->where('id_docente', $idDocente)
            ->where('id_materia', $idMateria)
            ->countAllResults();
        
        if ($existe > 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Este docente ya tiene inscrita esta materia en otro horario');
        }

        $this->horarioModel->save([
            'id_docente' => $idDocente,
            'id_materia' => $idMateria,
            'dia' => $dia,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
        ]);

        return redirect()->to('/horarios')->with('success', 'Horario registrado exitosamente');
    }

    public function edit($id)
    {
        $horario = $this->horarioModel->find($id);
        
        if (!$horario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $docentes = $this->docenteModel->findAll();
        $materias = $this->materiaModel->findAll();

        $data = [
            'horario' => $horario,
            'docentes' => $docentes,
            'materias' => $materias,
            'title' => 'Editar Horario Docente'
        ];
        return view('horarios/edit', $data);
    }

    public function update($id)
    {
        $horario = $this->horarioModel->find($id);
        
        if (!$horario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $idDocente = $this->request->getPost('id_docente');
        $idMateria = $this->request->getPost('id_materia');
        $dia = $this->request->getPost('dia');
        $horaInicio = $this->request->getPost('hora_inicio');
        $horaFin = $this->request->getPost('hora_fin');

        $rules = config('Validation')->horario;

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Validar que la duración sea 2 horas
        if (!$this->horarioModel->validarDuracion2Horas($horaInicio, $horaFin)) {
            return redirect()->back()->withInput()
                ->with('error', 'La duración de la materia debe ser exactamente 2 horas');
        }

        // Validar que no haya conflicto de horario (excluyendo el horario actual)
        if (!$this->horarioModel->validarConflictoHorario($idDocente, $dia, $horaInicio, $horaFin, $id)) {
            return redirect()->back()->withInput()
                ->with('error', 'El docente tiene conflicto de horario. Ya tiene otra materia en este día y hora');
        }

        // Si cambió de materia, validar que no sea duplicada
        if ($idMateria != $horario['id_materia']) {
            $existe = $this->horarioModel->db->table('horarios')
                ->where('id_docente', $idDocente)
                ->where('id_materia', $idMateria)
                ->where('id !=', $id)
                ->countAllResults();
            
            if ($existe > 0) {
                return redirect()->back()->withInput()
                    ->with('error', 'Este docente ya tiene inscrita esta materia en otro horario');
            }
        }

        $this->horarioModel->update($id, [
            'id_docente' => $idDocente,
            'id_materia' => $idMateria,
            'dia' => $dia,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
        ]);

        return redirect()->to('/horarios')->with('success', 'Horario actualizado exitosamente');
    }

    public function delete($id)
    {
        $horario = $this->horarioModel->find($id);
        
        if (!$horario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->horarioModel->delete($id);
        return redirect()->to('/horarios')->with('success', 'Horario eliminado exitosamente');
    }

    public function show($id)
    {
        $horario = $this->horarioModel->db->table('horarios h')
            ->select('h.id, h.id_docente, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, d.email as email_docente, d.telefono as telefono_docente, h.id_materia, m.nombre_materia, h.dia, h.hora_inicio, h.hora_fin')
            ->join('docentes d', 'd.id = h.id_docente')
            ->join('materias m', 'm.id_materia = h.id_materia')
            ->where('h.id', $id)
            ->first();
        
        if (!$horario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Contar materias totales del docente
        $totalMaterias = $this->horarioModel->contarMateriasDocente($horario['id_docente']);

        $data = [
            'horario' => $horario,
            'total_materias' => $totalMaterias,
            'title' => 'Ver Horario Docente'
        ];
        return view('horarios/show', $data);
    }
}
