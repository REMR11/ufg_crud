# Mapeo de Validaciones CI4 -> Laravel FormRequest/Rule

Fuente actual:
- `app/Config/Validation.php`
- `app/Validation/HorarioRules.php`
- `app/Validation/AlumnoCarreraRules.php`

## Estructura Laravel recomendada

- `app/Http/Requests/Alumno/StoreAlumnoRequest.php`
- `app/Http/Requests/Alumno/UpdateAlumnoRequest.php`
- `app/Http/Requests/Docente/StoreDocenteRequest.php`
- `app/Http/Requests/Docente/UpdateDocenteRequest.php`
- `app/Http/Requests/Carrera/StoreCarreraRequest.php`
- `app/Http/Requests/Carrera/UpdateCarreraRequest.php`
- `app/Http/Requests/Horario/StoreHorarioRequest.php`
- `app/Http/Requests/Horario/UpdateHorarioRequest.php`
- `app/Http/Requests/AlumnoCarrera/StoreAlumnoCarreraRequest.php`
- `app/Http/Requests/AlumnoCarrera/UpdateAlumnoCarreraRequest.php`

## Reglas base equivalentes

### Alumno

- `nombre`: `required|string|min:2|max:100`
- `apellido`: `required|string|min:2|max:100`
- `email`:
  - store: `required|email|max:100|unique:alumnos,email`
  - update: `required|email|max:100|unique:alumnos,email,{id}`
- `telefono`: `nullable|digits:8`
- `codigo`:
  - store: `required|alpha_num|max:20|unique:alumnos,codigo`
  - update: `required|alpha_num|max:20|unique:alumnos,codigo,{id}`
- `codigo_carrera`: `required|numeric`

### Docente

- `nombre`: `required|string|min:2|max:100`
- `apellido`: `required|string|min:2|max:100`
- `email`:
  - store: `required|email|max:100|unique:docentes,email`
  - update: `required|email|max:100|unique:docentes,email,{id}`
- `telefono`: `nullable|max:20`

### Carrera

- `codigo_carrera`:
  - store: `required|string|min:2|max:20|unique:carreras,codigo_carrera`
  - update: `required|string|min:2|max:20|unique:carreras,codigo_carrera,{id}`
- `nombre_carrera`:
  - store: `required|string|min:2|max:150|unique:carreras,nombre_carrera`
  - update: `required|string|min:2|max:150|unique:carreras,nombre_carrera,{id}`

### Horario

- `id_docente`: `required|integer|exists:docentes,id`
- `id_materia`: `required|integer|exists:materias,id_materia`
- `dia`: `required|in:lunes,martes,miercoles,jueves,viernes,sabado`
- `hora_inicio`: `required|date_format:H:i`
- `hora_fin`: `required|date_format:H:i`

### Alumno-Carrera

- `id_alumno`: `required|integer|exists:alumnos,id`
- `id_carrera`: `required|integer|exists:carreras,id`

## Reglas custom trasladadas

Las validaciones CI4 custom:
- `validDocente`
- `validMateria`
- `validAlumno`
- `validCarrera`

en Laravel se reemplazan por `Rule::exists(...)` o `exists:tabla,columna`.

## Reglas de negocio no deben vivir solo en FormRequest

Estas reglas deben validarse en servicio de dominio (`HorarioService`):

1. Duracion exacta de 2 horas.
2. Sin solapamiento de horario por docente y dia.
3. Maximo 5 materias por docente.
4. Misma materia permitida solo en dia distinto.

## Mensajes de error (i18n)

Definir mensajes en:
- `lang/es/validation.php`
- `messages()` dentro de cada FormRequest para los casos de negocio mas visibles.
