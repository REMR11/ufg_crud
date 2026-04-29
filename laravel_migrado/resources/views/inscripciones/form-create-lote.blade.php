<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Alumno</label>
        <select name="id_alumno" class="form-select" required>
            <option value="">Seleccione</option>
            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id }}" @selected((string) old('id_alumno') === (string) $alumno->id)>
                    {{ $alumno->apellido }}, {{ $alumno->nombre }} ({{ $alumno->codigo }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Fecha de inscripción (opcional)</label>
        <input
            type="datetime-local"
            name="fecha_inscripcion"
            class="form-control"
            value="{{ old('fecha_inscripcion') }}"
        >
    </div>
</div>

<p class="text-muted small mb-2">Puedes inscribir hasta 5 horarios a la vez. Completar solo las filas que uses.</p>

<div id="inscripcion-duplicados-client" class="alert alert-warning d-none mb-3" role="alert" aria-live="polite">
    No puedes repetir el mismo horario en más de una fila. Corrige las filas marcadas antes de guardar.
</div>

@for($i = 0; $i < 5; $i++)
    <div class="card border mb-3">
        <div class="card-body py-3">
            <h3 class="h6 card-title text-secondary mb-3">Materia {{ $i + 1 }} de 5</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Horario</label>
                    <select name="lineas[{{ $i }}][horario_id]" class="form-select inscripcion-linea-horario @error('lineas.'.$i.'.horario_id') is-invalid @enderror">
                        <option value="">Seleccione</option>
                        @foreach($horarios as $horario)
                            <option value="{{ $horario->id }}" @selected((string) old('lineas.'.$i.'.horario_id') === (string) $horario->id)>
                                {{ $horario->materia->nombre_materia ?? 'Sin materia' }} -
                                {{ $horario->docente->nombre ?? '' }} {{ $horario->docente->apellido ?? '' }} -
                                {{ ucfirst($horario->dia) }} {{ substr((string) $horario->hora_inicio, 0, 5) }} - {{ substr((string) $horario->hora_fin, 0, 5) }}
                            </option>
                        @endforeach
                    </select>
                    @error('lineas.'.$i.'.horario_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Materia (opcional)</label>
                    <select name="lineas[{{ $i }}][id_materia]" class="form-select @error('lineas.'.$i.'.id_materia') is-invalid @enderror">
                        <option value="">Usar la materia del horario</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id_materia }}" @selected((string) old('lineas.'.$i.'.id_materia') === (string) $materia->id_materia)>
                                {{ $materia->nombre_materia }}
                            </option>
                        @endforeach
                    </select>
                    @error('lineas.'.$i.'.id_materia')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endfor
@error('lineas')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
