<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixHorariosDocentesSchema extends Migration
{
    public function up()
    {
        // Agregar id_docente a tabla horarios
        $fields = [
            'id_docente' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'id',
            ],
        ];
        
        $this->forge->addColumn('horarios', $fields);

        // Agregar foreign key constraint para id_docente en horarios
        // Primero eliminamos la llave primaria temporalmente si es necesario
        $this->db->disableForeignKeyChecks();
        
        // Agregar foreign key manualmente usando SQL
        $this->db->query('ALTER TABLE horarios ADD CONSTRAINT fk_horarios_docentes 
                         FOREIGN KEY (id_docente) REFERENCES docentes(id) ON DELETE CASCADE');
        
        // Agregar foreign key para id_materia en horarios también
        $this->db->query('ALTER TABLE horarios ADD CONSTRAINT fk_horarios_materias 
                         FOREIGN KEY (id_materia) REFERENCES materias(id_materia) ON DELETE CASCADE');
        
        $this->db->enableForeignKeyChecks();

        // Agregar horario_id a tabla inscripcions si no existe
        // y mantener id_materia por compatibilidad
        $fields2 = [
            'horario_id' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'id_materia',
            ],
        ];
        
        $this->forge->addColumn('inscripcions', $fields2);

        // Agregar foreign key para horario_id en inscripcions
        $this->db->disableForeignKeyChecks();
        
        $this->db->query('ALTER TABLE inscripcions ADD CONSTRAINT fk_inscripcions_horarios 
                         FOREIGN KEY (horario_id) REFERENCES horarios(id) ON DELETE CASCADE');
        
        $this->db->query('ALTER TABLE inscripcions ADD CONSTRAINT fk_inscripcions_alumnos 
                         FOREIGN KEY (id_alumno) REFERENCES alumnos(id) ON DELETE CASCADE');
        
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        
        // Eliminar foreign keys
        $this->db->query('ALTER TABLE horarios DROP FOREIGN KEY fk_horarios_docentes');
        $this->db->query('ALTER TABLE horarios DROP FOREIGN KEY fk_horarios_materias');
        $this->db->query('ALTER TABLE inscripcions DROP FOREIGN KEY fk_inscripcions_horarios');
        $this->db->query('ALTER TABLE inscripcions DROP FOREIGN KEY fk_inscripcions_alumnos');
        
        $this->db->enableForeignKeyChecks();
        
        // Eliminar columnas
        $this->forge->dropColumn('horarios', 'id_docente');
        $this->forge->dropColumn('inscripcions', 'horario_id');
    }
}
