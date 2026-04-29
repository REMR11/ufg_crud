<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inscripcion\StoreInscripcionRequest;
use App\Http\Requests\Inscripcion\UpdateInscripcionRequest;
use App\Models\Alumno;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Materia;
use App\Services\InscripcionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InscripcionesController extends Controller
{
    public function __construct(private readonly InscripcionService $inscripcionService) {}

    public function index(Request $request): View
    {
        $search = (string) $request->query('search', '');
        $idMateria = $request->query('id_materia');

        $inscripciones = Inscripcion::query()
            ->conDetalles()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested
                        ->where('a.nombre', 'like', "%{$search}%")
                        ->orWhere('a.apellido', 'like', "%{$search}%")
                        ->orWhere('a.codigo', 'like', "%{$search}%")
                        ->orWhere('m.nombre_materia', 'like', "%{$search}%");
                });
            })
            ->when(! empty($idMateria), function ($query) use ($idMateria): void {
                $query->where(function ($nested) use ($idMateria): void {
                    $nested
                        ->where('inscripcions.id_materia', (int) $idMateria)
                        ->orWhere('h.id_materia', (int) $idMateria);
                });
            })
            ->get();

        $materias = Materia::query()->orderBy('nombre_materia')->get();

        return view('inscripciones.index', compact('inscripciones', 'materias', 'search', 'idMateria'));
    }

    public function create(): View
    {
        $alumnos = Alumno::query()->orderBy('apellido')->orderBy('nombre')->get();
        $horarios = Horario::query()->with(['docente', 'materia'])->orderBy('dia')->orderBy('hora_inicio')->get();
        $materias = Materia::query()->orderBy('nombre_materia')->get();

        return view('inscripciones.create', compact('alumnos', 'horarios', 'materias'));
    }

    public function store(StoreInscripcionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $idAlumno = (int) $data['id_alumno'];
        $lineas = $data['lineas'];
        $horarioIds = array_map(fn (array $l): int => (int) $l['horario_id'], $lineas);

        foreach (array_values($lineas) as $i => $linea) {
            $this->assertNoDuplicada(
                $idAlumno,
                (int) $linea['horario_id'],
                null,
                "lineas.{$i}.horario_id"
            );
        }

        $this->inscripcionService->validarLoteInscripciones($idAlumno, $horarioIds);

        $fecha = $data['fecha_inscripcion'] ?? null;

        DB::transaction(function () use ($idAlumno, $lineas, $fecha): void {
            foreach ($lineas as $linea) {
                $mid = $linea['id_materia'] ?? null;
                $attrs = [
                    'id_alumno' => $idAlumno,
                    'horario_id' => (int) $linea['horario_id'],
                    'id_materia' => $mid !== null && $mid !== '' ? (int) $mid : null,
                ];
                if ($fecha !== null) {
                    $attrs['fecha_inscripcion'] = $fecha;
                }
                Inscripcion::query()->create($attrs);
            }
        });

        $n = count($lineas);
        $message = $n === 1
            ? 'Inscripción creada exitosamente.'
            : "Se registraron {$n} inscripciones correctamente.";

        return redirect()->route('inscripciones.index')->with('success', $message);
    }

    public function show(Inscripcion $inscripcion): View
    {
        $inscripcion->load(['alumno', 'horario.docente', 'horario.materia', 'materia']);

        $materia = $inscripcion->materia ?? $inscripcion->horario?->materia;

        return view('inscripciones.show', compact('inscripcion', 'materia'));
    }

    public function edit(Inscripcion $inscripcion): View
    {
        $alumnos = Alumno::query()->orderBy('apellido')->orderBy('nombre')->get();
        $horarios = Horario::query()->with(['docente', 'materia'])->orderBy('dia')->orderBy('hora_inicio')->get();
        $materias = Materia::query()->orderBy('nombre_materia')->get();

        return view('inscripciones.edit', compact('inscripcion', 'alumnos', 'horarios', 'materias'));
    }

    public function update(UpdateInscripcionRequest $request, Inscripcion $inscripcion): RedirectResponse
    {
        $data = $request->validated();
        $this->assertNoDuplicada((int) $data['id_alumno'], (int) $data['horario_id'], (int) $inscripcion->id);
        $this->inscripcionService->validarReglasAlumno(
            (int) $data['id_alumno'],
            (int) $data['horario_id'],
            (int) $inscripcion->id
        );

        $inscripcion->update($data);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada exitosamente.');
    }

    public function destroy(Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->delete();

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada exitosamente.');
    }

    private function assertNoDuplicada(
        int $idAlumno,
        int $horarioId,
        ?int $excludeId = null,
        string $errorKey = 'horario_id'
    ): void {
        $duplicada = Inscripcion::query()
            ->where('id_alumno', $idAlumno)
            ->where('horario_id', $horarioId)
            ->when($excludeId !== null, fn ($query) => $query->where('id', '!=', $excludeId))
            ->exists();

        if ($duplicada) {
            throw ValidationException::withMessages([
                $errorKey => 'El alumno ya se encuentra inscrito en ese horario.',
            ]);
        }
    }
}
