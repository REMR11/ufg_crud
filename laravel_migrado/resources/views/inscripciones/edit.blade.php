@extends('layouts.main')

@section('title', 'Editar inscripción')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Editar inscripción</h1>
        <a class="btn btn-outline-secondary" href="{{ route('inscripciones.index') }}">Volver</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('inscripciones.update', $inscripcion) }}">
                @csrf
                @method('PUT')
                @include('inscripciones.form')
                <button class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@endsection
