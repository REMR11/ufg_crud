@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Crear Carrera</h1>
<form method="post" action="{{ route('carreras.store') }}">@csrf @include('carreras.form') <button class="btn btn-primary">Guardar</button></form>
@endsection
