@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Editar Asignacion</h1>
<form method="post" action="{{ route('alumno_carrera.update', $asignacion) }}">@csrf @method('PUT') @include('alumno_carrera.form') <button class="btn btn-primary">Actualizar</button></form>
@endsection
