@extends('layouts.main')

@section('title', 'Detalle de inscripción')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Detalle de inscripción</h1>
        <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Alumno</dt>
                <dd class="col-sm-9">{{ $inscripcion->alumno?->apellido }}, {{ $inscripcion->alumno?->nombre }}</dd>

                <dt class="col-sm-3">Materia registrada</dt>
                <dd class="col-sm-9">{{ $inscripcion->materia?->nombre_materia ?? 'No especificada' }}</dd>

                <dt class="col-sm-3">Materia (fallback)</dt>
                <dd class="col-sm-9">{{ $inscripcion->horario?->materia?->nombre_materia ?? 'No disponible' }}</dd>

                <dt class="col-sm-3">Horario</dt>
                <dd class="col-sm-9">
                    @if($inscripcion->horario)
                        {{ $inscripcion->horario->dia }} {{ $inscripcion->horario->hora_inicio }} - {{ $inscripcion->horario->hora_fin }}
                    @else
                        Sin horario
                    @endif
                </dd>

                <dt class="col-sm-3">Fecha de inscripción</dt>
                <dd class="col-sm-9">
                    {{ optional($inscripcion->fecha_inscripcion)->format('Y-m-d H:i') ?? '-' }}
                </dd>
            </dl>
        </div>
    </div>
@endsection
