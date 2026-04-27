<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHorariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_materia' => [
                'type' => 'INT',
                'null' => true,
            ],
            'dia' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'hora_inicio' => [
                'type' => 'TIME',
            ],
            'hora_fin' => [
                'type' => 'TIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('horarios');
    }

    public function down()
    {
        $this->forge->dropTable('horarios');
    }
}
