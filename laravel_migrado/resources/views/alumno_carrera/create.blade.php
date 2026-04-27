@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Asignar Alumno a Carrera</h1>
<form method="post" action="{{ route('alumno_carrera.store') }}">@csrf @include('alumno_carrera.form') <button class="btn btn-primary">Guardar</button></form>
@endsection
