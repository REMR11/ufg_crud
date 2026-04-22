@extends('layouts.main')
@section('content')
<ul class="list-group">
    <li class="list-group-item">{{ $carrera->codigo_carrera }}</li>
    <li class="list-group-item">{{ $carrera->nombre_carrera }}</li>
</ul>
@endsection
