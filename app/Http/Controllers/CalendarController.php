<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\Parto;
use App\Models\Vacunacion;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }

    public function eventosJson(Request $request)
    {
        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->endOfMonth()->toDateString());

        $partos = Inseminacion::with('cerda')
            ->where(function ($q) {
                $q->where('exitosa', true)->orWhereNull('exitosa');
            })
            ->whereDoesntHave('parto')
            ->whereBetween('fecha_parto_estimada', [$start, $end])
            ->get()
            ->map(function ($i) {
                $diff = (int) now()->startOfDay()->diffInDays($i->fecha_parto_estimada->startOfDay(), false);
                $color = $diff <= 1 ? '#ef4444' : ($diff <= 3 ? '#f97316' : '#f4b08a');
                return [
                    'title' => '🐷 Parto: ' . $i->cerda->codigo,
                    'start' => $i->fecha_parto_estimada->format('Y-m-d'),
                    'color' => $color,
                    'url' => route('partos.create', ['cerda_id' => $i->cerda_id]),
                    'description' => 'Parto estimado para ' . $i->cerda->codigo . ' (' . ($i->cerda->nombre ?? 'Sin nombre') . ')',
                    'tipo' => 'parto',
                ];
            });

        $celos = Inseminacion::with('cerda')
            ->where('exitosa', false)
            ->whereBetween('fecha_proximo_celo', [$start, $end])
            ->get()
            ->map(function ($i) {
                return [
                    'title' => '💕 Celo: ' . $i->cerda->codigo,
                    'start' => $i->fecha_proximo_celo->format('Y-m-d'),
                    'color' => '#f59e0b',
                    'url' => route('inseminaciones.create', ['cerda_id' => $i->cerda_id]),
                    'description' => 'Retorno a celo estimado — ' . $i->cerda->codigo,
                    'tipo' => 'celo',
                ];
            });

        $vacunas = Vacunacion::with('cerda')
            ->whereNotNull('proxima_dosis')
            ->whereBetween('proxima_dosis', [$start, $end])
            ->get()
            ->map(function ($v) {
                return [
                    'title' => '💉 Vac: ' . $v->cerda->codigo,
                    'start' => $v->proxima_dosis->format('Y-m-d'),
                    'color' => '#3b82f6',
                    'url' => route('cerdas.show', $v->cerda_id) . '#vacunas',
                    'description' => $v->vacuna . ' — ' . $v->cerda->codigo,
                    'tipo' => 'vacuna',
                ];
            });

        $partosPasados = Parto::with('cerda')
            ->whereBetween('fecha_parto', [$start, $end])
            ->get()
            ->map(function ($p) {
                return [
                    'title' => '✅ Parto: ' . $p->cerda->codigo,
                    'start' => $p->fecha_parto->format('Y-m-d'),
                    'color' => '#10b981',
                    'url' => route('cerdas.show', $p->cerda_id),
                    'description' => $p->lechones_vivos . ' vivos, ' . $p->lechones_muertos . ' muertos',
                    'tipo' => 'parto-realizado',
                ];
            });

        $eventos = $partos->merge($celos)->merge($vacunas)->merge($partosPasados);

        return response()->json($eventos);
    }
}
