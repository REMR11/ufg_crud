# Estrategia Frontend: Portado a Blade

Conclusion: la estrategia recomendada es **Laravel + Blade** para maximizar reutilizacion del frontend actual.

## Activos reutilizables

- Layout principal:
  - `app/Views/layouts/main.php`
- Vistas CRUD:
  - `app/Views/alumnos/*`
  - `app/Views/docentes/*`
  - `app/Views/carreras/*`
  - `app/Views/horarios/*`
  - `app/Views/alumno_carrera/*`
  - `app/Views/materias/*`
- JavaScript utilitario:
  - `public/js/form-validation.js`

## Portado tecnico CI4 -> Blade

1. `renderSection('content')` -> `@yield('content')`
2. `extend('layouts/main')` -> `@extends('layouts.main')`
3. `base_url('ruta')` -> `route('nombre.ruta')` o `url('ruta')`
4. `csrf_field()` -> `@csrf`
5. mensajes flash CI4 -> `session('success')` / `session('error')`
6. errores de validacion -> `$errors` de Laravel

## Plan por fases (frontend)

### Fase A: Compatibilidad visual
- migrar layout y estilos
- mantener Bootstrap 5 + DataTables
- conservar estructura HTML actual

### Fase B: Formularios y mensajes
- reemplazar helpers de CI4
- migrar validacion servidor + repoblado `old()`
- adaptar confirmaciones de borrado con method spoofing

### Fase C: Limpieza
- extraer parciales Blade para tablas, alertas y formularios
- evaluar mover assets a Vite si se desea build moderno

## Riesgos frontend y mitigacion

- Riesgo: dependencia a rutas hardcodeadas.
  - Mitigacion: usar nombres de ruta (`route()`).
- Riesgo: borrado por enlace GET.
  - Mitigacion: formularios `POST` + `@method('DELETE')`.
- Riesgo: diferencias en manejo de errores.
  - Mitigacion: un componente Blade unico para errores/flash.
