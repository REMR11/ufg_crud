@extends('layouts.main')
@section('content')
<ul class="list-group">
    <li class="list-group-item">{{ $docente->nombre }} {{ $docente->apellido }}</li>
    <li class="list-group-item">{{ $docente->email }}</li>
    <li class="list-group-item">{{ $docente->telefono }}</li>
</ul>
@endsection
