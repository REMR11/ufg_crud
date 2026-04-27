@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Editar Horario</h1>
<form method="post" action="{{ route('horarios.update', $horario) }}">@csrf @method('PUT') @include('horarios.form') <button class="btn btn-primary">Actualizar</button></form>
@endsection
