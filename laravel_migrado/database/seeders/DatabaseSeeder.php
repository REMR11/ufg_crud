<?php

namespace Database\Seeders;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@ufg.local',
            'password' => bcrypt('password'),
        ]);

        $materias = [
            'Programacion I',
            'Bases de Datos',
            'Estructuras de Datos',
            'Ingenieria de Software',
            'Sistemas Operativos',
        ];

        foreach ($materias as $nombre) {
            Materia::query()->firstOrCreate(['nombre_materia' => $nombre]);
        }
    }
}
