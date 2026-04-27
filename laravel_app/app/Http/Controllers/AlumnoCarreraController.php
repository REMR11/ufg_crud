<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoCarrera\StoreAlumnoCarreraRequest;
use App\Http\Requests\AlumnoCarrera\UpdateAlumnoCarreraRequest;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Services\AlumnoCarreraService;
use Illuminate\Http\Request;

class AlumnoCarreraController extends Controller
{
    public function __construct(private readonly AlumnoCarreraService $service)
    {
    }

    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');
        $idCarrera = $request->query('id_carrera');

        $alumnoCarrera = AlumnoCarrera::query()
            ->with(['alumno', 'carrera'])
            ->when($search !== '', fn ($q) => $q->whereHas('alumno', fn ($a) => $a
                ->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('codigo', 'like', "%{$search}%")))
            ->when(!empty($idCarrera), fn ($q) => $q->where('id_carrera', (int) $idCarrera))
            ->get();

        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('alumno_carrera.index', compact('alumnoCarrera', 'carreras', 'search', 'idCarrera'));
    }

    public function create()
    {
        $alumnos = Alumno::orderBy('apellido')->get();
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('alumno_carrera.create', compact('alumnos', 'carreras'));
    }

    public function store(StoreAlumnoCarreraRequest $request)
    {
        $data = $request->validated();
        $this->service->ensureUniqueAssignment((int) $data['id_alumno'], (int) $data['id_carrera']);
        AlumnoCarrera::create($data);
        return redirect()->route('alumno_carrera.index')->with('success', 'Asignación creada exitosamente.');
    }

    public function show(AlumnoCarrera $alumno_carrera)
    {
        $asignacion = $alumno_carrera->load(['alumno', 'carrera']);
        $otrasCarreras = AlumnoCarrera::with('carrera')->where('id_alumno', $asignacion->id_alumno)->get();
        return view('alumno_carrera.show', compact('asignacion', 'otrasCarreras'));
    }

    public function edit(AlumnoCarrera $alumno_carrera)
    {
        $asignacion = $alumno_carrera;
        $alumnos = Alumno::orderBy('apellido')->get();
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('alumno_carrera.edit', compact('asignacion', 'alumnos', 'carreras'));
    }

    public function update(UpdateAlumnoCarreraRequest $request, AlumnoCarrera $alumno_carrera)
    {
        $data = $request->validated();
        $this->service->ensureUniqueAssignment((int) $data['id_alumno'], (int) $data['id_carrera'], $alumno_carrera->id);
        $alumno_carrera->update($data);
        return redirect()->route('alumno_carrera.index')->with('success', 'Asignación actualizada exitosamente.');
    }

    public function destroy(AlumnoCarrera $alumno_carrera)
    {
        $alumno_carrera->delete();
        return redirect()->route('alumno_carrera.index')->with('success', 'Asignación eliminada exitosamente.');
    }
}
