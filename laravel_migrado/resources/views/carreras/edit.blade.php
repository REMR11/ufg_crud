@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Editar Carrera</h1>
<form method="post" action="{{ route('carreras.update', $carrera) }}">@csrf @method('PUT') @include('carreras.form') <button class="btn btn-primary">Actualizar</button></form>
@endsection
