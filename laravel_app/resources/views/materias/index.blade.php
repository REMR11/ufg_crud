@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Materias</h1>
<ul class="list-group">
@foreach($materias as $materia)
    <li class="list-group-item d-flex justify-content-between">
        <span>{{ $materia->nombre_materia }}</span>
        <a class="btn btn-sm btn-secondary" href="{{ route('materias.alumnos', $materia) }}">Ver alumnos</a>
    </li>
@endforeach
</ul>
@endsection
