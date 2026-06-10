<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CerdaController extends Controller
{
    public function index(Request $request)
    {
        $query = Cerda::query();

        // Búsqueda por código o nombre
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro por raza
        if ($request->filled('raza')) {
            $query->where('raza', $request->input('raza'));
        }

        $cerdas = $query->orderBy('codigo')->paginate(10)->withQueryString();
        
        $razas = Cerda::distinct()->whereNotNull('raza')->pluck('raza');

        return view('cerdas.index', compact('cerdas', 'razas'));
    }

    public function create()
    {
        return view('cerdas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cerdas,codigo',
            'nombre' => 'nullable|string|max:100',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'peso_actual' => 'nullable|numeric|min:0',
            'estado' => 'required|in:activa,gestante,lactante,en_celo,descarte',
            'notas' => 'nullable|string',
        ]);

        Cerda::create([
            'user_id' => Auth::id(),
            'codigo' => strtoupper($request->codigo),
            'nombre' => $request->nombre,
            'raza' => $request->raza,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso_actual' => $request->peso_actual,
            'estado' => $request->estado,
            'numero_partos' => 0,
            'notas' => $request->notas,
        ]);

        return redirect()->route('cerdas.index')
            ->with('success', 'Cerda registrada exitosamente.');
    }

    public function show(Cerda $cerda)
    {
        // Cargar relaciones
        $cerda->load([
            'inseminaciones' => function($q) { $q->orderBy('fecha_inseminacion', 'desc'); },
            'partos' => function($q) { $q->orderBy('fecha_parto', 'desc'); },
            'alimentos' => function($q) { $q->orderBy('fecha', 'desc')->take(10); },
            'vacunaciones' => function($q) { $q->orderBy('fecha', 'desc'); },
            'tratamientos' => function($q) { $q->orderBy('fecha', 'desc'); }
        ]);

        return view('cerdas.show', compact('cerda'));
    }

    public function edit(Cerda $cerda)
    {
        return view('cerdas.edit', compact('cerda'));
    }

    public function update(Request $request, Cerda $cerda)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cerdas,codigo,' . $cerda->id,
            'nombre' => 'nullable|string|max:100',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'peso_actual' => 'nullable|numeric|min:0',
            'estado' => 'required|in:activa,gestante,lactante,en_celo,descarte',
            'notas' => 'nullable|string',
        ]);

        $cerda->update([
            'codigo' => strtoupper($request->codigo),
            'nombre' => $request->nombre,
            'raza' => $request->raza,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso_actual' => $request->peso_actual,
            'estado' => $request->estado,
            'notas' => $request->notas,
        ]);

        return redirect()->route('cerdas.show', $cerda)
            ->with('success', 'Datos de la cerda actualizados.');
    }

    public function destroy(Cerda $cerda)
    {
        $cerda->delete();

        return redirect()->route('cerdas.index')
            ->with('success', 'Cerda eliminada del sistema.');
    }
}
