@extends('layouts.main')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Horarios</h1><a class="btn btn-primary" href="{{ route('horarios.create') }}">Nuevo</a></div>
<table class="table table-bordered bg-white">
    <thead><tr><th>Docente</th><th>Materia</th><th>Dia</th><th>Hora</th><th></th></tr></thead>
    @foreach($horarios as $horario)
    <tr>
        <td>{{ $horario->docente->nombre ?? '' }} {{ $horario->docente->apellido ?? '' }}</td>
        <td>{{ $horario->materia->nombre_materia ?? '' }}</td>
        <td>{{ $horario->dia }}</td>
        <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
        <td class="d-flex gap-2"><a class="btn btn-sm btn-info" href="{{ route('horarios.show', $horario) }}">Ver</a><a class="btn btn-sm btn-warning" href="{{ route('horarios.edit', $horario) }}">Editar</a><form method="post" action="{{ route('horarios.destroy', $horario) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
    </tr>
    @endforeach
</table>
@endsection
