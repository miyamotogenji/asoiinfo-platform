@extends('layouts.admin')
@section('title', 'Facturas emitidas')
@section('breadcrumb', 'Facturación → Facturas emitidas')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">Facturas emitidas</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $invoices->total() }} factura(s) en total</p>
    </div>
    <a href="{{ route('admin.invoices.to-emit') }}"
       class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
        Emitir nuevas
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar número o cliente…"
           class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 placeholder-gray-600 outline-none w-64">
    <select name="status" class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 outline-none">
        <option value="">Todos los estados</option>
        <option value="emitted"   {{ request('status')=='emitted'   ?'selected':'' }}>Emitida</option>
        <option value="cancelled" {{ request('status')=='cancelled' ?'selected':'' }}>Anulada</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 text-sm rounded-lg transition-colors">Filtrar</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm rounded-lg transition-colors">Limpiar</a>
    @endif
</form>

<div class="bg-navy-800 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-navy-900/60 border-b border-gray-800">
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Número</th>
                <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Período</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subtotal</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">IVA</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Emisión</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vence</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/50">
            @forelse($invoices as $inv)
            <tr class="hover:bg-navy-700/30 transition-colors">
                <td class="px-5 py-3.5">
                    <code class="text-indigo-400 text-xs font-mono font-semibold">{{ $inv->number }}</code>
                </td>
                <td class="px-4 py-3.5">
                    <p class="text-xs font-medium text-gray-200">{{ $inv->branch?->name ?? $inv->businessGroup?->name ?? '—' }}</p>
                    <p class="text-xs text-gray-500">{{ $inv->businessGroup?->name ?? '' }}</p>
                </td>
                <td class="px-4 py-3.5 text-xs text-gray-400">{{ $inv->period_label ?? '—' }}</td>
                <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-300">${{ number_format($inv->subtotal, 2) }}</td>
                <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-400">${{ number_format($inv->iva_amount, 2) }}</td>
                <td class="px-4 py-3.5 text-right font-mono text-sm font-bold text-white">${{ number_format($inv->total, 2) }}</td>
                <td class="px-4 py-3.5 text-xs text-gray-400">{{ $inv->issue_date?->format('d/m/Y') }}</td>
                <td class="px-4 py-3.5 text-xs {{ $inv->due_date?->isPast() ? 'text-red-400' : 'text-gray-400' }}">
                    {{ $inv->due_date?->format('d/m/Y') }}
                </td>
                <td class="px-4 py-3.5">
                    @if($inv->status === 'emitted')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-blue-900/40 text-blue-300 border border-blue-800">Emitida</span>
                    @elseif($inv->status === 'cancelled')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-red-900/40 text-red-300 border border-red-800">Anulada</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-700 text-gray-400">{{ $inv->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-5 py-16 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="font-medium">Sin facturas emitidas</p>
                    <p class="text-sm mt-1"><a href="{{ route('admin.invoices.to-emit') }}" class="text-indigo-400 hover:underline">Emitir facturas del mes</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($invoices->hasPages())
<div class="mt-4 flex justify-end">{{ $invoices->withQueryString()->links() }}</div>
@endif

@endsection
