@extends('layouts.main')
@section('title', 'Alumnos por Materia')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Alumnos de {{ $materia->nombre_materia }}</h1>
    <a href="{{ route('materias.index') }}" class="btn btn-outline-secondary">Volver</a>
</div>
<table class="table table-bordered bg-white">
    <thead><tr><th>Codigo</th><th>Alumno</th><th>Email</th></tr></thead>
    <tbody>
    @foreach($inscripciones as $inscripcion)
        <tr>
            <td>{{ $inscripcion->alumno->codigo ?? '' }}</td>
            <td>{{ $inscripcion->alumno->nombre ?? '' }} {{ $inscripcion->alumno->apellido ?? '' }}</td>
            <td>{{ $inscripcion->alumno->email ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
