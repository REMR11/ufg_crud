<?php

namespace App\Http\Requests\Carrera;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $carrera = $this->route('carrera');
        $id = is_object($carrera) ? (int) $carrera->id : (int) $carrera;
        return [
            'codigo_carrera' => ['required', 'string', 'min:2', 'max:20', Rule::unique('carreras', 'codigo_carrera')->ignore($id)],
            'nombre_carrera' => ['required', 'string', 'min:2', 'max:150', Rule::unique('carreras', 'nombre_carrera')->ignore($id)],
        ];
    }
}
