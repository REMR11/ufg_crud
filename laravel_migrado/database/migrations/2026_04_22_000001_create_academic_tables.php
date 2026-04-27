<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table): void {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('codigo', 20)->unique();
            $table->string('codigo_carrera', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('docentes', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('carreras', function (Blueprint $table): void {
            $table->id();
            $table->string('codigo_carrera', 20)->unique()->nullable();
            $table->string('nombre_carrera', 150)->unique();
            $table->timestamps();
        });
                
        Schema::create('materias', function (Blueprint $table): void {
            $table->increments('id_materia');
            $table->string('nombre_materia', 150);
        });

        Schema::create('horarios', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_docente')->nullable()->constrained('docentes')->cascadeOnDelete();
            $table->unsignedInteger('id_materia')->nullable();
            $table->string('dia', 20);
            $table->string('bloque', 20)->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->foreign('id_materia')->references('id_materia')->on('materias')->cascadeOnDelete();
        });

        Schema::create('inscripcions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_alumno')->nullable()->constrained('alumnos')->cascadeOnDelete();
            $table->unsignedInteger('id_materia')->nullable();
            $table->foreignId('horario_id')->nullable()->constrained('horarios')->cascadeOnDelete();
            $table->timestamp('fecha_inscripcion')->useCurrent();
            $table->unique(['id_alumno', 'horario_id']);
        });

        Schema::create('alumno_carrera', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_alumno')->nullable()->constrained('alumnos')->cascadeOnDelete();
            $table->foreignId('id_carrera')->nullable()->constrained('carreras')->cascadeOnDelete();
            $table->unique(['id_alumno', 'id_carrera']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumno_carrera');
        Schema::dropIfExists('inscripcions');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('carreras');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('alumnos');
    }
};
