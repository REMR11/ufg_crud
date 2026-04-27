@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Materias</h1>
    <a class="btn btn-outline-primary" href="{{ route('inscripciones.index') }}">Ver inscripciones</a>
</div>
<ul class="list-group">
@foreach($materias as $materia)
    <li class="list-group-item d-flex justify-content-between">
        <span>{{ $materia->nombre_materia }}</span>
        <a class="btn btn-sm btn-secondary" href="{{ route('materias.alumnos', $materia) }}">Ver alumnos</a>
    </li>
@endforeach
</ul>
@endsection
