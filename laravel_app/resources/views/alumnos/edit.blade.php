@extends('layouts.main')
@section('title', 'Editar Alumno')
@section('content')
    <h1 class="h4 mb-3">Editar Alumno</h1>
    <form method="post" enctype="multipart/form-data" action="{{ route('alumnos.update', $alumno) }}">
        @csrf @method('PUT')
        @include('alumnos.form')
        <button class="btn btn-primary">Actualizar</button>
    </form>
@endsection
