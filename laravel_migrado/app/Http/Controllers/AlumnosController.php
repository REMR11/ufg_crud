<?php

namespace App\Http\Controllers;

use App\Http\Requests\Alumno\StoreAlumnoRequest;
use App\Http\Requests\Alumno\UpdateAlumnoRequest;
use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');
        $alumnos = Alumno::query()
            ->when($search !== '', function ($q) use ($search): void {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%");
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('alumnos.index', compact('alumnos', 'search'));
    }

    public function create()
    {
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('alumnos.create', compact('carreras'));
    }

    public function store(StoreAlumnoRequest $request)
    {
        $data = $request->validated();
        Alumno::create($data);
        return redirect()->route('alumnos.index')->with('success', 'Alumno creado exitosamente.');
    }

    public function show(Alumno $alumno)
    {
        $carrera = Carrera::find($alumno->codigo_carrera);
        return view('alumnos.show', compact('alumno', 'carrera'));
    }

    public function edit(Alumno $alumno)
    {
        $carreras = Carrera::orderBy('nombre_carrera')->get();
        return view('alumnos.edit', compact('alumno', 'carreras'));
    }

    public function update(UpdateAlumnoRequest $request, Alumno $alumno)
    {
        $data = $request->validated();
        $alumno->update($data);
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado exitosamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado exitosamente.');
    }
}
