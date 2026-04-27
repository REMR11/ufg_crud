<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AlumnoCarreraController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CarrerasController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\MateriasController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('alumnos', AlumnosController::class);
    Route::resource('docentes', DocentesController::class);
    Route::resource('carreras', CarrerasController::class);
    Route::resource('horarios', HorariosController::class);
    Route::resource('inscripciones', InscripcionesController::class)
        ->parameters(['inscripciones' => 'inscripcion']);
    Route::resource('alumno_carrera', AlumnoCarreraController::class);

    Route::get('docentes/{docente}/materias', [HorariosController::class, 'materiasPorDocente'])
        ->name('docentes.materias');
    Route::get('materias', [MateriasController::class, 'index'])->name('materias.index');
    Route::get('materias/{materia}/alumnos', [MateriasController::class, 'alumnosPorMateria'])
        ->name('materias.alumnos');
});
