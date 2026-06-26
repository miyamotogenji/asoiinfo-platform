@extends('layouts.admin')
@section('title', 'Reporte Financiero')
@section('breadcrumb', 'Reportes → Financiero')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Reporte Financiero</h2>
        <p class="page-sub">{{ now()->locale('es')->isoFormat('MMMM YYYY') }} — datos en tiempo real</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.cxc.index') }}" class="btn btn-ghost btn-sm">Ver CxC →</a>
        <a href="{{ route('admin.reports.financial') }}?export=excel" class="btn btn-ghost btn-sm flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Excel
        </a>
        <a href="{{ route('admin.reports.financial') }}?export=pdf" class="btn btn-ghost btn-sm flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            PDF
        </a>
    </div>
</div>

{{-- KPI Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card-glass stat-card-gradient-red p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Total por cobrar</p>
                <p class="text-2xl font-bold" style="color:#f9fafb">${{ number_format($data['total_receivable'], 2) }}</p>
                <p class="text-xs mt-1" style="color:#6b7280">Pendiente + Vencido + Parcial</p>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#7f1d1d40">
                <svg class="w-5 h-5" style="color:#f87171" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card-glass stat-card-gradient-emerald p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Cobrado este mes</p>
                <p class="text-2xl font-bold" style="color:#34d399">${{ number_format($data['collected_month'], 2) }}</p>
                <p class="text-xs mt-1" style="color:#6b7280">Pagos aprobados</p>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#064e3b40">
                <svg class="w-5 h-5" style="color:#34d399" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
        </div>
    </div>

    <div class="card-glass stat-card-gradient-indigo p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9ca3af">MRR (mensual)</p>
                <p class="text-2xl font-bold" style="color:#818cf8">${{ number_format($data['mrr'], 2) }}</p>
                <p class="text-xs mt-1" style="color:#6b7280">Ingresos recurrentes</p>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#1e1b4b40">
                <svg class="w-5 h-5" style="color:#818cf8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>

    <div class="card-glass stat-card-gradient-amber p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Clientes bloqueados</p>
                <p class="text-2xl font-bold" style="color:#fbbf24">{{ $data['blocked_clients'] }}</p>
                <p class="text-xs mt-1" style="color:#6b7280">{{ $data['overdue_clients'] }} con deuda vencida</p>
            </div>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#78350f40">
                <svg class="w-5 h-5" style="color:#fbbf24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Monthly trend + Overdue list --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Monthly history --}}
    <div class="card-glass overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Cobros últimos 6 meses</h3>
            <p class="text-xs mt-0.5" style="color:#6b7280">Pagos aprobados por mes</p>
        </div>
        <div class="p-5 space-y-3">
            @php $maxCollected = $monthlyHistory->max('collected') ?: 1; @endphp
            @foreach($monthlyHistory as $m)
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span style="color:#9ca3af">{{ $m['month'] }}</span>
                    <span class="font-mono font-semibold" style="color:#f9fafb">${{ number_format($m['collected'], 2) }}</span>
                </div>
                <div class="h-2 rounded-full" style="background:#1a2235">
                    <div class="h-2 rounded-full transition-all" style="background:linear-gradient(90deg,#6366f1,#818cf8);width:{{ $maxCollected > 0 ? round(($m['collected']/$maxCollected)*100) : 0 }}%"></div>
                </div>
            </div>
            @endforeach
            <div class="pt-2 flex justify-between text-xs" style="border-top:1px solid #1a2235">
                <span style="color:#6b7280">Total año {{ now()->year }}</span>
                <span class="font-mono font-bold" style="color:#818cf8">${{ number_format($data['collected_year'], 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Top overdue --}}
    <div class="card-glass overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #1a2235">
            <div>
                <h3 class="text-sm font-semibold text-gray-200">Top deudores vencidos</h3>
                <p class="text-xs mt-0.5" style="color:#6b7280">Ordenado por días vencidos</p>
            </div>
            <a href="{{ route('admin.cxc.index', ['status'=>'overdue']) }}" class="text-xs" style="color:#818cf8">Ver todos →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full data-table text-sm">
                <thead><tr>
                    <th class="text-left text-xs" style="color:#6b7280">Cliente</th>
                    <th class="text-right text-xs" style="color:#6b7280">Saldo</th>
                    <th class="text-right text-xs" style="color:#6b7280">Días</th>
                </tr></thead>
                <tbody style="border-top:1px solid #1a2235">
                    @forelse($overdueList->take(8) as $ar)
                    <tr style="border-top:1px solid #1a2235">
                        <td>
                            <p class="text-xs font-medium text-gray-200">{{ $ar->branch->name ?? '—' }}</p>
                            <p class="text-xs" style="color:#6b7280">{{ $ar->businessGroup->name ?? '' }}</p>
                        </td>
                        <td class="text-right font-mono text-sm font-bold" style="color:#f87171">${{ number_format($ar->balance, 2) }}</td>
                        <td class="text-right text-sm font-bold" style="color:#f87171">{{ $ar->days_overdue }}d</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-8 text-center text-xs" style="color:#6b7280">Sin deudas vencidas ✓</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
