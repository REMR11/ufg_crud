<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'id_docente',
        'id_materia',
        'dia',
        'bloque',
        'hora_inicio',
        'hora_fin',
    ];

    public $timestamps = false;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'horario_id');
    }
}
