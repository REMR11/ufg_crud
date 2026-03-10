<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_materia' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nombre_materia' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
        ]);
        $this->forge->addPrimaryKey('id_materia');
        $this->forge->createTable('materias');
    }

    public function down()
    {
        $this->forge->dropTable('materias');
    }
}
