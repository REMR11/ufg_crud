@extends('layouts.main')

@section('title', 'Alumno-Carrera')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Alumno-Carrera</h1>
        <a class="btn btn-primary" href="{{ route('alumno_carrera.create') }}">Nueva</a>
    </div>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-8">
            <input class="form-control" name="search" value="{{ $search ?? '' }}" placeholder="Buscar alumno por nombre, correo o código">
        </div>
        <div class="col-md-4">
            <select class="form-select" name="id_carrera">
                <option value="">Todas las carreras</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" @selected((string) ($idCarrera ?? '') === (string) $carrera->id)>
                        {{ $carrera->nombre_carrera }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <table class="table table-bordered bg-white align-middle">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Carrera</th>
                <th style="width: 220px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alumnoCarrera as $row)
                <tr>
                    <td>{{ $row->alumno->nombre ?? '' }} {{ $row->alumno->apellido ?? '' }}</td>
                    <td>{{ $row->carrera->nombre_carrera ?? '' }}</td>
                    <td class="d-flex gap-2">
                        <a class="btn btn-sm btn-info" href="{{ route('alumno_carrera.show', $row) }}">Ver</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('alumno_carrera.edit', $row) }}">Editar</a>
                        <form method="post" action="{{ route('alumno_carrera.destroy', $row) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar asignación?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No hay asignaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
