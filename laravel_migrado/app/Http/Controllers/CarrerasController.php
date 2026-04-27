<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carrera\StoreCarreraRequest;
use App\Http\Requests\Carrera\UpdateCarreraRequest;
use App\Models\Carrera;
use Illuminate\Http\Request;

class CarrerasController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('search', '');
        $carreras = Carrera::query()
            ->when($search !== '', function ($q) use ($search): void {
                $q->where('codigo_carrera', 'like', "%{$search}%")
                    ->orWhere('nombre_carrera', 'like', "%{$search}%");
            })
            ->orderBy('nombre_carrera')
            ->get();
        return view('carreras.index', compact('carreras', 'search'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(StoreCarreraRequest $request)
    {
        Carrera::create($request->validated());
        return redirect()->route('carreras.index')->with('success', 'Carrera creada exitosamente.');
    }

    public function show(Carrera $carrera)
    {
        return view('carreras.show', compact('carrera'));
    }

    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    public function update(UpdateCarreraRequest $request, Carrera $carrera)
    {
        $carrera->update($request->validated());
        return redirect()->route('carreras.index')->with('success', 'Carrera actualizada exitosamente.');
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')->with('success', 'Carrera eliminada exitosamente.');
    }
}
