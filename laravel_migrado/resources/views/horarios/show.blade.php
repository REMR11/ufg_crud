@extends('layouts.main')
@section('content')
<ul class="list-group">
<li class="list-group-item"><strong>Docente:</strong> {{ $horario->docente->nombre ?? '' }} {{ $horario->docente->apellido ?? '' }}</li>
<li class="list-group-item"><strong>Materia:</strong> {{ $horario->materia->nombre_materia ?? '' }}</li>
<li class="list-group-item"><strong>Dia:</strong> {{ $horario->dia }}</li>
<li class="list-group-item"><strong>Bloque:</strong> {{ $horario->bloque }}</li>
<li class="list-group-item"><strong>Hora:</strong> {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</li>
<li class="list-group-item"><strong>Total materias docente:</strong> {{ $totalMaterias }}</li>
</ul>
@endsection
