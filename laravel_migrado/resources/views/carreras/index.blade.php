@extends('layouts.main')
@section('title', 'Carreras')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Carreras</h1>
        <a class="btn btn-primary" href="{{ route('carreras.create') }}">Nueva</a>
    </div>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <input
                name="search"
                class="form-control"
                placeholder="Buscar por codigo o nombre"
                value="{{ $search }}"
            >
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary">Buscar</button>
            <a class="btn btn-outline-secondary" href="{{ route('carreras.index') }}">Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carreras as $carrera)
                <tr>
                    <td>{{ $carrera->codigo_carrera }}</td>
                    <td>{{ $carrera->nombre_carrera }}</td>
                    <td class="d-flex gap-2">
                        <a class="btn btn-sm btn-info" href="{{ route('carreras.show', $carrera) }}">Ver</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('carreras.edit', $carrera) }}">Editar</a>
                        <form method="post" action="{{ route('carreras.destroy', $carrera) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar registro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No hay carreras registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
