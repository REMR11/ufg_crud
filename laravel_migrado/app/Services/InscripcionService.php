<?php

namespace App\Services;

use App\Models\Horario;
use App\Models\Inscripcion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class InscripcionService
{
    public const MAX_INSCRIPCIONES_ALUMNO = 5;

    public const MAX_CLASES_FRANJA_MATUTINA = 3;

    private const HORA_INICIO_MANANA = '06:00';

    private const HORA_FIN_FRANJA_MANANA = '12:00';

    /**
     * @param  int|null  $excluirInscripcionId  Inscripción a ignorar (al actualizar)
     */
    public function validarReglasAlumno(int $idAlumno, int $horarioId, ?int $excluirInscripcionId = null): void
    {
        $horarioNuevo = Horario::query()->findOrFail($horarioId);

        $inscripcionesOtras = Inscripcion::query()
            ->where('id_alumno', $idAlumno)
            ->with('horario')
            ->when($excluirInscripcionId !== null, fn ($q) => $q->where('id', '!=', $excluirInscripcionId))
            ->get();

        if ($inscripcionesOtras->count() >= self::MAX_INSCRIPCIONES_ALUMNO) {
            throw ValidationException::withMessages([
                'horario_id' => 'Un alumno no puede tener más de '.self::MAX_INSCRIPCIONES_ALUMNO.' materias inscritas a la vez.',
            ]);
        }

        if (! $this->duracionDosHoras($horarioNuevo->hora_inicio, $horarioNuevo->hora_fin)) {
            throw ValidationException::withMessages([
                'horario_id' => 'Cada clase debe durar exactamente 2 horas.',
            ]);
        }

        $diaNuevo = (string) $horarioNuevo->dia;
        $inicioNuevo = $this->carbonEnDiaFijo($horarioNuevo->hora_inicio);
        $finNuevo = $this->carbonEnDiaFijo($horarioNuevo->hora_fin);

        foreach ($inscripcionesOtras as $insc) {
            $h = $insc->horario;
            if ($h === null) {
                continue;
            }
            if ((string) $h->dia !== $diaNuevo) {
                continue;
            }
            if ($this->intervalosSeSolapan(
                $inicioNuevo,
                $finNuevo,
                $this->carbonEnDiaFijo($h->hora_inicio),
                $this->carbonEnDiaFijo($h->hora_fin)
            )) {
                throw ValidationException::withMessages([
                    'horario_id' => 'Ese horario se cruza con otra inscripción del mismo día para este alumno.',
                ]);
            }
        }

        if ($this->esEnFranjaMatutina($horarioNuevo)) {
            if (! $this->enVentanaFormacionMatutina($inicioNuevo, $finNuevo)) {
                throw ValidationException::withMessages([
                    'horario_id' => 'En la mañana, las clases de 2 horas deben quedar entre las 6:00 y las 12:00.',
                ]);
            }
            // Misma regla que en lote: total de clases matutinas ese día (existentes + nueva) no debe superar el máximo.
            $horariosDelDia = collect();
            foreach ($inscripcionesOtras as $insc) {
                $h = $insc->horario;
                if ($h !== null && (string) $h->dia === $diaNuevo) {
                    $horariosDelDia->push($h);
                }
            }
            $horariosDelDia->push($horarioNuevo);
            $this->validarTopeClasesMatutinasPorDia($horariosDelDia, 'horario_id');
        }
    }

    /**
     * @param  int[]  $horarioIds  Horarios nuevos a inscribir en un solo envío (sin duplicados)
     */
    public function validarLoteInscripciones(int $idAlumno, array $horarioIds): void
    {
        $horarioIds = array_values($horarioIds);
        if ($horarioIds === []) {
            return;
        }

        $nuevos = Horario::query()->whereIn('id', $horarioIds)->get()->keyBy('id');
        if ($nuevos->count() !== count($horarioIds)) {
            throw ValidationException::withMessages([
                'lineas' => 'Uno o más horarios no existen.',
            ]);
        }
        foreach ($horarioIds as $hid) {
            $h = $nuevos->get($hid);
            if (! $this->duracionDosHoras($h->hora_inicio, $h->hora_fin)) {
                throw ValidationException::withMessages([
                    'lineas' => 'Cada clase debe durar exactamente 2 horas.',
                ]);
            }
        }

        $inscripcionesOtras = Inscripcion::query()
            ->where('id_alumno', $idAlumno)
            ->with('horario')
            ->get();

        if ($inscripcionesOtras->count() + count($horarioIds) > self::MAX_INSCRIPCIONES_ALUMNO) {
            throw ValidationException::withMessages([
                'lineas' => 'Un alumno no puede tener más de '.self::MAX_INSCRIPCIONES_ALUMNO.' materias inscritas a la vez.',
            ]);
        }

        $horariosConflicto = $inscripcionesOtras
            ->pluck('horario')
            ->filter();
        foreach ($horarioIds as $hid) {
            $horariosConflicto->push($nuevos->get($hid));
        }

        $this->validarSolapesMismoDia($horariosConflicto);
        $this->validarTopeClasesMatutinasPorDia($horariosConflicto, 'lineas');
    }

    private function validarSolapesMismoDia(Collection $horarios): void
    {
        $lista = $horarios->values()->all();
        $n = count($lista);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $a = $lista[$i];
                $b = $lista[$j];
                if ($a === null || $b === null) {
                    continue;
                }
                if ((string) $a->dia !== (string) $b->dia) {
                    continue;
                }
                if ($this->intervalosSeSolapan(
                    $this->carbonEnDiaFijo($a->hora_inicio),
                    $this->carbonEnDiaFijo($a->hora_fin),
                    $this->carbonEnDiaFijo($b->hora_inicio),
                    $this->carbonEnDiaFijo($b->hora_fin)
                )) {
                    throw ValidationException::withMessages([
                        'lineas' => 'Ese horario se cruza con otra inscripción del mismo día para este alumno.',
                    ]);
                }
            }
        }
    }

    /**
     * @param  string  $errorKey  Campo de validación (p. ej. horario_id en edición, lineas en alta por lote).
     */
    private function validarTopeClasesMatutinasPorDia(Collection $horarios, string $errorKey = 'lineas'): void
    {
        $porDia = $horarios->filter()->groupBy(fn (Horario $h) => (string) $h->dia);
        foreach ($porDia as $grupo) {
            $manana = $grupo->filter(fn (Horario $h) => $this->esEnFranjaMatutina($h));
            if ($manana->count() > self::MAX_CLASES_FRANJA_MATUTINA) {
                throw ValidationException::withMessages([
                    $errorKey => 'En un mismo día no puede inscribir más de '.self::MAX_CLASES_FRANJA_MATUTINA.' clases de mañana (6:00 a 12:00), de 2 horas cada una.',
                ]);
            }
        }
    }

    private function enVentanaFormacionMatutina(Carbon $inicio, Carbon $fin): bool
    {
        $limiteIni = Carbon::parse('2000-01-01 '.self::HORA_INICIO_MANANA);
        $limiteFin = Carbon::parse('2000-01-01 '.self::HORA_FIN_FRANJA_MANANA);

        return $inicio->gte($limiteIni) && $fin->lte($limiteFin);
    }

    private function esEnFranjaMatutina(Horario $h): bool
    {
        $inicio = $this->carbonEnDiaFijo($h->hora_inicio);
        $fin = $this->carbonEnDiaFijo($h->hora_fin);

        return $this->enVentanaFormacionMatutina($inicio, $fin);
    }

    private function intervalosSeSolapan(Carbon $aInicio, Carbon $aFin, Carbon $bInicio, Carbon $bFin): bool
    {
        return $aInicio->lt($bFin) && $aFin->gt($bInicio);
    }

    private function duracionDosHoras(mixed $horaInicio, mixed $horaFin): bool
    {
        $inicio = $this->carbonEnDiaFijo($horaInicio);
        $fin = $this->carbonEnDiaFijo($horaFin);

        if (! $inicio->lt($fin)) {
            return false;
        }

        $segundos = (int) round($inicio->diffInSeconds($fin, absolute: true));

        return $segundos === 7200;
    }

    private function carbonEnDiaFijo(mixed $hora): Carbon
    {
        $c = Carbon::parse($hora);

        return Carbon::create(2000, 1, 1, $c->hour, $c->minute, $c->second);
    }
}
