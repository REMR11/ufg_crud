<?php

namespace App\Http\Requests\Alumno;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:alumnos,email'],
            'telefono' => ['nullable', 'digits:8'],
            'codigo' => ['required', 'alpha_num', 'max:20', 'unique:alumnos,codigo'],
            'codigo_carrera' => ['required', 'numeric'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
