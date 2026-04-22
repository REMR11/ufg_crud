<div class="row g-3 mb-3">
    <div class="col-md-6"><label>Alumno</label><select name="id_alumno" class="form-select">@foreach($alumnos as $alumno)<option value="{{ $alumno->id }}" @selected((string) old('id_alumno', $asignacion->id_alumno ?? '') === (string) $alumno->id)>{{ $alumno->apellido }}, {{ $alumno->nombre }}</option>@endforeach</select></div>
    <div class="col-md-6"><label>Carrera</label><select name="id_carrera" class="form-select">@foreach($carreras as $carrera)<option value="{{ $carrera->id }}" @selected((string) old('id_carrera', $asignacion->id_carrera ?? '') === (string) $carrera->id)>{{ $carrera->nombre_carrera }}</option>@endforeach</select></div>
</div>
