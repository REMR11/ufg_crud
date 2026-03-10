<?php

namespace App\Models;

use CodeIgniter\Model;

class Alumno_carreraModel extends Model
{
    protected $table = 'alumno_carrera';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_alumno', 'id_carrera'];

    /**
     * Obtener todos los registros alumno_carrera con información de alumnos y carreras
     */
    public function getAlumnoCarreraWithDetails($search = '', $idCarrera = null)
    {
        $query = $this->db->table('alumno_carrera ac')
                ->select('ac.id, a.id as id_alumno, a.nombre, a.apellido, a.email, a.codigo, c.id as id_carrera, c.nombre_carrera')
                ->join('alumnos a', 'a.id = ac.id_alumno')
                ->join('carreras c', 'c.id = ac.id_carrera');

        if (!empty($search)) {
            $query->like('a.nombre', $search)
                  ->orLike('a.apellido', $search)
                  ->orLike('a.email', $search)
                  ->orLike('a.codigo', $search);
        }

        if (!empty($idCarrera)) {
            $query->where('c.id', $idCarrera);
        }

        return $query->get()->getResult('array');
    }

    /**
     * Obtener alumnos por carrera con detalles
     */
    public function getAlumnosByCarrera($idCarrera)
    {
        return $this->db->table('alumno_carrera ac')
                ->select('ac.id, a.id as id_alumno, a.nombre, a.apellido, a.email, a.telefono, a.codigo, c.nombre_carrera')
                ->join('alumnos a', 'a.id = ac.id_alumno')
                ->join('carreras c', 'c.id = ac.id_carrera')
                ->where('ac.id_carrera', $idCarrera)
                ->get()
                ->getResult('array');
    }

    /**
     * Obtener carreras de un alumno
     */
    public function getCarrerasByAlumno($idAlumno)
    {
        return $this->db->table('alumno_carrera ac')
                ->select('ac.id, c.id as id_carrera, c.codigo_carrera, c.nombre_carrera')
                ->join('carreras c', 'c.id = ac.id_carrera')
                ->where('ac.id_alumno', $idAlumno)
                ->get()
                ->getResult('array');
    }

    /**
     * Verificar si ya existe una asignación alumno-carrera
     */
    public function existsAssignment($idAlumno, $idCarrera, $excludeId = null)
    {
        $query = $this->db->table('alumno_carrera')
                ->where('id_alumno', $idAlumno)
                ->where('id_carrera', $idCarrera);

        if (!empty($excludeId)) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Obtener detalle de una asignación
     */
    public function getDetail($id)
    {
        return $this->db->table('alumno_carrera ac')
                ->select('ac.id, a.id as id_alumno, a.nombre, a.apellido, a.email, a.codigo, c.id as id_carrera, c.codigo_carrera, c.nombre_carrera')
                ->join('alumnos a', 'a.id = ac.id_alumno')
                ->join('carreras c', 'c.id = ac.id_carrera')
                ->where('ac.id', $id)
                ->get()
                ->getRowArray();
    }
}
