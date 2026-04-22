@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Alumno-Carrera</h1><a class="btn btn-primary" href="{{ route('alumno_carrera.create') }}">Nueva</a></div>
<table class="table table-bordered bg-white">
@foreach($alumnoCarrera as $row)
<tr>
    <td>{{ $row->alumno->nombre ?? '' }} {{ $row->alumno->apellido ?? '' }}</td>
    <td>{{ $row->carrera->nombre_carrera ?? '' }}</td>
    <td class="d-flex gap-2"><a class="btn btn-sm btn-info" href="{{ route('alumno_carrera.show', $row) }}">Ver</a><a class="btn btn-sm btn-warning" href="{{ route('alumno_carrera.edit', $row) }}">Editar</a><form method="post" action="{{ route('alumno_carrera.destroy', $row) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
</tr>
@endforeach
</table>
@endsection
