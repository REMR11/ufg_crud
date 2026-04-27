<?php

namespace App\Services;

use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class HorarioService
{
    public function validateRules(array $payload, ?int $excludeHorarioId = null): void
    {
        $idDocente = (int) $payload['id_docente'];
        $idMateria = (int) $payload['id_materia'];
        $dia = (string) $payload['dia'];
        $horaInicio = (string) $payload['hora_inicio'];
        $horaFin = (string) $payload['hora_fin'];

        if (!$this->duracionDosHoras($horaInicio, $horaFin)) {
            throw ValidationException::withMessages([
                'hora_fin' => 'La duración de la materia debe ser exactamente 2 horas.',
            ]);
        }

        if (!$this->sinConflicto($idDocente, $dia, $horaInicio, $horaFin, $excludeHorarioId)) {
            throw ValidationException::withMessages([
                'hora_inicio' => 'El docente tiene conflicto de horario en este día y hora.',
            ]);
        }

        $query = Horario::query()->where('id_docente', $idDocente);
        if ($excludeHorarioId !== null) {
            $query->where('id', '!=', $excludeHorarioId);
        }
        if ($query->count() >= 5) {
            throw ValidationException::withMessages([
                'id_docente' => 'El docente ya tiene 5 materias inscritas.',
            ]);
        }

        $materiaMismoDia = Horario::query()
            ->where('id_docente', $idDocente)
            ->where('id_materia', $idMateria)
            ->where('dia', $dia)
            ->when($excludeHorarioId !== null, fn ($q) => $q->where('id', '!=', $excludeHorarioId))
            ->exists();

        if ($materiaMismoDia) {
            throw ValidationException::withMessages([
                'id_materia' => 'Este docente ya tiene inscrita esta materia en el mismo día.',
            ]);
        }
    }

    public function resolveBloque(string $horaInicio): string
    {
        return Carbon::parse($horaInicio)->lt(Carbon::parse('12:00')) ? 'matutino' : 'vespertino';
    }

    private function duracionDosHoras(string $horaInicio, string $horaFin): bool
    {
        $inicio = Carbon::parse($horaInicio);
        $fin = Carbon::parse($horaFin);
        return $inicio->diffInHours($fin) === 2 && $inicio->lt($fin);
    }

    private function sinConflicto(
        int $idDocente,
        string $dia,
        string $horaInicio,
        string $horaFin,
        ?int $excludeHorarioId = null
    ): bool {
        $inicioNuevo = Carbon::parse($horaInicio);
        $finNuevo = Carbon::parse($horaFin);

        $horarios = Horario::query()
            ->where('id_docente', $idDocente)
            ->where('dia', $dia)
            ->when($excludeHorarioId !== null, fn ($q) => $q->where('id', '!=', $excludeHorarioId))
            ->get();

        foreach ($horarios as $horario) {
            $inicioExistente = Carbon::parse((string) $horario->hora_inicio);
            $finExistente = Carbon::parse((string) $horario->hora_fin);
            if ($inicioNuevo->lt($finExistente) && $finNuevo->gt($inicioExistente)) {
                return false;
            }
        }

        return true;
    }
}
