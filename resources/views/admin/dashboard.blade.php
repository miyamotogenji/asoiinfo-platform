@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Panel → Dashboard')

@push('styles')
<style>
/* Donut chart */
.donut-ring { transform: rotate(-90deg); transform-origin: 50% 50%; }
.kpi-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpi-icon svg { width:20px; height:20px; }
.trend-up   { color:#10b981; font-size:.75rem; font-weight:600; }
.trend-down { color:#ef4444; font-size:.75rem; font-weight:600; }
</style>
@endpush

@section('content')
{{-- ─── Header ─────────────────────────────────────────────────────────────── --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <p class="text-xs font-600 text-indigo-500 uppercase tracking-widest mb-1" style="font-weight:600;letter-spacing:.1em">Vista Ejecutiva</p>
        <h1 class="text-2xl font-800 text-gray-900 leading-tight" style="font-weight:800">Dashboard</h1>
        <p class="text-sm text-gray-400 mt-0.5">Resumen general de tu negocio</p>
    </div>
    <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            {{ now()->locale('es')->isoFormat('01/MM/YYYY') }} — {{ now()->locale('es')->isoFormat('DD/MM/YYYY') }}
        </div>
        <button onclick="location.reload()" class="btn-secondary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Actualizar
        </button>
    </div>
</div>

{{-- ─── KPI Cards ──────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">

    {{-- Grupos activos --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.grupos.index') }}'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#eef2ff">
                <svg viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            </div>
            <span class="text-xs text-gray-400">Hoy</span>
        </div>
        <div>
            <div class="text-2xl font-800 text-gray-900" style="font-weight:800">{{ $stats['groups'] }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Grupos Activos</div>
        </div>
    </div>

    {{-- Sucursales activas --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.sucursales.index') }}'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#f0fdf4">
                <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
            </div>
            <span class="text-xs text-gray-400">{{ $stats['branches'] }} total</span>
        </div>
        <div>
            <div class="text-2xl font-800 text-gray-900" style="font-weight:800">{{ $stats['branches'] }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Sucursales Activas</div>
        </div>
    </div>

    {{-- Total por cobrar --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.cxc.index') }}'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#fffbeb">
                <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="text-xs text-amber-500 font-600" style="font-weight:600">Pendiente</span>
        </div>
        <div>
            <div class="text-xl font-800 text-gray-900" style="font-weight:800">${{ number_format($stats['total_receivable'], 0) }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Cuentas x Cobrar</div>
        </div>
    </div>

    {{-- Cobrado este mes --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.payments.index') }}'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#f0fdf4">
                <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <span class="trend-up">+{{ now()->locale('es')->isoFormat('MMMM') }}</span>
        </div>
        <div>
            <div class="text-xl font-800 text-gray-900" style="font-weight:800">${{ number_format($stats['collected_month'], 0) }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Cobrado este mes</div>
        </div>
    </div>

    {{-- Facturas a emitir --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.invoices.to-emit') }}'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#eff6ff">
                <svg viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
            </div>
            <span class="text-xs text-blue-500 font-600" style="font-weight:600">{{ now()->locale('es')->isoFormat('MMMM') }}</span>
        </div>
        <div>
            <div class="text-2xl font-800 text-gray-900" style="font-weight:800">{{ $stats['invoices_to_emit'] }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Facturas a Emitir</div>
        </div>
    </div>

    {{-- Clientes vencidos --}}
    <div class="stat-card flex flex-col gap-2 hover:shadow-md transition-shadow cursor-pointer" onclick="window.location='{{ route('admin.cxc.index') }}?status=overdue'">
        <div class="flex items-center justify-between">
            <div class="kpi-icon" style="background:#fef2f2">
                <svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <span class="text-xs text-red-500 font-600" style="font-weight:600">Bloqueo</span>
        </div>
        <div>
            <div class="text-2xl font-800 text-gray-900" style="font-weight:800">{{ $stats['overdue_clients'] }}</div>
            <div class="text-xs text-gray-500 font-500" style="font-weight:500">Clientes Vencidos</div>
        </div>
    </div>
</div>

{{-- ─── Mid section ─────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

    {{-- Overdue clients table (2/3 width) --}}
    <div class="lg:col-span-2 page-card">
        <div class="page-card-header">
            <div>
                <h2 class="text-sm font-700 text-gray-800" style="font-weight:700">Cuentas Vencidas</h2>
                <p class="text-xs text-gray-400 mt-0.5">Clientes que requieren atención</p>
            </div>
            <a href="{{ route('admin.cxc.index') }}?status=overdue" class="btn-secondary btn-xs">Ver todas</a>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Cliente / Sucursal</th>
                        <th>Factura</th>
                        <th class="text-right">Saldo</th>
                        <th class="text-center">Días</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overdueClients as $cxc)
                    <tr>
                        <td>
                            <div class="font-600 text-gray-800" style="font-weight:600">{{ $cxc->businessGroup->name ?? $cxc->branch->name ?? '—' }}</div>
                            <div class="text-xs text-gray-400">{{ $cxc->branch->name ?? '' }}</div>
                        </td>
                        <td class="text-gray-500 text-xs">{{ $cxc->invoice->invoice_number ?? '—' }}</td>
                        <td class="text-right font-600" style="font-weight:600;color:{{ $cxc->status==='overdue'?'#dc2626':'#d97706' }}">${{ number_format($cxc->balance, 2) }}</td>
                        <td class="text-center">
                            @if($cxc->days_overdue > 0)
                                <span class="badge badge-red">{{ $cxc->days_overdue }}d</span>
                            @else
                                <span class="badge badge-yellow">Al día</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php $st = $cxc->status; @endphp
                            @if($st === 'overdue')  <span class="badge badge-red">Vencido</span>
                            @elseif($st === 'partial') <span class="badge badge-yellow">Parcial</span>
                            @elseif($st === 'pending') <span class="badge badge-blue">Pendiente</span>
                            @else <span class="badge badge-gray">{{ $st }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10">
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm text-gray-400">Sin cuentas vencidas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick actions (1/3 width) --}}
    <div class="page-card">
        <div class="page-card-header">
            <h2 class="text-sm font-700 text-gray-800" style="font-weight:700">Acciones Rápidas</h2>
        </div>
        <div class="p-4 flex flex-col gap-2">
            <a href="{{ route('admin.grupos.create') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-indigo-50 hover:border-indigo-200 transition-colors group">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-gray-700" style="font-weight:600">Nuevo Grupo</div>
                    <div class="text-[10px] text-gray-400">Crear grupo empresarial</div>
                </div>
            </a>
            <a href="{{ route('admin.sucursales.create') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-green-50 hover:border-green-200 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-gray-700" style="font-weight:600">Nueva Sucursal</div>
                    <div class="text-[10px] text-gray-400">Crear punto de atención</div>
                </div>
            </a>
            <a href="{{ route('admin.invoices.to-emit') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-gray-700" style="font-weight:600">Emitir Facturas</div>
                    <div class="text-[10px] text-gray-400">Facturación del mes</div>
                </div>
            </a>
            <a href="{{ route('admin.cxc.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-amber-50 hover:border-amber-200 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-gray-700" style="font-weight:600">Ver CxC</div>
                    <div class="text-[10px] text-gray-400">Cuentas por cobrar</div>
                </div>
            </a>
            <a href="{{ route('admin.reports.financial') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-purple-50 hover:border-purple-200 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-gray-700" style="font-weight:600">Ver Reportes</div>
                    <div class="text-[10px] text-gray-400">Financiero y atención</div>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- ─── Bottom section ──────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

    {{-- Financial summary --}}
    <div class="page-card">
        <div class="page-card-header">
            <div>
                <h2 class="text-sm font-700 text-gray-800" style="font-weight:700">Resumen Financiero</h2>
                <p class="text-xs text-gray-400">{{ now()->locale('es')->isoFormat('MMMM YYYY') }}</p>
            </div>
        </div>
        <div class="p-5">
            @php
                $total_r = $stats['total_receivable'];
                $collected = $stats['collected_month'];
                $pct = ($total_r + $collected) > 0 ? round($collected / ($total_r + $collected) * 100) : 0;
            @endphp
            <div class="flex items-center gap-6">
                {{-- Donut --}}
                <div class="relative flex-shrink-0">
                    <svg width="100" height="100" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#f3f4f6" stroke-width="12"/>
                        <circle class="donut-ring" cx="50" cy="50" r="38" fill="none" stroke="#4f46e5" stroke-width="12"
                            stroke-dasharray="{{ $pct * 2.39 }} 239"
                            stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-800 text-gray-900" style="font-weight:800">{{ $pct }}%</span>
                        <span class="text-[9px] text-gray-400">Cobrado</span>
                    </div>
                </div>
                {{-- Stats --}}
                <div class="flex-1 space-y-3">
                    <div class="flex justify-between items-center py-1 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Total por cobrar</span>
                        <span class="text-sm font-600 text-gray-800" style="font-weight:600">${{ number_format($total_r, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Cobrado este mes</span>
                        <span class="text-sm font-600 text-green-600" style="font-weight:600">${{ number_format($collected, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Clientes vencidos</span>
                        <span class="text-sm font-600 text-red-500" style="font-weight:600">{{ $stats['overdue_clients'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-xs text-gray-500">Clientes bloqueados</span>
                        <span class="text-sm font-600 text-orange-500" style="font-weight:600">{{ $stats['blocked_clients'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent activity --}}
    <div class="page-card">
        <div class="page-card-header">
            <div>
                <h2 class="text-sm font-700 text-gray-800" style="font-weight:700">Alertas y Notificaciones</h2>
                <p class="text-xs text-gray-400">Operaciones que requieren atención</p>
            </div>
            <span class="badge badge-blue">{{ $stats['overdue_clients'] + $stats['blocked_clients'] }}</span>
        </div>
        <div class="p-4 space-y-2">
            @if($stats['invoices_to_emit'] > 0)
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-blue-700" style="font-weight:600">{{ $stats['invoices_to_emit'] }} facturas pendientes de emitir</div>
                    <div class="text-[11px] text-blue-400 mt-0.5">Revisar facturas del mes</div>
                </div>
            </div>
            @endif
            @if($stats['overdue_clients'] > 0)
            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-red-700" style="font-weight:600">{{ $stats['overdue_clients'] }} clientes con deuda vencida</div>
                    <div class="text-[11px] text-red-400 mt-0.5">Gestionar cobros</div>
                </div>
            </div>
            @endif
            @if($stats['blocked_clients'] > 0)
            <div class="flex items-start gap-3 p-3 bg-orange-50 rounded-lg">
                <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-orange-700" style="font-weight:600">{{ $stats['blocked_clients'] }} sucursales bloqueadas</div>
                    <div class="text-[11px] text-orange-400 mt-0.5">Revisar bloqueos activos</div>
                </div>
            </div>
            @endif
            @if($stats['total_receivable'] > 0)
            <div class="flex items-start gap-3 p-3 bg-amber-50 rounded-lg">
                <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 9v1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-600 text-amber-700" style="font-weight:600">Falta integrar API de pagos</div>
                    <div class="text-[11px] text-amber-400 mt-0.5">Configurar pasarela</div>
                </div>
            </div>
            @endif
            @if($stats['invoices_to_emit'] === 0 && $stats['overdue_clients'] === 0 && $stats['blocked_clients'] === 0)
            <div class="text-center py-8">
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm text-gray-400">Todo al día</p>
            </div>
            @endif
        </div>
    </div>
</div>

<p class="text-center text-xs text-gray-300 mt-6">El dashboard se recarga automáticamente cada 30 minutos · Última sincronización: {{ now()->format('d/m/Y H:i') }}</p>
@endsection
