<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD Sistema UFG')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-mortarboard"></i> Sistema UFG</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('docentes.index') }}">Docentes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('carreras.index') }}">Carreras</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('horarios.index') }}">Horarios</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('inscripciones.index') }}">Inscripciones</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('alumno_carrera.index') }}">Alumno-Carrera</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('materias.index') }}">Materias</a></li>
                <li class="nav-item ms-3">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-light" type="submit">Salir</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4 flex-grow-1">
    @include('partials.alerts')
    @yield('content')
</main>
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; 2026 CRUD Sistema UFG</small>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/form-validation.js') }}"></script>
</body>
</html>
