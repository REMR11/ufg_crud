<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inscripcion\StoreInscripcionRequest;
use App\Http\Requests\Inscripcion\UpdateInscripcionRequest;
use App\Models\Alumno;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InscripcionesController extends Controller
{
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
            ->when(!empty($idMateria), function ($query) use ($idMateria): void {
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
        $this->assertNoDuplicada((int) $data['id_alumno'], (int) $data['horario_id']);

        Inscripcion::query()->create($data);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción creada exitosamente.');
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

        $inscripcion->update($data);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada exitosamente.');
    }

    public function destroy(Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->delete();

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada exitosamente.');
    }

    private function assertNoDuplicada(int $idAlumno, int $horarioId, ?int $excludeId = null): void
    {
        $duplicada = Inscripcion::query()
            ->where('id_alumno', $idAlumno)
            ->where('horario_id', $horarioId)
            ->when($excludeId !== null, fn ($query) => $query->where('id', '!=', $excludeId))
            ->exists();

        if ($duplicada) {
            throw ValidationException::withMessages([
                'horario_id' => 'El alumno ya se encuentra inscrito en ese horario.',
            ]);
        }
    }
}
