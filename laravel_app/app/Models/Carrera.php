<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Carrera extends Model
{
    protected $table = 'carreras';

    protected $fillable = ['codigo_carrera', 'nombre_carrera'];

    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumno_carrera', 'id_carrera', 'id_alumno');
    }
}
