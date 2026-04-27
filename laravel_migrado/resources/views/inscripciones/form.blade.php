<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Alumno</label>
        <select name="id_alumno" class="form-select" required>
            <option value="">Seleccione</option>
            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id }}" @selected((string) old('id_alumno', $inscripcion->id_alumno ?? '') === (string) $alumno->id)>
                    {{ $alumno->apellido }}, {{ $alumno->nombre }} ({{ $alumno->codigo }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Horario</label>
        <select name="horario_id" class="form-select" required>
            <option value="">Seleccione</option>
            @foreach($horarios as $horario)
                <option value="{{ $horario->id }}" @selected((string) old('horario_id', $inscripcion->horario_id ?? '') === (string) $horario->id)>
                    {{ $horario->materia->nombre_materia ?? 'Sin materia' }} -
                    {{ $horario->docente->nombre ?? '' }} {{ $horario->docente->apellido ?? '' }} -
                    {{ ucfirst($horario->dia) }} {{ substr((string) $horario->hora_inicio, 0, 5) }} - {{ substr((string) $horario->hora_fin, 0, 5) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Materia (opcional)</label>
        <select name="id_materia" class="form-select">
            <option value="">Usar la materia del horario</option>
            @foreach($materias as $materia)
                <option value="{{ $materia->id_materia }}" @selected((string) old('id_materia', $inscripcion->id_materia ?? '') === (string) $materia->id_materia)>
                    {{ $materia->nombre_materia }}
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
            value="{{ old('fecha_inscripcion', isset($inscripcion?->fecha_inscripcion) ? \Illuminate\Support\Carbon::parse($inscripcion->fecha_inscripcion)->format('Y-m-d\TH:i') : '') }}"
        >
    </div>
</div>
