@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Alumnos de {{ $materia->nombre_materia }}</h1>
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
