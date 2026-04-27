<?php

namespace App\Http\Requests\Horario;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_docente' => ['required', 'integer', 'exists:docentes,id'],
            'id_materia' => ['required', 'integer', 'exists:materias,id_materia'],
            'dia' => ['required', 'in:lunes,martes,miercoles,jueves,viernes,sabado'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i'],
        ];
    }
}
