<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlumnoCarreraTable extends Migration
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
            'id_carrera' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('alumno_carrera');
    }

    public function down()
    {
        $this->forge->dropTable('alumno_carrera');
    }
}
