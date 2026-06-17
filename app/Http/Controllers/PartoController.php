<?php

namespace App\Http\Controllers;

use App\Models\Parto;
use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\Lechon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartoController extends Controller
{
    public function index(Request $request)
    {
        $query = Parto::with('cerda');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('cerda', function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%");
            });
        }

        $partos = $query->orderBy('fecha_parto', 'desc')->paginate(10)->withQueryString();

        return view('partos.index', compact('partos'));
    }

    public function create(Request $request)
    {
        // Cerdas gestantes
        $cerdas = Cerda::where('estado', 'gestante')->orderBy('codigo')->get();
        $selected_cerda_id = $request->input('cerda_id');
        
        return view('partos.create', compact('cerdas', 'selected_cerda_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cerda_id' => 'required|exists:cerdas,id',
            'fecha_parto' => 'required|date',
            'lechones_vivos' => 'required|integer|min:0',
            'lechones_muertos' => 'required|integer|min:0',
            'lechones_momificados' => 'required|integer|min:0',
            'peso_camada' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        $cerda = Cerda::findOrFail($request->cerda_id);

        // Buscar última inseminación activa (para vincularla)
        $inseminacion = Inseminacion::where('cerda_id', $cerda->id)
            ->where(function($q) {
                $q->where('exitosa', true)
                  ->orWhereNull('exitosa');
            })
            ->whereDoesntHave('parto')
            ->orderBy('fecha_inseminacion', 'desc')
            ->first();

        DB::transaction(function() use ($request, $cerda, $inseminacion) {
            // Crear el parto
            $parto = Parto::create([
                'cerda_id' => $cerda->id,
                'inseminacion_id' => $inseminacion ? $inseminacion->id : null,
                'fecha_parto' => $request->fecha_parto,
                'lechones_vivos' => $request->lechones_vivos,
                'lechones_muertos' => $request->lechones_muertos,
                'lechones_momificados' => $request->lechones_momificados,
                'peso_camada' => $request->peso_camada,
                'observaciones' => $request->observaciones,
            ]);

            // Generar lechones vivos en la base de datos para fácil seguimiento
            for ($i = 1; $i <= $request->lechones_vivos; $i++) {
                Lechon::create([
                    'parto_id' => $parto->id,
                    'codigo' => 'L-' . $cerda->codigo . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-' . date('y'),
                    'sexo' => ($i % 2 === 0) ? 'macho' : 'hembra',
                    'peso_nacimiento' => $request->peso_camada > 0 ? round($request->peso_camada / $request->lechones_vivos, 2) : 1.40,
                    'estado' => 'vivo',
                ]);
            }

            // Si se vincula la inseminación, marcarla como exitosa
            if ($inseminacion) {
                $inseminacion->update(['exitosa' => true]);
            }

            // Actualizar cerda: estado = lactante, incrementar partos
            $cerda->update([
                'estado' => 'lactante',
                'numero_partos' => $cerda->numero_partos + 1
            ]);
        });

        return redirect()->route('partos.index')
            ->with('success', 'Parto registrado. Cerda ' . $cerda->codigo . ' en lactancia. Se crearon ' . $request->lechones_vivos . ' registros de lechones.');
    }
}
