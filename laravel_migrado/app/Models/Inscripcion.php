<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Inscripcion extends Model
{
    protected $table = 'inscripcions';

    protected $fillable = [
        'id_alumno',
        'id_materia',
        'horario_id',
        'fecha_inscripcion',
    ];

    public $timestamps = false;

    protected $casts = [
        'fecha_inscripcion' => 'datetime',
    ];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    public function scopeConDetalles(Builder $query): Builder
    {
        return $query
            ->leftJoin('alumnos as a', 'a.id', '=', 'inscripcions.id_alumno')
            ->leftJoin('horarios as h', 'h.id', '=', 'inscripcions.horario_id')
            ->leftJoin('docentes as d', 'd.id', '=', 'h.id_docente')
            ->leftJoin('materias as m', function ($join): void {
                $join->on('m.id_materia', '=', 'inscripcions.id_materia')
                    ->orOn('m.id_materia', '=', 'h.id_materia');
            })
            ->select([
                'inscripcions.id',
                'inscripcions.horario_id',
                'inscripcions.id_alumno',
                'inscripcions.id_materia',
                'inscripcions.fecha_inscripcion',
                'a.codigo',
                'a.nombre',
                'a.apellido',
                'd.nombre as docente_nombre',
                'd.apellido as docente_apellido',
                'm.nombre_materia',
                'h.dia',
                'h.hora_inicio',
                'h.hora_fin',
            ])
            ->orderBy('m.nombre_materia')
            ->orderBy('d.nombre')
            ->orderBy('h.dia')
            ->orderBy('h.hora_inicio')
            ->orderBy('a.apellido');
    }

    public function scopeDeMateria(Builder $query, int $idMateria): Builder
    {
        return $query->where(function (Builder $nested) use ($idMateria): void {
            $nested
                ->where('id_materia', $idMateria)
                ->orWhereHas('horario', fn (Builder $horario) => $horario->where('id_materia', $idMateria));
        });
    }
}
