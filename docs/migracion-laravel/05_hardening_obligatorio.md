# Hardening Obligatorio en la Migracion a Laravel

Este checklist recoge ajustes que deben aplicarse durante la migracion para evitar riesgos funcionales y de seguridad.

## 1) Metodos HTTP y rutas REST

Problema actual:
- se usan endpoints de borrado por `GET` (ejemplo: `/alumnos/delete/{id}`).

Accion obligatoria:
- migrar a `Route::resource(...)` y usar:
  - `DELETE /recurso/{id}` para eliminar
  - `PUT/PATCH /recurso/{id}` para actualizar

Impacto en vistas:
- reemplazar enlaces de borrado por formulario:
  - `@csrf`
  - `@method('DELETE')`

## 2) Almacenamiento de archivos (foto de alumno)

Problema actual:
- guardado manual en `public/uploads` y borrado manual con `unlink`.

Accion obligatoria:
- migrar a `Storage` de Laravel (disco `public`).
- usar `store()` / `storeAs()` y `Storage::disk('public')->delete(...)`.
- publicar enlace simbolico con `php artisan storage:link`.

Reglas de validacion sugeridas:
- `image|mimes:jpg,jpeg,png,webp|max:2048`

## 3) Autenticacion y autorizacion base

Problema actual:
- no existe modulo de autenticacion/autorizacion.

Accion obligatoria:
- instalar Laravel Breeze (base recomendada por simplicidad).
- proteger rutas CRUD con middleware `auth`.
- definir politicas por recurso si hay perfiles (admin, docente, etc.).

## 4) Integridad de datos y constraints

Acciones obligatorias:
- revisar y consolidar FKs en migraciones Laravel:
  - `horarios.id_docente -> docentes.id`
  - `horarios.id_materia -> materias.id_materia`
  - `inscripcions.horario_id -> horarios.id`
  - `inscripcions.id_alumno -> alumnos.id`
- agregar unique compuesto:
  - `alumno_carrera(id_alumno, id_carrera)`
- mantener naming legacy cuando sea necesario (`inscripcions`) y documentarlo.

## 5) Observabilidad y calidad minima

Acciones obligatorias:
- agregar pruebas de feature para CRUD principal.
- agregar pruebas de reglas de negocio de horarios:
  - duracion 2h
  - no solapamiento
  - maximo 5 materias
  - materia repetida solo en dia distinto
- registrar errores de validacion y excepciones en logs de Laravel.

## Orden recomendado de ejecucion

1. Migraciones y constraints Laravel.
2. Modelos Eloquent y relaciones.
3. FormRequests + servicios de dominio.
4. Controladores resource + rutas REST.
5. Portado de vistas Blade.
6. Storage, auth y pruebas.
