@extends('layouts.main')
@section('title', 'Horarios')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Horarios</h1><a class="btn btn-primary" href="{{ route('horarios.create') }}">Nuevo</a></div>
<form method="get" class="row g-2 mb-3">
    <div class="col-md-4">
        <input name="search" class="form-control" value="{{ $search ?? '' }}" placeholder="Buscar por materia">
    </div>
    <div class="col-md-4">
        <select name="filtro_docente" class="form-select">
            <option value="">Todos los docentes</option>
            @foreach($docentes as $docente)
                <option value="{{ $docente->id }}" @selected((string) ($filtroDocente ?? '') === (string) $docente->id)>
                    {{ $docente->nombre }} {{ $docente->apellido }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 d-grid d-md-block">
        <button class="btn btn-outline-primary">Filtrar</button>
        <a class="btn btn-outline-secondary" href="{{ route('horarios.index') }}">Limpiar</a>
    </div>
</form>
<table class="table table-bordered bg-white">
    <thead><tr><th>Docente</th><th>Materia</th><th>Dia</th><th>Hora</th><th></th></tr></thead>
    <tbody>
    @forelse($horarios as $horario)
        <tr>
            <td>{{ $horario->docente->nombre ?? '' }} {{ $horario->docente->apellido ?? '' }}</td>
            <td>{{ $horario->materia->nombre_materia ?? '' }}</td>
            <td>{{ $horario->dia }}</td>
            <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
            <td class="d-flex gap-2"><a class="btn btn-sm btn-info" href="{{ route('horarios.show', $horario) }}">Ver</a><a class="btn btn-sm btn-warning" href="{{ route('horarios.edit', $horario) }}">Editar</a><form method="post" action="{{ route('horarios.destroy', $horario) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form></td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No hay horarios registrados.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
