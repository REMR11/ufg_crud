<div class="row g-3 mb-3">
    <div class="col-md-6"><label>Docente</label><select name="id_docente" class="form-select">@foreach($docentes as $docente)<option value="{{ $docente->id }}" @selected((string) old('id_docente', $horario->id_docente ?? '') === (string) $docente->id)>{{ $docente->nombre }} {{ $docente->apellido }}</option>@endforeach</select></div>
    <div class="col-md-6"><label>Materia</label><select name="id_materia" class="form-select">@foreach($materias as $materia)<option value="{{ $materia->id_materia }}" @selected((string) old('id_materia', $horario->id_materia ?? '') === (string) $materia->id_materia)>{{ $materia->nombre_materia }}</option>@endforeach</select></div>
    <div class="col-md-4"><label>Dia</label><select name="dia" class="form-select">@foreach(['lunes','martes','miercoles','jueves','viernes','sabado'] as $dia)<option value="{{ $dia }}" @selected(old('dia', $horario->dia ?? '') === $dia)>{{ ucfirst($dia) }}</option>@endforeach</select></div>
    <div class="col-md-4"><label>Hora inicio</label><input name="hora_inicio" type="time" class="form-control" value="{{ old('hora_inicio', $horario->hora_inicio ?? '') }}"></div>
    <div class="col-md-4"><label>Hora fin</label><input name="hora_fin" type="time" class="form-control" value="{{ old('hora_fin', $horario->hora_fin ?? '') }}"></div>
</div>
