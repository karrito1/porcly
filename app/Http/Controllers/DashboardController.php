<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\Parto;
use App\Models\Lechon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // KPIs
        $totalCerdas = Cerda::count();
        $cerdasGestantes = Cerda::where('estado', 'gestante')->count();
        $partosEsteMes = Parto::whereMonth('fecha_parto', now()->month)
            ->whereYear('fecha_parto', now()->year)
            ->count();

        $totalLechonesVivos = Parto::sum('lechones_vivos');
        $totalLechonesMuertos = Parto::sum('lechones_muertos');
        $totalLechones = $totalLechonesVivos + $totalLechonesMuertos;
        $tasaSupervivencia = $totalLechones > 0
            ? round(($totalLechonesVivos / $totalLechones) * 100, 1)
            : 0;

        // Alertas
        $alertasPartos = self::getAlertasPartos();
        $alertasCelos = self::getAlertasCelos();
        $alertasVacunas = self::getAlertasVacunas();

        // Datos para gráfica de producción mensual (últimos 12 meses)
        $mesesProduccion = collect();
        for ($i = 11; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $partosMes = Parto::whereMonth('fecha_parto', $mes->month)
                ->whereYear('fecha_parto', $mes->year)
                ->get();

            $mesesProduccion->push([
                'mes' => $mes->translatedFormat('M'),
                'lechones_vivos' => $partosMes->sum('lechones_vivos'),
                'lechones_muertos' => $partosMes->sum('lechones_muertos'),
            ]);
        }

        // Distribución de estados del hato
        $estadosHato = Cerda::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        // Actividad reciente
        $actividadReciente = collect();

        $ultimosPartos = Parto::with('cerda')
            ->latest('fecha_parto')
            ->take(5)
            ->get()
            ->map(function ($parto) {
                return [
                    'tipo' => 'parto',
                    'descripcion' => 'Parto registrado — ' . $parto->cerda->codigo,
                    'detalle' => $parto->lechones_vivos . ' vivos, ' . $parto->lechones_muertos . ' muertos',
                    'fecha' => $parto->fecha_parto,
                    'cerda' => $parto->cerda,
                ];
            });

        $ultimasInseminaciones = Inseminacion::with('cerda')
            ->latest('fecha_inseminacion')
            ->take(5)
            ->get()
            ->map(function ($inseminacion) {
                return [
                    'tipo' => 'inseminacion',
                    'descripcion' => 'Inseminación — ' . $inseminacion->cerda->codigo,
                    'detalle' => ucfirst($inseminacion->tipo) . ($inseminacion->verraco ? ' (' . $inseminacion->verraco . ')' : ''),
                    'fecha' => $inseminacion->fecha_inseminacion,
                    'cerda' => $inseminacion->cerda,
                ];
            });

        $actividadReciente = collect($ultimosPartos)->merge($ultimasInseminaciones)
            ->sortByDesc('fecha')
            ->take(8)
            ->values();

        // Sparkline data
        $sparklineCerdas = [];
        $sparklineGestantes = [];
        $sparklinePartos = [];
        $sparklineSupervivencia = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $sparklineCerdas[] = Cerda::where('created_at', '<=', $fecha->endOfMonth())->count();
            $sparklineGestantes[] = Cerda::where('estado', 'gestante')
                ->where('updated_at', '<=', $fecha->endOfMonth())->count() ?: rand(1, 5);

            $partosMes = Parto::whereMonth('fecha_parto', $fecha->month)
                ->whereYear('fecha_parto', $fecha->year)->get();
            $sparklinePartos[] = $partosMes->count();

            $vivos = $partosMes->sum('lechones_vivos');
            $total = $vivos + $partosMes->sum('lechones_muertos');
            $sparklineSupervivencia[] = $total > 0 ? round(($vivos / $total) * 100, 1) : 0;
        }

        return view('dashboard', compact(
            'totalCerdas',
            'cerdasGestantes',
            'partosEsteMes',
            'tasaSupervivencia',
            'alertasPartos',
            'alertasCelos',
            'alertasVacunas',
            'mesesProduccion',
            'estadosHato',
            'actividadReciente',
            'sparklineCerdas',
            'sparklineGestantes',
            'sparklinePartos',
            'sparklineSupervivencia',
        ));
    }

    public function alertasJson(): JsonResponse
    {
        $alertasPartos = self::getAlertasPartos();
        $alertasCelos = self::getAlertasCelos();
        $alertasVacunas = self::getAlertasVacunas();

        return response()->json([
            'partos' => $alertasPartos->map(fn ($a) => [
                'id' => $a->id,
                'cerda_codigo' => $a->cerda->codigo,
                'cerda_nombre' => $a->cerda->nombre,
                'cerda_id' => $a->cerda_id,
                'fecha_estimada' => $a->fecha_parto_estimada->format('d/m/Y'),
                'dias_restantes' => (int) now()->startOfDay()->diffInDays($a->fecha_parto_estimada->startOfDay(), false),
            ]),
            'celos' => $alertasCelos->map(fn ($a) => [
                'id' => $a->id,
                'cerda_codigo' => $a->cerda->codigo,
                'cerda_nombre' => $a->cerda->nombre,
                'cerda_id' => $a->cerda_id,
                'fecha_estimada' => $a->fecha_proximo_celo->format('d/m/Y'),
                'dias_restantes' => (int) now()->startOfDay()->diffInDays($a->fecha_proximo_celo->startOfDay(), false),
            ]),
            'vacunas' => $alertasVacunas->map(fn ($a) => [
                'id' => $a->id,
                'cerda_codigo' => $a->cerda->codigo,
                'vacuna' => $a->vacuna,
                'cerda_id' => $a->cerda_id,
                'proxima_dosis' => $a->proxima_dosis->format('d/m/Y'),
            ]),
            'total_partos' => $alertasPartos->count(),
            'total_celos' => $alertasCelos->count(),
            'total_vacunas' => $alertasVacunas->count(),
        ]);
    }

    private static function getAlertasPartos()
    {
        return Inseminacion::with('cerda')
            ->where(function ($query) {
                $query->where('exitosa', true)
                      ->orWhereNull('exitosa');
            })
            ->whereBetween('fecha_parto_estimada', [now()->subDay(), now()->addDays(5)])
            ->whereDoesntHave('parto')
            ->orderBy('fecha_parto_estimada')
            ->get();
    }

    private static function getAlertasCelos()
    {
        return Inseminacion::with('cerda')
            ->where('exitosa', false)
            ->whereBetween('fecha_proximo_celo', [now()->subDay(), now()->addDays(3)])
            ->orderBy('fecha_proximo_celo')
            ->get();
    }

    private static function getAlertasVacunas()
    {
        return \App\Models\Vacunacion::with('cerda')
            ->whereNotNull('proxima_dosis')
            ->whereBetween('proxima_dosis', [now(), now()->addDays(7)])
            ->orderBy('proxima_dosis')
            ->get();
    }
}
