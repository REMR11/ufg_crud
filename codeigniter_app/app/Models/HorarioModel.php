<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $table            = 'horarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_docente',
        'id_materia',
        'dia',
        'bloque',
        'hora_inicio',
        'hora_fin',
    ];

    public function contarPorDocente(int $idDocente): int
    {
        return (int) $this->where('id_docente', $idDocente)->countAllResults();
    }

    public function existeHorario(
        int $idDocente,
        int $idMateria,
        string $dia,
        string $horaInicio,
        string $horaFin
    ): bool {
        return (bool) $this
            ->where('id_docente', $idDocente)
            ->where('id_materia', $idMateria)
            ->where('dia', $dia)
            ->where('hora_inicio', $horaInicio)
            ->where('hora_fin', $horaFin)
            ->first();
    }

    public function existeMateriaMismoDia(
        int $idDocente,
        int $idMateria,
        string $dia,
        ?int $horarioIdExcluir = null
    ): bool {
        $builder = $this
            ->where('id_docente', $idDocente)
            ->where('id_materia', $idMateria)
            ->where('dia', $dia);

        if ($horarioIdExcluir !== null) {
            $builder->where('id !=', $horarioIdExcluir);
        }

        return (bool) $builder->first();
    }

    public function obtenerBloquePorHora(string $horaInicio): string
    {
        $hora = strtotime($horaInicio);
        $medioDia = strtotime('12:00');

        if ($hora === false || $medioDia === false) {
            return 'matutino';
        }

        return $hora < $medioDia ? 'matutino' : 'vespertino';
    }

    /**
     * Contar cuántas materias tiene inscrito un docente
     */
    public function contarMateriasDocente(int $idDocente): int
    {
        return (int) $this
            ->where('id_docente', $idDocente)
            ->countAllResults();
    }

    /**
     * Validar que la duración sea exactamente 2 horas
     */
    public function validarDuracion2Horas(string $horaInicio, string $horaFin): bool
    {
        $inicio = strtotime($horaInicio);
        $fin = strtotime($horaFin);
        
        if ($inicio === false || $fin === false) {
            return false;
        }
        
        $diferencia = ($fin - $inicio) / 3600; // diferencia en horas
        return $diferencia === 2.0;
    }

    /**
     * Validar conflictos de horario para un docente
     * Verifica que no haya solapamiento en el mismo día
     */
    public function validarConflictoHorario(
        int $idDocente,
        string $dia,
        string $horaInicio,
        string $horaFin,
        ?int $horarioIdExcluir = null
    ): bool {
        $query = $this
            ->where('id_docente', $idDocente)
            ->where('dia', $dia);
        
        // Excluir el horario actual si se está editando
        if ($horarioIdExcluir !== null) {
            $query->where('id !=', $horarioIdExcluir);
        }
        
        $horariosExistentes = $query->findAll();
        
        $inicioNuevo = strtotime($horaInicio);
        $finNuevo = strtotime($horaFin);
        
        foreach ($horariosExistentes as $horario) {
            $inicioExistente = strtotime($horario['hora_inicio']);
            $finExistente = strtotime($horario['hora_fin']);
            
            // Verificar solapamiento
            // Hay solapamiento si: inicio_nuevo < fin_existente AND fin_nuevo > inicio_existente
            if ($inicioNuevo < $finExistente && $finNuevo > $inicioExistente) {
                return false; // Hay conflicto
            }
        }
        
        return true; // No hay conflicto
    }

    /**
     * Obtener todos los horarios de un docente con detalles
     */
    public function obtenerHorariosDocente(int $idDocente): array
    {
        return $this->db->table($this->table . ' h')
            ->select('h.id, h.id_docente, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, h.id_materia, m.nombre_materia, h.dia, h.bloque, h.hora_inicio, h.hora_fin')
            ->join('docentes d', 'd.id = h.id_docente')
            ->join('materias m', 'm.id_materia = h.id_materia')
            ->where('h.id_docente', $idDocente)
            ->orderBy('h.dia', 'ASC')
            ->orderBy('h.hora_inicio', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listarConDetalles(): array
    {
        return $this->db->table($this->table . ' h')
            ->select('h.id, h.id_docente, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, h.id_materia, m.nombre_materia, h.dia, h.bloque, h.hora_inicio, h.hora_fin')
            ->join('docentes d', 'd.id = h.id_docente')
            ->join('materias m', 'm.id_materia = h.id_materia')
            ->orderBy('d.nombre', 'ASC')
            ->orderBy('m.nombre_materia', 'ASC')
            ->orderBy('h.dia', 'ASC')
            ->orderBy('h.hora_inicio', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listarOpciones(): array
    {
        return $this->db->table($this->table . ' h')
            ->select('h.id, CONCAT(d.nombre, \' \', d.apellido) as nombre_docente, m.nombre_materia, h.dia, h.bloque, h.hora_inicio, h.hora_fin')
            ->join('docentes d', 'd.id = h.id_docente')
            ->join('materias m', 'm.id_materia = h.id_materia')
            ->orderBy('d.nombre', 'ASC')
            ->orderBy('m.nombre_materia', 'ASC')
            ->orderBy('h.dia', 'ASC')
            ->orderBy('h.hora_inicio', 'ASC')
            ->get()
            ->getResultArray();
    }
}