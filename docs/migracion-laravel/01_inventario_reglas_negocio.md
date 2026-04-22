# Inventario de Reglas de Negocio (CI4 -> Laravel)

Este documento extrae las reglas de negocio actuales para migrarlas sin regresiones.

## Modulo Horarios (inscripcion docente-materia)

Fuente principal:
- `app/Controllers/Horario.php`
- `app/Models/HorarioModel.php`

Reglas detectadas:

1. Un horario debe tener docente, materia, dia y franja horaria valida.
2. La duracion debe ser exactamente 2 horas.
3. Un docente no puede tener solapamiento horario el mismo dia.
4. Un docente puede tener maximo 5 materias asignadas.
5. Un docente puede repetir materia solo en dia distinto.
6. El bloque se calcula automaticamente por hora de inicio:
   - antes de las 12:00 -> `matutino`
   - desde las 12:00 -> `vespertino`

## Modulo Alumno-Carrera

Fuente principal:
- `app/Controllers/AlumnoCarrera.php`
- `app/Models/Alumno_carreraModel.php`

Reglas detectadas:

1. `id_alumno` e `id_carrera` deben existir.
2. No se permite una asignacion duplicada alumno-carrera.
3. En actualizacion, se valida unicidad excluyendo el propio registro.

## Modulo Inscripciones

Fuente principal:
- `app/Models/InscripcionModel.php`

Reglas detectadas:

1. No se permite inscripcion duplicada para el mismo alumno y horario.
2. El listado usa fallback de materia:
   - primero `inscripcions.id_materia`
   - si es null, usa `horarios.id_materia`
3. Consultas de alumnos por materia consideran ambos caminos (`inscripcions` y `horarios`).

## Modulos CRUD base (Alumnos, Docentes, Carreras)

Fuentes principales:
- `app/Controllers/Alumnos.php`
- `app/Config/Validation.php`

Reglas detectadas:

1. Unicidad de `alumnos.email`, `alumnos.codigo`, `docentes.email`, `carreras.codigo_carrera`, `carreras.nombre_carrera`.
2. Telefono alumno opcional, formato numerico y largo esperado.
3. Gestion de foto de alumno:
   - mime permitido: jpg, jpeg, png, webp
   - tamano maximo: 2 MB
   - reemplazo elimina imagen anterior en update

## Recomendacion de migracion funcional

- Convertir reglas transversales de `HorarioModel` y `Alumno_carreraModel` en servicios de dominio Laravel.
- Mantener validaciones de entrada en `FormRequest`.
- Reforzar invariantes con constraints de base de datos donde aplique:
  - unique compuesto para `alumno_carrera (id_alumno, id_carrera)`
  - unique compuesto para `inscripcions (id_alumno, horario_id)` si el negocio lo requiere de forma estricta.
