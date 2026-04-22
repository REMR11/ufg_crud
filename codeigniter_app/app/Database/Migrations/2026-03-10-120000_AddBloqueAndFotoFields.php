<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBloqueAndFotoFields extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('bloque', 'horarios')) {
            $this->forge->addColumn('horarios', [
                'bloque' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'dia',
                ],
            ]);
        }

        if (!$this->db->fieldExists('foto', 'alumnos')) {
            $this->forge->addColumn('alumnos', [
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'id',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('bloque', 'horarios')) {
            $this->forge->dropColumn('horarios', 'bloque');
        }

        if ($this->db->fieldExists('foto', 'alumnos')) {
            $this->forge->dropColumn('alumnos', 'foto');
        }
    }
}

