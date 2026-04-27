@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Crear Horario</h1>
<form method="post" action="{{ route('horarios.store') }}">@csrf @include('horarios.form') <button class="btn btn-primary">Guardar</button></form>
@endsection
