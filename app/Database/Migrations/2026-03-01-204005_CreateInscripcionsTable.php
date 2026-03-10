<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInscripcionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_alumno' => [
                'type' => 'INT',
                'null' => true,
            ],
            'id_materia' => [
                'type' => 'INT',
                'null' => true,
            ],
            'fecha_inscripcion' => [
                'type' => 'TIMESTAMP',
                'default' => 'now()',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('inscripcions');
    }

    public function down()
    {
        $this->forge->dropTable('inscripcions');
    }
}
