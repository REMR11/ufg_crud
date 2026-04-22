<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCarrerasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'codigo_carrera' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
                'null' => true,
            ],
            'nombre_carrera' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('carreras');
    }

    public function down()
    {
        $this->forge->dropTable('carreras');
    }
}
