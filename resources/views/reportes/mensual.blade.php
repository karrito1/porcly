<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Mensual - Porcly</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.5;
            padding: 20px;
        }
        h1 {
            font-size: 18px;
            font-weight: 800;
            color: #111827;
            margin: 0 0 4px 0;
        }
        .subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 13px;
            font-weight: 700;
            color: #f4b08a;
            border-bottom: 2px solid #f4b08a;
            padding-bottom: 4px;
            margin: 20px 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        th {
            background: #f4b08a;
            color: white;
            font-weight: 700;
            padding: 6px 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 5px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }
        .kpi-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px;
            text-align: center;
        }
        .kpi-label {
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            font-weight: 600;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: 800;
            color: #111827;
            margin-top: 2px;
        }
        .kpi-value.brand { color: #f4b08a; }
        .kpi-value.green { color: #10b981; }
        .kpi-value.red { color: #ef4444; }
        .badge {
            display: inline-block;
            background: #f4b08a;
            color: white;
            font-size: 7px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 10px;
        }
        .footer {
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h1>Porcly — Reporte Mensual de Producción</h1>
    <p class="subtitle">{{ ucfirst(now()->setMonth($mes)->translatedFormat('F')) }} de {{ $anio }} &mdash; Generado el {{ now()->format('d/m/Y H:i') }}</p>

    <h2>Resumen del Hato</h2>
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total Cerdas</div>
            <div class="kpi-value">{{ $totalCerdas }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Gestantes</div>
            <div class="kpi-value brand">{{ $cerdasGestantes }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Lactantes</div>
            <div class="kpi-value green">{{ $cerdasLactantes }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Activas</div>
            <div class="kpi-value">{{ $cerdasActivas }}</div>
        </div>
    </div>

    <h2>Indicadores de Producción</h2>
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Partos del Mes</div>
            <div class="kpi-value brand">{{ $totalPartos }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Lechones Vivos</div>
            <div class="kpi-value green">{{ $totalVivos }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Lechones Muertos</div>
            <div class="kpi-value red">{{ $totalMuertos }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Tasa Supervivencia</div>
            <div class="kpi-value green">{{ $tasaSupervivencia }}%</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Prom. Lechones/Parto</div>
            <div class="kpi-value">{{ $promedioLechonesPorParto }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Inseminaciones</div>
            <div class="kpi-value brand">{{ $inseminacionesMes }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Vacunaciones</div>
            <div class="kpi-value">{{ $vacunasMes }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Cerdas en Celo</div>
            <div class="kpi-value brand">{{ $cerdasEnCelo }}</div>
        </div>
    </div>

    <h2>Partos Registrados en el Mes</h2>
    @if($partosRecientes->isEmpty())
        <p style="color: #9ca3af; font-size: 10px;">No se registraron partos en este período.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Cerda</th>
                    <th>Fecha</th>
                    <th>Vivos</th>
                    <th>Muertos</th>
                    <th>Momificados</th>
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
