<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Inseminacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InseminacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inseminacion::with('cerda');

        // Scope: activas (sin parto registrado) por defecto
        $scope = $request->input('scope', 'activas');
        if ($scope === 'activas') {
            $query->whereDoesntHave('parto')
                ->where(function ($q) {
                    $q->whereNull('exitosa')
                        ->orWhere('exitosa', true);
                });
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('cerda', function ($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('resultado')) {
            $res = $request->input('resultado');
            if ($res === 'pendiente') {
                $query->whereNull('exitosa');
            } elseif ($res === 'exitosa') {
                $query->where('exitosa', true);
            } elseif ($res === 'fallida') {
                $query->where('exitosa', false);
            }
        }

        $inseminaciones = $query->orderBy('fecha_inseminacion', 'desc')->paginate(10)->withQueryString();

        return view('inseminaciones.index', compact('inseminaciones', 'scope'));
    }

    public function create(Request $request)
    {
        $cerdas = Cerda::whereNotIn('estado', ['descarte', 'gestante', 'lactante'])->orderBy('codigo')->get();
        $selected_cerda_id = $request->input('cerda_id');

        return view('inseminaciones.create', compact('cerdas', 'selected_cerda_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cerda_id' => 'required|exists:cerdas,id',
            'fecha_inseminacion' => 'required|date',
            'tipo' => 'required|in:natural,artificial',
            'verraco' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        $fechaInseminacion = Carbon::parse($request->fecha_inseminacion);
        // La gestación de la cerda dura 115 días
        $fechaPartoEstimada = $fechaInseminacion->copy()->addDays(115);
        // Próximo celo estimado a los 21 días en caso de fallar
        $fechaProximoCelo = $fechaInseminacion->copy()->addDays(21);

        $inseminacion = Inseminacion::create([
            'cerda_id' => $request->cerda_id,
            'fecha_inseminacion' => $fechaInseminacion,
            'tipo' => $request->tipo,
            'verraco' => $request->verraco,
            'fecha_parto_estimada' => $fechaPartoEstimada,
            'fecha_proximo_celo' => $fechaProximoCelo,
            'exitosa' => null, // Pendiente de diagnóstico
            'notas' => $request->notas,
        ]);

        // Cambiar el estado de la cerda a gestante temporalmente o tras confirmación.
        // Usualmente se asume gestante hasta diagnóstico.
        $cerda = Cerda::find($request->cerda_id);
        $cerda->update(['estado' => 'gestante']);

        return redirect()->route('inseminaciones.index')
            ->with('success', 'Inseminación registrada. Parto estimado: '.$fechaPartoEstimada->format('d/m/Y').'.');
    }

    public function confirm(Request $request, Inseminacion $inseminacion)
    {
        $request->validate([
            'exitosa' => 'required|boolean',
            'notas' => 'nullable|string',
        ]);

        $inseminacion->update([
            'exitosa' => $request->exitosa,
            'notas' => $inseminacion->notas."\n[Confirmación: ".($request->exitosa ? 'Exitosa' : 'Fallida').'] '.$request->notas,
        ]);

        $cerda = $inseminacion->cerda;
        if ($request->exitosa) {
            $cerda->update(['estado' => 'gestante']);
        } else {
            // Si falló, la cerda vuelve a estar en celo o activa
            $cerda->update(['estado' => 'en_celo']);
        }

        return redirect()->back()
            ->with('success', 'Diagnóstico de gestación guardado. Cerda '.$cerda->codigo.' en estado: '.($request->exitosa ? 'Gestante' : 'En celo').'.');
    }
}
