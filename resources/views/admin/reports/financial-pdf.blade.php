<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 16px; }
    h1 { color: #2563eb; font-size: 18px; margin-bottom: 4px; }
    .subtitle { color: #64748b; font-size: 11px; margin-bottom: 20px; }
    .grid { display: table; width: 100%; margin-bottom: 20px; }
    .card { display: table-cell; width: 16%; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; text-align: center; }
    .card-label { font-size: 9px; color: #64748b; text-transform: uppercase; font-weight: bold; }
    .card-val { font-size: 16px; font-weight: bold; color: #1d4ed8; margin-top: 4px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th { background: #2563eb; color: white; padding: 6px 8px; font-size: 9px; text-transform: uppercase; text-align: left; }
    td { padding: 5px 8px; border-bottom: 1px solid #f1f5f9; font-size: 9px; }
    tr:nth-child(even) td { background: #f8fafc; }
    .red { color: #dc2626; font-weight: bold; }
    .footer { margin-top: 20px; font-size: 8px; color: #94a3b8; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 8px; }
</style>
</head>
<body>
<h1>Reporte Financiero</h1>
<div class="subtitle">Generado: {{ now()->locale('es')->isoFormat('D MMMM YYYY, H:mm') }}</div>

<div style="display:table; width:100%; border-spacing:6px; margin-bottom:16px;">
@foreach([
    ['Por Cobrar', '$ '.number_format($data['total_receivable'],2)],
    ['Vencida',    '$ '.number_format($data['total_overdue'],2)],
    ['Cobrado Mes','$ '.number_format($data['collected_month'],2)],
    ['Cobrado Año','$ '.number_format($data['collected_year'],2)],
    ['MRR',        '$ '.number_format($data['mrr'],2)],
    ['ARR',        '$ '.number_format($data['arr'],2)],
] as [$label,$val])
<div style="display:table-cell; padding:8px; background:#f8fafc; border:1px solid #e2e8f0; text-align:center;">
    <div style="font-size:8px; color:#64748b; text-transform:uppercase; font-weight:bold;">{{ $label }}</div>
    <div style="font-size:13px; font-weight:bold; color:#1d4ed8; margin-top:3px;">{{ $val }}</div>
</div>
@endforeach
</div>

<h3 style="color:#dc2626; margin-bottom:6px;">Cartera Vencida</h3>
<table>
    <thead><tr><th>Grupo</th><th>Empresa</th><th>Sucursal</th><th>Factura</th><th>Saldo</th><th>Días</th><th>Estado</th></tr></thead>
    <tbody>
    @forelse($overdueList as $ar)
    <tr>
        <td>{{ $ar->businessGroup?->name }}</td>
        <td>{{ $ar->legalEntity?->name }}</td>
        <td>{{ $ar->branch?->name }}</td>
        <td>{{ $ar->invoice?->number }}</td>
        <td class="red">$ {{ number_format($ar->balance,2) }}</td>
        <td class="red">{{ $ar->days_overdue }}</td>
        <td>{{ ucfirst($ar->status) }}</td>
    </tr>
    @empty
    <tr><td colspan="7" style="text-align:center; color:#64748b; padding:12px;">Sin cartera vencida</td></tr>
    @endforelse
    </tbody>
</table>

<div class="footer">ASOIINFO Platform · Reporte Financiero · {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
