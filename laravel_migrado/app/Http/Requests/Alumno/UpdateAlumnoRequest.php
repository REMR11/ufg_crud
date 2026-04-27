<?php

namespace App\Http\Requests\Alumno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumno = $this->route('alumno');
        $id = is_object($alumno) ? (int) $alumno->id : (int) $alumno;

        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('alumnos', 'email')->ignore($id)],
            'telefono' => ['nullable', 'digits:8'],
            'codigo' => ['required', 'alpha_num', 'max:20', Rule::unique('alumnos', 'codigo')->ignore($id)],
            'codigo_carrera' => ['required', 'numeric'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
