<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\Parto;
use App\Models\Vacunacion;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CalendarController extends Controller
{
    public function index()
    {
        $partosProgramados = self::partosProgramados();
        $celosProgramados = self::celosProgramados();
        $vacunasProgramadas = self::vacunasProgramadas();

        $partosProximos = $partosProgramados->take(3);
        $celosProximos = $celosProgramados->take(3);
        $vacunasProximas = $vacunasProgramadas->take(3);
        $cerdasGestantes = Cerda::where('estado', 'gestante')->orderBy('codigo')->get();
        $cerdasDisponibles = Cerda::whereNotIn('estado', ['descarte', 'gestante', 'lactante'])
            ->orderBy('codigo')
            ->get();
        $cerdasTodas = Cerda::orderBy('codigo')->get();

        $resumenPartos = $partosProgramados->count();
        $resumenCelos = $celosProgramados->count();
        $resumenVacunas = $vacunasProgramadas->count();

        return view('calendario.index', compact(
            'partosProximos',
            'celosProximos',
            'vacunasProximas',
            'cerdasGestantes',
            'cerdasDisponibles',
            'cerdasTodas',
            'resumenPartos',
            'resumenCelos',
            'resumenVacunas'
        ));
    }

    public function eventosJson(Request $request): JsonResponse
    {
        $start = Carbon::parse($request->input('start', now()->startOfMonth()))->toDateString();
        $end = Carbon::parse($request->input('end', now()->endOfMonth()))->toDateString();

        $eventos = self::partosProgramados($start, $end)
            ->merge(self::celosProgramados($start, $end))
            ->merge(self::vacunasProgramadas($start, $end))
            ->merge(self::partosRealizados($start, $end))
            ->values();

        return response()->json($eventos);
    }

    private static function partosProgramados(?string $start = null, ?string $end = null): Collection
    {
        $query = Inseminacion::with('cerda')
            ->where(function ($q) {
                $q->where('exitosa', true)->orWhereNull('exitosa');
            })
            ->whereDoesntHave('parto')
            ->orderBy('fecha_parto_estimada');

        if ($start && $end) {
            $query->whereBetween('fecha_parto_estimada', [$start, $end]);
        } else {
            $query->whereBetween('fecha_parto_estimada', [now()->subDay(), now()->addDays(5)]);
        }

        return $query->get()->map(function ($inseminacion) {
            $fecha = $inseminacion->fecha_parto_estimada->startOfDay();
            $dias = (int) now()->startOfDay()->diffInDays($fecha, false);

            return [
                'id' => 'parto-' . $inseminacion->id,
                'tipo' => 'parto',
                'title' => 'Parto: ' . $inseminacion->cerda->codigo,
                'start' => $fecha->format('Y-m-d'),
                'color' => $dias <= 1 ? '#ef4444' : ($dias <= 3 ? '#f97316' : '#f4b08a'),
                'icono' => '🐷',
                'cerda_id' => $inseminacion->cerda_id,
                'cerda_codigo' => $inseminacion->cerda->codigo,
                'cerda_nombre' => $inseminacion->cerda->nombre,
                'fecha_formateada' => $fecha->format('d/m/Y'),
                'detalle' => 'Parto estimado para ' . $inseminacion->cerda->codigo,
                'accion' => 'parto',
            ];
        });
    }

    private static function celosProgramados(?string $start = null, ?string $end = null): Collection
    {
        $query = Inseminacion::with('cerda')
            ->where('exitosa', false)
            ->whereNotNull('fecha_proximo_celo')
            ->orderBy('fecha_proximo_celo');

        if ($start && $end) {
            $query->whereBetween('fecha_proximo_celo', [$start, $end]);
        } else {
            $query->whereBetween('fecha_proximo_celo', [now()->subDay(), now()->addDays(3)]);
        }

        return $query->get()->map(function ($inseminacion) {
            $fecha = $inseminacion->fecha_proximo_celo->startOfDay();

            return [
                'id' => 'celo-' . $inseminacion->id,
                'tipo' => 'celo',
                'title' => 'Celo: ' . $inseminacion->cerda->codigo,
                'start' => $fecha->format('Y-m-d'),
                'color' => '#f59e0b',
                'icono' => '💛',
                'cerda_id' => $inseminacion->cerda_id,
                'cerda_codigo' => $inseminacion->cerda->codigo,
                'cerda_nombre' => $inseminacion->cerda->nombre,
                'fecha_formateada' => $fecha->format('d/m/Y'),
                'detalle' => 'Retorno a celo estimado',
                'accion' => 'inseminacion',
            ];
        });
    }

    private static function vacunasProgramadas(?string $start = null, ?string $end = null): Collection
    {
        $query = Vacunacion::with('cerda')
            ->whereNotNull('proxima_dosis')
            ->orderBy('proxima_dosis');

        if ($start && $end) {
            $query->whereBetween('proxima_dosis', [$start, $end]);
        } else {
            $query->whereBetween('proxima_dosis', [now(), now()->addDays(7)]);
        }

        return $query->get()->map(function ($vacunacion) {
            $fecha = $vacunacion->proxima_dosis->startOfDay();

            return [
                'id' => 'vacuna-' . $vacunacion->id,
                'tipo' => 'vacuna',
                'title' => 'Vacuna: ' . $vacunacion->cerda->codigo,
                'start' => $fecha->format('Y-m-d'),
                'color' => '#3b82f6',
                'icono' => '💉',
                'cerda_id' => $vacunacion->cerda_id,
                'cerda_codigo' => $vacunacion->cerda->codigo,
                'cerda_nombre' => $vacunacion->cerda->nombre,
                'fecha_formateada' => $fecha->format('d/m/Y'),
                'detalle' => $vacunacion->vacuna,
                'accion' => 'vacuna',
            ];
        });
    }

    private static function partosRealizados(?string $start = null, ?string $end = null): Collection
    {
        $query = Parto::with('cerda')->orderBy('fecha_parto', 'desc');

        if ($start && $end) {
            $query->whereBetween('fecha_parto', [$start, $end]);
        }

        return $query->get()->map(function ($parto) {
            $fecha = $parto->fecha_parto->startOfDay();

            return [
                'id' => 'parto-realizado-' . $parto->id,
                'tipo' => 'parto-realizado',
                'title' => 'Parto: ' . $parto->cerda->codigo,
                'start' => $fecha->format('Y-m-d'),
                'color' => '#10b981',
                'icono' => '✅',
                'cerda_id' => $parto->cerda_id,
                'cerda_codigo' => $parto->cerda->codigo,
                'cerda_nombre' => $parto->cerda->nombre,
                'fecha_formateada' => $fecha->format('d/m/Y'),
                'detalle' => $parto->lechones_vivos . ' vivos, ' . $parto->lechones_muertos . ' muertos',
                'accion' => null,
            ];
        });
    }
}
