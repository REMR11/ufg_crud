<?php

namespace App\Http\Requests\AlumnoCarrera;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoCarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_alumno' => ['required', 'integer', 'exists:alumnos,id'],
            'id_carrera' => ['required', 'integer', 'exists:carreras,id'],
        ];
    }
}
