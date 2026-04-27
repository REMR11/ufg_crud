@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Carreras</h1><a class="btn btn-primary" href="{{ route('carreras.create') }}">Nueva</a></div>
<table class="table table-bordered bg-white">
@foreach($carreras as $carrera)
<tr>
<td>{{ $carrera->codigo_carrera }}</td><td>{{ $carrera->nombre_carrera }}</td>
<td class="d-flex gap-2"><a class="btn btn-sm btn-info" href="{{ route('carreras.show', $carrera) }}">Ver</a><a class="btn btn-sm btn-warning" href="{{ route('carreras.edit', $carrera) }}">Editar</a><form method="post" action="{{ route('carreras.destroy', $carrera) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
</tr>
@endforeach
</table>
@endsection
