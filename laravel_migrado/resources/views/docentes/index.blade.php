@extends('layouts.main')
@section('title', 'Docentes')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Docentes</h1>
        <a class="btn btn-primary" href="{{ route('docentes.create') }}">Nuevo</a>
    </div>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, apellido o email" value="{{ $search ?? '' }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-primary">Buscar</button>
            <a class="btn btn-outline-secondary" href="{{ route('docentes.index') }}">Limpiar</a>
        </div>
    </form>
    <table class="table table-bordered bg-white">
        <thead>
        <tr>
            <th>Docente</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        </thead>
        @foreach($docentes as $docente)
            <tr>
                <td>{{ $docente->nombre }} {{ $docente->apellido }}</td>
                <td>{{ $docente->email }}</td>
                <td class="d-flex gap-2">
                    <a class="btn btn-sm btn-info" href="{{ route('docentes.show', $docente) }}">Ver</a>
                    <a class="btn btn-sm btn-warning" href="{{ route('docentes.edit', $docente) }}">Editar</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route('docentes.materias', $docente) }}">Materias</a>
                    <form method="post" action="{{ route('docentes.destroy', $docente) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar</button></form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
