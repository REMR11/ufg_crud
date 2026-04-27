<?php

namespace App\Http\Requests\Docente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $docente = $this->route('docente');
        $id = is_object($docente) ? (int) $docente->getKey() : (int) $docente;
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellido' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('docentes', 'email')->ignore($id)],
            'telefono' => ['nullable', 'max:20'],
        ];
    }
}
