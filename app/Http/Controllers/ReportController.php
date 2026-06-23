<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Parto;
use App\Models\Inseminacion;
use App\Models\Vacunacion;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reporteMensual(Request $request)
    {
        $mes = (int) $request->input('mes', now()->month);
        $anio = (int) $request->input('anio', now()->year);

        $fechaInicio = now()->setMonth($mes)->setYear($anio)->startOfMonth();
        $fechaFin = now()->setMonth($mes)->setYear($anio)->endOfMonth();

        $totalCerdas = Cerda::count();
        $cerdasGestantes = Cerda::where('estado', 'gestante')->count();
        $cerdasLactantes = Cerda::where('estado', 'lactante')->count();
        $cerdasActivas = Cerda::where('estado', 'activa')->count();
        $cerdasEnCelo = Cerda::where('estado', 'en_celo')->count();
        $cerdasDescarte = Cerda::where('estado', 'descarte')->count();

        $partosMes = Parto::whereBetween('fecha_parto', [$fechaInicio, $fechaFin])->get();
        $totalPartos = $partosMes->count();
        $totalVivos = $partosMes->sum('lechones_vivos');
        $totalMuertos = $partosMes->sum('lechones_muertos');
        $totalMomificados = $partosMes->sum('lechones_momificados');
        $tasaSupervivencia = ($totalVivos + $totalMuertos) > 0
            ? round(($totalVivos / ($totalVivos + $totalMuertos)) * 100, 1)
            : 0;

        $inseminacionesMes = Inseminacion::whereBetween('fecha_inseminacion', [$fechaInicio, $fechaFin])->count();
        $vacunasMes = Vacunacion::whereBetween('fecha', [$fechaInicio, $fechaFin])->count();

        $promedioLechonesPorParto = $totalPartos > 0 ? round($totalVivos / $totalPartos, 1) : 0;

        $partosRecientes = Parto::with('cerda')
            ->whereBetween('fecha_parto', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_parto', 'desc')
            ->get();

        $html = view('reportes.mensual', compact(
            'mes', 'anio', 'fechaInicio', 'fechaFin',
            'totalCerdas', 'cerdasGestantes', 'cerdasLactantes', 'cerdasActivas',
            'cerdasEnCelo', 'cerdasDescarte',
            'totalPartos', 'totalVivos', 'totalMuertos', 'totalMomificados',
            'tasaSupervivencia', 'inseminacionesMes', 'vacunasMes',
            'promedioLechonesPorParto', 'partosRecientes'
        ))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nombreMes = ucfirst(now()->setMonth($mes)->translatedFormat('F'));
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte-'.$nombreMes.'-'.$anio.'.pdf"',
        ]);
    }
}
