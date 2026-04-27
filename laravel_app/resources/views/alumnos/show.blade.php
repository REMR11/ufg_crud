@extends('layouts.main')
@section('title', 'Detalle Alumno')
@section('content')
    <h1 class="h4">Detalle Alumno</h1>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nombre:</strong> {{ $alumno->nombre }} {{ $alumno->apellido }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $alumno->email }}</li>
        <li class="list-group-item"><strong>Telefono:</strong> {{ $alumno->telefono }}</li>
        <li class="list-group-item"><strong>Codigo:</strong> {{ $alumno->codigo }}</li>
        <li class="list-group-item"><strong>Carrera:</strong> {{ $carrera->nombre_carrera ?? 'N/A' }}</li>
    </ul>
@endsection
