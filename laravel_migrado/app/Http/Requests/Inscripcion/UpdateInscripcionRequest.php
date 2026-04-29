<?php

namespace App\Http\Requests\Inscripcion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInscripcionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_alumno' => ['required', 'integer', 'exists:alumnos,id'],
            'horario_id' => ['required', 'integer', 'exists:horarios,id'],
            'id_materia' => ['nullable', 'integer', 'exists:materias,id_materia'],
            'fecha_inscripcion' => ['nullable', 'date', 'before_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_alumno.required' => 'Debes seleccionar un alumno.',
            'id_alumno.exists' => 'El alumno seleccionado no existe.',
            'horario_id.required' => 'Debes seleccionar un horario.',
            'horario_id.exists' => 'El horario seleccionado no existe.',
            'id_materia.exists' => 'La materia seleccionada no existe.',
            'fecha_inscripcion.date' => 'La fecha de inscripcion no tiene un formato valido.',
            'fecha_inscripcion.before_or_equal' => 'La fecha de inscripcion no puede ser futura.',
        ];
    }
}
