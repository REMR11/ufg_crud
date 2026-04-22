@extends('layouts.main')
@section('title', 'Docentes')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h4">Docentes</h1>
        <a class="btn btn-primary" href="{{ route('docentes.create') }}">Nuevo</a>
    </div>
    <table class="table table-bordered bg-white">
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
