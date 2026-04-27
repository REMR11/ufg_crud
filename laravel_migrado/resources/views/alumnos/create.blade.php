@extends('layouts.main')
@section('title', 'Crear Alumno')
@section('content')
    <h1 class="h4 mb-3">Crear Alumno</h1>
    <form method="post" enctype="multipart/form-data" action="{{ route('alumnos.store') }}">
        @csrf
        @include('alumnos.form')
        <button class="btn btn-primary">Guardar</button>
    </form>
@endsection
