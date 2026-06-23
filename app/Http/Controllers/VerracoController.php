<?php

namespace App\Http\Controllers;

use App\Models\Verraco;
use Illuminate\Http\Request;

class VerracoController extends Controller
{
    public function index()
    {
        $verracos = Verraco::orderBy('codigo')->paginate(10);
        return view('verracos.index', compact('verracos'));
    }

    public function create()
    {
        return view('verracos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:verracos,codigo',
            'nombre' => 'nullable|string|max:255',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'peso' => 'nullable|numeric|min:0',
            'procedencia' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        Verraco::create($request->all());

        return redirect()->route('verracos.index')
            ->with('success', 'Verraco ' . $request->codigo . ' registrado correctamente.');
    }

    public function show(Verraco $verraco)
    {
        return redirect()->route('verracos.edit', $verraco);
    }

    public function edit(Verraco $verraco)
    {
        return view('verracos.edit', compact('verraco'));
    }

    public function update(Request $request, Verraco $verraco)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:verracos,codigo,' . $verraco->id,
            'nombre' => 'nullable|string|max:255',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'peso' => 'nullable|numeric|min:0',
            'procedencia' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $verraco->update($request->all());

        return redirect()->route('verracos.index')
            ->with('success', 'Verraco ' . $verraco->codigo . ' actualizado.');
    }

    public function destroy(Verraco $verraco)
    {
        $verraco->delete();

        return redirect()->route('verracos.index')
            ->with('success', 'Verraco eliminado.');
    }
}
