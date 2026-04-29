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
            'codigo_carrera' => ['required', 'integer', 'exists:carreras,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.min' => 'El apellido debe tener al menos 2 caracteres.',
            'apellido.max' => 'El apellido no puede superar los 100 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no tiene un formato válido.',
            'email.max' => 'El email no puede superar los 100 caracteres.',
            'email.unique' => 'El email ya está registrado.',
            'telefono.digits' => 'El teléfono debe tener exactamente 8 dígitos.',
            'codigo.required' => 'El código es obligatorio.',
            'codigo.alpha_num' => 'El código solo puede contener letras y números.',
            'codigo.max' => 'El código no puede superar los 20 caracteres.',
            'codigo.unique' => 'El código ya está registrado.',
            'codigo_carrera.required' => 'Debes seleccionar una carrera.',
            'codigo_carrera.integer' => 'La carrera seleccionada es inválida.',
            'codigo_carrera.exists' => 'La carrera seleccionada no existe.',
        ];
    }
}
