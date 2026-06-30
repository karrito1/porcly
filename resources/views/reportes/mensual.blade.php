<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Mensual - Porcly</title>
    <style>
        @page {
            margin: 15px 20px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
            color: #1f2937;
            line-height: 1.5;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #f4b08a 0%, #e39a72 100%);
            color: white;
            padding: 18px 20px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 2px 0;
            color: white;
        }
        .header .subtitle {
            font-size: 9px;
            opacity: 0.9;
            margin: 0;
        }
        .header .generated {
            font-size: 7px;
            opacity: 0.7;
            margin-top: 4px;
        }
        h2 {
            font-size: 11px;
            font-weight: 700;
            color: #f4b08a;
            border-bottom: 2px solid #f4b08a;
            padding-bottom: 3px;
            margin: 16px 0 8px 0;
        }
        .kpi-grid {
            width: 100%;
            margin-bottom: 10px;
        }
        .kpi-grid table {
            width: 100%;
            border-collapse: collapse;
        }
        .kpi-grid td {
            width: 25%;
            border: 1px solid #e5e7eb;
            padding: 6px 4px;
            text-align: center;
            font-size: 8px;
        }
        .kpi-label {
            font-size: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            font-weight: 600;
        }
        .kpi-value {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin-top: 1px;
        }
        .kpi-value.brand { color: #f4b08a; }
        .kpi-value.green { color: #10b981; }
        .kpi-value.red { color: #ef4444; }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.data thead th {
            background: #f4b08a;
            color: white;
            font-weight: 700;
            padding: 5px 6px;
            text-align: left;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.data tbody td {
            padding: 4px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 8px;
        }
        table.data tbody tr:nth-child(even) {
            background: #fafafa;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 6px 0;
            border-top: 1px solid #e5e7eb;
            font-size: 7px;
            color: #9ca3af;
            text-align: center;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 60px;
            font-weight: 800;
            color: rgba(244, 176, 138, 0.06);
            z-index: -1;
            text-transform: uppercase;
            letter-spacing: 10px;
        }
    </style>
</head>
<body>
    <div class="watermark">Porcly</div>

    <div class="header">
        <h1>Reporte Mensual de Producción</h1>
        <p class="subtitle">{{ ucfirst(\Carbon\Carbon::create($anio, $mes, 1)->translatedFormat('F')) }} de {{ $anio }}</p>
        <p class="generated">Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h2>Resumen del Hato</h2>
    <div class="kpi-grid">
        <table>
            <tr>
                <td><div class="kpi-label">Total Cerdas</div><div class="kpi-value">{{ $totalCerdas }}</div></td>
                <td><div class="kpi-label">Gestantes</div><div class="kpi-value brand">{{ $cerdasGestantes }}</div></td>
                <td><div class="kpi-label">Lactantes</div><div class="kpi-value green">{{ $cerdasLactantes }}</div></td>
                <td><div class="kpi-label">Activas</div><div class="kpi-value">{{ $cerdasActivas }}</div></td>
            </tr>
        </table>
    </div>

    <h2>Indicadores de Producción</h2>
    <div class="kpi-grid">
        <table>
            <tr>
                <td><div class="kpi-label">Partos del Mes</div><div class="kpi-value brand">{{ $totalPartos }}</div></td>
                <td><div class="kpi-label">Lechones Vivos</div><div class="kpi-value green">{{ $totalVivos }}</div></td>
                <td><div class="kpi-label">Lechones Muertos</div><div class="kpi-value red">{{ $totalMuertos }}</div></td>
                <td><div class="kpi-label">Tasa Supervivencia</div><div class="kpi-value green">{{ $tasaSupervivencia }}%</div></td>
            </tr>
            <tr>
                <td><div class="kpi-label">Prom. Lechones/Parto</div><div class="kpi-value">{{ $promedioLechonesPorParto }}</div></td>
                <td><div class="kpi-label">Inseminaciones</div><div class="kpi-value brand">{{ $inseminacionesMes }}</div></td>
                <td><div class="kpi-label">Vacunaciones</div><div class="kpi-value">{{ $vacunasMes }}</div></td>
                <td><div class="kpi-label">Cerdas en Celo</div><div class="kpi-value brand">{{ $cerdasEnCelo }}</div></td>
            </tr>
        </table>
    </div>

    <h2>Partos Registrados en el Mes</h2>
    @if($partosRecientes->isEmpty())
        <p style="color: #9ca3af; font-size: 9px; padding: 8px; text-align: center; border: 1px dashed #e5e7eb; border-radius: 4px;">No se registraron partos en este período.</p>
    @else
        <table class="data">
            <thead>
                <tr>
                    <th>Cerda</th>
                    <th>Fecha</th>
                    <th>Vivos</th>
                    <th>Muertos</th>
                    <th>Momias</th>
                    <th>Total</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partosRecientes as $parto)
                    <tr>
                        <td><strong>{{ $parto->cerda->codigo }}</strong> {{ $parto->cerda->nombre ?? '' }}</td>
                        <td>{{ $parto->fecha_parto->format('d/m/Y') }}</td>
                        <td>{{ $parto->lechones_vivos }}</td>
                        <td>{{ $parto->lechones_muertos }}</td>
                        <td>{{ $parto->lechones_momificados }}</td>
                        <td><strong>{{ $parto->lechones_vivos + $parto->lechones_muertos + $parto->lechones_momificados }}</strong></td>
                        <td>{{ $parto->observaciones ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Porcly — Sistema de Gestión Porcícola &mdash; Reporte generado automáticamente
    </div>
</body>
</html>
