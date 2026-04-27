<?php

namespace App\Http\Controllers;

use App\Http\Requests\Docente\StoreDocenteRequest;
use App\Http\Requests\Docente\UpdateDocenteRequest;
use App\Models\Docente;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');
        $docentes = Docente::query()
            ->when($search !== '', function ($q) use ($search): void {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('apellido')
            ->get();
        return view('docentes.index', compact('docentes', 'search'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(StoreDocenteRequest $request)
    {
        Docente::create($request->validated());
        return redirect()->route('docentes.index')->with('success', 'Docente creado exitosamente.');
    }

    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        $docente->update($request->validated());
        return redirect()->route('docentes.index')->with('success', 'Docente actualizado exitosamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado exitosamente.');
    }
}
