@extends('layouts.main')
@section('content')
<h1 class="h4">Materias de {{ $docente->nombre }} {{ $docente->apellido }}</h1>
<table class="table table-bordered bg-white">
    <thead><tr><th>Materia</th><th>Dia</th><th>Hora</th></tr></thead>
    <tbody>
    @foreach($horarios as $horario)
        <tr>
            <td>{{ $horario->materia->nombre_materia ?? 'N/A' }}</td>
            <td>{{ $horario->dia }}</td>
            <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
