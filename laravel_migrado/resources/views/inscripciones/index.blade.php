@extends('layouts.main')

@section('title', 'Inscripciones')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Inscripciones</h1>
        <a class="btn btn-primary" href="{{ route('inscripciones.create') }}">Nueva inscripción</a>
    </div>

    <form class="row g-2 mb-3" method="get" action="{{ route('inscripciones.index') }}">
        <div class="col-md-6">
            <input class="form-control" type="search" name="search" placeholder="Buscar por alumno, código o materia" value="{{ $search }}">
        </div>
        <div class="col-md-4">
            <select class="form-select" name="id_materia">
                <option value="">Todas las materias</option>
                @foreach($materias as $materia)
                    <option value="{{ $materia->id_materia }}" @selected((string) $idMateria === (string) $materia->id_materia)>
                        {{ $materia->nombre_materia }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered bg-white align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Horario</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->id }}</td>
                        <td>{{ trim(($inscripcion->nombre ?? '').' '.($inscripcion->apellido ?? '')) }}</td>
                        <td>{{ $inscripcion->nombre_materia ?? '-' }}</td>
                        <td>
                            @php
                                $docente = trim(($inscripcion->docente_nombre ?? '').' '.($inscripcion->docente_apellido ?? ''));
                            @endphp
                            {{ $docente !== '' ? $docente : '-' }}
                        </td>
                        <td>
                            @if($inscripcion->dia)
                                {{ ucfirst($inscripcion->dia) }} {{ substr((string) $inscripcion->hora_inicio, 0, 5) }} - {{ substr((string) $inscripcion->hora_fin, 0, 5) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ optional($inscripcion->fecha_inscripcion)->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a class="btn btn-sm btn-info" href="{{ route('inscripciones.show', $inscripcion->id) }}">Ver</a>
                                <a class="btn btn-sm btn-warning" href="{{ route('inscripciones.edit', $inscripcion->id) }}">Editar</a>
                                <form method="post" action="{{ route('inscripciones.destroy', $inscripcion->id) }}" onsubmit="return confirm('Eliminar inscripción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay inscripciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
