@extends('layouts.main')
@section('content')
<h1 class="h4 mb-3">Editar Docente</h1>
<form method="post" action="{{ route('docentes.update', $docente) }}">@csrf @method('PUT') @include('docentes.form') <button class="btn btn-primary">Actualizar</button></form>
@endsection
