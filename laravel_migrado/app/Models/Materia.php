<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $table = 'materias';

    protected $primaryKey = 'id_materia';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = ['nombre_materia'];

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class, 'id_materia', 'id_materia');
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'id_materia', 'id_materia');
    }
}
