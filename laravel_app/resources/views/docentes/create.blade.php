@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Crear Docente</h1>
<form method="post" action="{{ route('docentes.store') }}">@csrf @include('docentes.form') <button class="btn btn-primary">Guardar</button></form>
@endsection
