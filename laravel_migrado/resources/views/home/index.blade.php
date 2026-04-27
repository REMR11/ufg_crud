@extends('layouts.main')

@section('title', 'Inicio')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h1 class="h4">Sistema Migrado a Laravel</h1>
            <p class="mb-0">Usa el menú para gestionar alumnos, docentes, carreras, horarios, inscripciones y asignaciones.</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Alumnos</h2>
                    <p class="display-6 mb-0">{{ $stats['alumnos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Docentes</h2>
                    <p class="display-6 mb-0">{{ $stats['docentes'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Carreras</h2>
                    <p class="display-6 mb-0">{{ $stats['carreras'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Horarios</h2>
                    <p class="display-6 mb-0">{{ $stats['horarios'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Inscripciones</h2>
                    <p class="display-6 mb-0">{{ $stats['inscripciones'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
