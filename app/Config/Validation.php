<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \App\Validation\HorarioRules::class,
        \App\Validation\AlumnoCarreraRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    /**
     * Reglas de validación para Alumnos
     */
    public array $alumno = [
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
            'rules' => 'required|valid_email|max_length[100]|is_unique[alumnos.email,id,{id}]',
        ],
        'telefono' => [
            'label' => 'Teléfono',
            'rules' => 'permit_empty|numeric|exact_length[8]',
        ],
        'codigo' => [
            'label' => 'Código de Estudiante',
            'rules' => 'required|alphanumeric|max_length[20]|is_unique[alumnos.codigo,id,{id}]',
        ],
        'codigo_carrera' => [
            'label' => 'Carrera',
            'rules' => 'required|numeric',
        ],
    ];

    /**
     * Reglas de validación para Docentes
     */
    public array $docente = [
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
            'rules' => 'required|valid_email|max_length[100]|is_unique[docentes.email,id,{id}]',
        ],
        'telefono' => [
            'label' => 'Teléfono',
            'rules' => 'permit_empty|max_length[20]',
        ],
    ];

    /**
     * Reglas de validación para Carreras
     */
    public array $carrera = [
        'codigo_carrera' => [
            'label' => 'Código de Carrera',
            'rules' => 'required|string|min_length[2]|max_length[20]|is_unique[carreras.codigo_carrera,id,{id}]',
        ],
        'nombre_carrera' => [
            'label' => 'Nombre de Carrera',
            'rules' => 'required|string|min_length[2]|max_length[150]|is_unique[carreras.nombre_carrera,id,{id}]',
        ],
    ];

    /**
     * Reglas de validación para Horarios (Inscripción de Docentes)
     */
    public array $horario = [
        'id_docente' => [
            'label' => 'Docente',
            'rules' => 'required|numeric|validDocente',
        ],
        'id_materia' => [
            'label' => 'Materia',
            'rules' => 'required|numeric|validMateria',
        ],
        'dia' => [
            'label' => 'Día de la Semana',
            'rules' => 'required|in_list[lunes,martes,miercoles,jueves,viernes,sabado]',
        ],
        'hora_inicio' => [
            'label' => 'Hora de Inicio',
            'rules' => 'required',
        ],
        'hora_fin' => [
            'label' => 'Hora de Finalización',
            'rules' => 'required',
        ],
    ];

    /**
     * Reglas de validación para Asignación Alumno-Carrera
     */
    public array $alumno_carrera = [
        'id_alumno' => [
            'label' => 'Alumno',
            'rules' => 'required|numeric|validAlumno',
        ],
        'id_carrera' => [
            'label' => 'Carrera',
            'rules' => 'required|numeric|validCarrera',
        ],
    ];
}
