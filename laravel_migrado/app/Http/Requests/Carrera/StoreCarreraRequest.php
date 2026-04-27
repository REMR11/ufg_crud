<?php

namespace App\Http\Requests\Carrera;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_carrera' => ['required', 'string', 'min:2', 'max:20', 'unique:carreras,codigo_carrera'],
            'nombre_carrera' => ['required', 'string', 'min:2', 'max:150', 'unique:carreras,nombre_carrera'],
        ];
    }
}
