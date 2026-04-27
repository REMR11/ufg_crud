@extends('layouts.main')

@section('title', 'Nueva inscripción')

@section('content')
    <h1 class="h4 mb-3">Registrar inscripción</h1>
    <form method="post" action="{{ route('inscripciones.store') }}">
        @csrf
        @include('inscripciones.form')
        <button class="btn btn-primary">Guardar</button>
    </form>
@endsection
