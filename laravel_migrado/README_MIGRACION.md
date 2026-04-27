# Migracion funcional CI4 -> Laravel

Este proyecto contiene una migracion funcional del sistema original CodeIgniter 4 hacia Laravel, implementada en la subcarpeta `laravel_migrado`.

## Cobertura implementada

- Modelos Eloquent equivalentes al legado:
  - `Alumno`, `Docente`, `Carrera`, `Materia`, `Horario`, `Inscripcion`, `AlumnoCarrera`
- Reglas de negocio migradas:
  - Servicio `HorarioService` con reglas:
    - duracion exacta 2 horas
    - no solapamiento docente/dia
    - maximo 5 materias por docente
    - materia repetida solo en dia distinto
  - Servicio `AlumnoCarreraService` con unicidad alumno-carrera
- Validaciones con `FormRequest`:
  - `Alumno`, `Docente`, `Carrera`, `Horario`, `AlumnoCarrera`, `Inscripcion`
- Rutas REST:
  - `Route::resource(...)` para todos los CRUD principales
  - eliminacion por `DELETE` y actualizacion por `PUT/PATCH`
- Frontend Blade reutilizando vistas del proyecto previo:
  - `resources/views/{alumnos,docentes,carreras,horarios,inscripciones,alumno_carrera,materias}`
- Hardening obligatorio aplicado:
  - almacenamiento de foto via `Storage` (disco `public`)
  - autenticacion base (login/logout) y proteccion de rutas con `auth`
  - constraints/fks y unique compuesto en migraciones
- i18n:
  - mensajes de validacion en `lang/es/validation.php`
- Pruebas de feature:
  - reglas criticas de horarios
  - humo de CRUD con usuario autenticado
  - inscripciones (duplicados y fallback de materia)

## Requisitos

- PHP 8.3+
- Composer 2+
- Extensiones PHP necesarias para Laravel (pdo, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo, etc.)

## Configuracion

1. Entrar al proyecto:
   - `cd laravel_migrado`
2. Instalar dependencias:
   - `composer install`
3. Preparar entorno:
   - `cp .env.example .env`
   - `php artisan key:generate`
4. Migrar y sembrar:
   - `php artisan migrate --seed`
5. Enlace para storage publico (fotos):
   - `php artisan storage:link`
6. Ejecutar aplicacion:
   - `php artisan serve`

## Usuario inicial

Seeder por defecto:

- Email: `admin@ufg.local`
- Password: `password`

## Pruebas

- `php artisan test`

## Notas de paridad legacy

- Se conserva la tabla `inscripcions` por compatibilidad historica.
- `materias` mantiene PK legacy `id_materia`.
- `alumnos.codigo_carrera` se preserva como campo legado.
