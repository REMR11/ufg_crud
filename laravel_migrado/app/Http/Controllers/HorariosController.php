<?php

namespace App\Http\Controllers;

use App\Http\Requests\Horario\StoreHorarioRequest;
use App\Http\Requests\Horario\UpdateHorarioRequest;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Materia;
use App\Services\HorarioService;
use Illuminate\Http\Request;

class HorariosController extends Controller
{
    public function __construct(private readonly HorarioService $service)
    {
    }

    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');
        $filtroDocente = $request->query('filtro_docente');

        $horarios = Horario::query()
            ->with(['docente', 'materia'])
            ->when($search !== '', fn ($q) => $q->whereHas('materia', fn ($m) => $m->where('nombre_materia', 'like', "%{$search}%")))
            ->when(!empty($filtroDocente), fn ($q) => $q->where('id_docente', (int) $filtroDocente))
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $docentes = Docente::orderBy('nombre')->get();
        return view('horarios.index', compact('horarios', 'docentes', 'search', 'filtroDocente'));
    }

    public function create()
    {
        $docentes = Docente::orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre_materia')->get();
        return view('horarios.create', compact('docentes', 'materias'));
    }

    public function store(StoreHorarioRequest $request)
    {
        $data = $request->validated();
        $this->service->validateRules($data);
        $data['bloque'] = $this->service->resolveBloque($data['hora_inicio']);
        Horario::create($data);
        return redirect()->route('horarios.index')->with('success', 'Horario registrado exitosamente.');
    }

    public function show(Horario $horario)
    {
        $horario->load(['docente', 'materia']);
        $totalMaterias = Horario::where('id_docente', $horario->id_docente)->count();
        return view('horarios.show', compact('horario', 'totalMaterias'));
    }

    public function edit(Horario $horario)
    {
        $docentes = Docente::orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre_materia')->get();
        return view('horarios.edit', compact('horario', 'docentes', 'materias'));
    }

    public function update(UpdateHorarioRequest $request, Horario $horario)
    {
        $data = $request->validated();
        $this->service->validateRules($data, $horario->id);
        $data['bloque'] = $this->service->resolveBloque($data['hora_inicio']);
        $horario->update($data);
        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }

    public function materiasPorDocente(Docente $docente)
    {
        $horarios = Horario::query()->with('materia')->where('id_docente', $docente->id)->orderBy('dia')->get();
        return view('docentes.materias', compact('docente', 'horarios'));
    }
}
