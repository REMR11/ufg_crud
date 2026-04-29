<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    protected $table = 'alumnos';

    /** La tabla en PostgreSQL/legacy puede no incluir created_at / updated_at */
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'codigo',
        'codigo_carrera',
    ];

    public function carreras(): BelongsToMany
    {
        return $this->belongsToMany(Carrera::class, 'alumno_carrera', 'id_alumno', 'id_carrera');
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_alumno');
    }
}
