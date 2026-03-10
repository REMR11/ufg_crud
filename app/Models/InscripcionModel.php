<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class InscripcionModel extends Model
{
    protected $table            = 'inscripcions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_alumno',
        'id_materia',
        'horario_id',
        'fecha_inscripcion',
    ];

    public function existeInscripcion(int $alumnoId, int $horarioId, ?int $excluirId = null): bool
    {
        $builder = $this->where('id_alumno', $alumnoId)->where('horario_id', $horarioId);

        if ($excluirId !== null) {
            $builder->where($this->primaryKey . ' !=', $excluirId);
        }

        return (bool) $builder->first();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listarConDetalles(): array
    {
        return $this->db->table($this->table . ' i')
            ->select('i.id, i.horario_id, i.id_alumno, a.codigo, a.nombre, a.apellido, m.nombre_materia, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, h.dia, h.hora_inicio, h.hora_fin')
            ->join('alumnos a', 'a.id = i.id_alumno')
            ->join('horarios h', 'h.id = i.horario_id', 'left')
            ->join('materias m', 'm.id_materia = COALESCE(i.id_materia, h.id_materia)', 'left')
            ->join('docentes d', 'd.id = h.id_docente', 'left')
            ->orderBy('m.nombre_materia', 'ASC')
            ->orderBy('d.nombre', 'ASC')
            ->orderBy('h.dia', 'ASC')
            ->orderBy('h.hora_inicio', 'ASC')
            ->orderBy('a.apellido', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function obtenerAlumnosPorMateria(int $idMateria): array
    {
        return $this->db->table($this->table . ' i')
            ->distinct()
            ->select('a.id, a.foto, a.codigo, a.nombre, a.apellido, a.telefono, a.email')
            ->join('alumnos a', 'a.id = i.id_alumno')
            ->join('horarios h', 'h.id = i.horario_id', 'left')
            ->groupStart()
            ->where('i.id_materia', $idMateria)
            ->orWhere('h.id_materia', $idMateria)
            ->groupEnd()
            ->groupBy('a.id')
            ->orderBy('a.apellido', 'ASC')
            ->get()
            ->getResultArray();
    }
}