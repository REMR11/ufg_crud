@extends('layouts.main')
@section('title', 'Alumnos')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Alumnos</h1>
        <a class="btn btn-primary" href="{{ route('alumnos.create') }}">Nuevo</a>
    </div>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <input class="form-control" name="search" value="{{ $search }}" placeholder="Buscar por nombre, apellido, email o código">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
            <a class="btn btn-outline-secondary" href="{{ route('alumnos.index') }}">Limpiar</a>
        </div>
    </form>
    <table class="table table-bordered bg-white">
        <thead><tr><th>Codigo</th><th>Nombre</th><th>Email</th><th>Acciones</th></tr></thead>
        <tbody>
        @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->codigo }}</td>
                <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                <td>{{ $alumno->email }}</td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="{{ route('alumnos.show', $alumno) }}">Ver</a>
                    <a class="btn btn-sm btn-warning" href="{{ route('alumnos.edit', $alumno) }}">Editar</a>
                    <form method="post" action="{{ route('alumnos.destroy', $alumno) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
