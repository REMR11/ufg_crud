# Modelo Eloquent Objetivo (equivalencia CI4)

## Convenciones y excepciones

- Tabla legacy `inscripcions` se mantiene para evitar ruptura de datos existentes.
- `materias` usa llave primaria no estandar: `id_materia`.
- `alumnos.codigo_carrera` existe como campo legacy; se recomienda migrar gradualmente a `id_carrera`.

## Matriz CI4 -> Laravel Model

| CI4 Model | Tabla | PK actual | Laravel Model objetivo | Notas |
| --- | --- | --- | --- | --- |
| `AlumnosModel` | `alumnos` | `id` | `Alumno` | incluir `foto`; evaluar renombrar `codigo_carrera` |
| `DocenteModel` | `docentes` | `id` | `Docente` | relacion con horarios |
| `CarreraModel` | `carreras` | `id` | `Carrera` | relacion con alumnos y pivot |
| `MateriaModel` | `materias` | `id_materia` | `Materia` | definir `$primaryKey = 'id_materia'` |
| `HorarioModel` | `horarios` | `id` | `Horario` | reglas en servicio de dominio |
| `InscripcionModel` | `inscripcions` | `id` | `Inscripcion` | definir `$table = 'inscripcions'` |
| `Alumno_carreraModel` | `alumno_carrera` | `id` | `AlumnoCarrera` | puede operar como pivot enriquecido |

## Relaciones Laravel recomendadas

- `Docente`:
  - `hasMany(Horario::class, 'id_docente')`
- `Materia`:
  - `hasMany(Horario::class, 'id_materia', 'id_materia')`
  - `hasMany(Inscripcion::class, 'id_materia', 'id_materia')`
- `Horario`:
  - `belongsTo(Docente::class, 'id_docente')`
  - `belongsTo(Materia::class, 'id_materia', 'id_materia')`
  - `hasMany(Inscripcion::class, 'horario_id')`
- `Alumno`:
  - `belongsToMany(Carrera::class, 'alumno_carrera', 'id_alumno', 'id_carrera')`
  - `hasMany(Inscripcion::class, 'id_alumno')`
- `Carrera`:
  - `belongsToMany(Alumno::class, 'alumno_carrera', 'id_carrera', 'id_alumno')`
- `Inscripcion`:
  - `belongsTo(Alumno::class, 'id_alumno')`
  - `belongsTo(Horario::class, 'horario_id')`
  - `belongsTo(Materia::class, 'id_materia', 'id_materia')`

## Scopes y consultas reutilizables

Migrar consultas complejas a scopes o query objects:

- Horarios:
  - listado con docente + materia + orden por dia/hora
  - listados por docente
- Inscripciones:
  - listado con joins alumno/materia/docente/horario
  - alumnos por materia con fallback de `id_materia`
- Alumno-Carrera:
  - filtros por texto y carrera
  - detalle con joins para vista de lectura

## Migraciones Laravel sugeridas (sin ejecutar aun)

1. Reproducir tablas actuales para paridad funcional.
2. Agregar constraints faltantes:
   - FK `alumno_carrera.id_alumno -> alumnos.id`
   - FK `alumno_carrera.id_carrera -> carreras.id`
3. Agregar uniques compuestos:
   - `alumno_carrera(id_alumno, id_carrera)`
   - opcional `inscripcions(id_alumno, horario_id)` segun negocio.
4. Plan de normalizacion opcional:
   - deprecacion gradual de `alumnos.codigo_carrera` hacia `alumnos.id_carrera`.
