<?php

namespace App\Http\Requests\Inscripcion;

use Illuminate\Foundation\Http\FormRequest;

class StoreInscripcionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $raw = $this->input('lineas', []);
        if (! is_array($raw)) {
            $this->merge(['lineas' => []]);

            return;
        }
        $lineas = collect($raw)
            ->map(function ($l) {
                if (! is_array($l)) {
                    return null;
                }
                $h = $l['horario_id'] ?? null;
                $hid = $h === '' || $h === null ? null : (int) $h;
                $m = $l['id_materia'] ?? null;
                $mid = $m === '' || $m === null ? null : (int) $m;
                if ($hid === null) {
                    return null;
                }

                return ['horario_id' => $hid, 'id_materia' => $mid];
            })
            ->filter()
            ->values()
            ->all();
        $this->merge(['lineas' => $lineas]);
    }

    public function rules(): array
    {
        return [
            'id_alumno' => ['required', 'integer', 'exists:alumnos,id'],
            'lineas' => ['required', 'array', 'min:1', 'max:5'],
            'lineas.*.horario_id' => ['required', 'integer', 'distinct', 'exists:horarios,id'],
            'lineas.*.id_materia' => ['nullable', 'integer', 'exists:materias,id_materia'],
            'fecha_inscripcion' => ['nullable', 'date', 'before_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_alumno.required' => 'Debes seleccionar un alumno.',
            'id_alumno.exists' => 'El alumno seleccionado no existe.',
            'lineas.required' => 'Debes indicar al menos un horario.',
            'lineas.min' => 'Debes indicar al menos un horario.',
            'lineas.max' => 'Puedes inscribir como máximo 5 horarios a la vez.',
            'lineas.*.horario_id.required' => 'Cada fila con horario debe tener un horario seleccionado.',
            'lineas.*.horario_id.exists' => 'Uno de los horarios no existe.',
            'lineas.*.horario_id.distinct' => 'No repitas el mismo horario en varias filas.',
            'lineas.*.id_materia.exists' => 'Una de las materias seleccionadas no existe.',
            'fecha_inscripcion.date' => 'La fecha de inscripcion no tiene un formato valido.',
            'fecha_inscripcion.before_or_equal' => 'La fecha de inscripcion no puede ser futura.',
        ];
    }
}
