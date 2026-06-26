<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 16px; }
    .company { font-size: 20px; font-weight: bold; color: #2563eb; }
    .invoice-title { font-size: 28px; font-weight: bold; color: #1e293b; text-align: right; }
    .invoice-num { color: #2563eb; font-size: 16px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th { background: #2563eb; color: white; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
    td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; }
    tr:nth-child(even) td { background: #f8fafc; }
    .totals { margin-top: 20px; text-align: right; }
    .totals table { width: 280px; margin-left: auto; }
    .totals td { padding: 5px 10px; }
    .total-row td { font-weight: bold; font-size: 14px; background: #eff6ff; color: #1d4ed8; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 9px; font-weight: bold; }
    .badge-emitted { background: #dbeafe; color: #1d4ed8; }
    .badge-paid { background: #d1fae5; color: #065f46; }
    .footer { margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 12px; font-size: 9px; color: #94a3b8; text-align: center; }
</style>
</head>
<body>
<div class="header">
    <div>
        <div class="company">ASOIINFO Platform</div>
        <div style="color:#64748b; margin-top:4px;">Sistema de Gestión Empresarial</div>
        <div style="margin-top:16px; font-size:11px;">
            <strong>Cliente:</strong> {{ $invoice->businessGroup?->name }}<br>
            <strong>Empresa:</strong> {{ $invoice->legalEntity?->name }}<br>
            <strong>Sucursal:</strong> {{ $invoice->branch?->name }}
        </div>
    </div>
    <div style="text-align:right;">
        <div class="invoice-title">FACTURA</div>
        <div class="invoice-num">{{ $invoice->number }}</div>
        <div style="margin-top:12px; font-size:11px; color:#475569;">
            <strong>Período:</strong> {{ $invoice->period_label }}<br>
            <strong>Fecha Emisión:</strong> {{ $invoice->issue_date?->format('d/m/Y') }}<br>
            <strong>Fecha Vencimiento:</strong> {{ $invoice->due_date?->format('d/m/Y') }}<br>
            <strong>Estado:</strong> <span class="badge badge-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
        </div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Descripción del Servicio</th>
            <th>Plan</th>
            <th>Período</th>
            <th style="text-align:right;">Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $invoice->contractedService?->plan?->name ?? 'Servicio Contratado' }}</td>
            <td>{{ $invoice->contractedService?->plan?->name }}</td>
            <td>{{ $invoice->period_label }}</td>
            <td style="text-align:right;">$ {{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
    </tbody>
</table>

<div class="totals">
    <table>
        <tr><td>Subtotal</td><td style="text-align:right;">$ {{ number_format($invoice->subtotal, 2) }}</td></tr>
        <tr><td>IVA 12%</td><td style="text-align:right;">$ {{ number_format($invoice->iva_amount, 2) }}</td></tr>
        <tr class="total-row"><td><strong>TOTAL</strong></td><td style="text-align:right;"><strong>$ {{ number_format($invoice->total, 2) }}</strong></td></tr>
    </table>
</div>

<div class="footer">
    ASOIINFO Platform · Generado el {{ now()->format('d/m/Y H:i') }} · IVA 12% (Ecuador)
</div>
</body>
</html>
