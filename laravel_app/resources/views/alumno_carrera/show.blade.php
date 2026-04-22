@extends('layouts.main')
@section('content')
<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Alumno:</strong> {{ $asignacion->alumno->nombre ?? '' }} {{ $asignacion->alumno->apellido ?? '' }}</li>
    <li class="list-group-item"><strong>Carrera:</strong> {{ $asignacion->carrera->nombre_carrera ?? '' }}</li>
</ul>
<h2 class="h6">Otras carreras del alumno</h2>
<ul>
@foreach($otrasCarreras as $item)
    <li>{{ $item->carrera->nombre_carrera ?? '' }}</li>
@endforeach
</ul>
@endsection
