@extends('layouts.admin')
@section('title', 'Facturas Emitidas')
@section('breadcrumb', 'Facturación → Facturas Emitidas')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-xl font-800 text-gray-900" style="font-weight:800">Facturas Emitidas</h1>
        <p class="text-sm text-gray-400 mt-0.5">Historial de todas las facturas generadas</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.invoices.index', ['export'=>'excel'] + request()->query()) }}" class="btn-secondary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Exportar Excel
        </a>
        <a href="{{ route('admin.invoices.to-emit') }}" class="btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
            Emitir Facturas
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="page-card mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Buscar por número, cliente…"
               class="form-input" style="width:240px">
        <select name="status" class="form-select" style="width:180px">
            <option value="">Todos los estados</option>
            <option value="emitted" {{ request('status')=='emitted'?'selected':'' }}>Emitida</option>
            <option value="paid"    {{ request('status')=='paid'   ?'selected':'' }}>Pagada</option>
            <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Vencida</option>
            <option value="cancelled"{{ request('status')=='cancelled'?'selected':'' }}>Anulada</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filtrar</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.invoices.index') }}" class="btn-secondary btn-sm">Limpiar</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="page-card">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente / Grupo</th>
                    <th>Sucursal</th>
                    <th>Período</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">IVA</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Estado</th>
                    <th>Fecha</th>
                    <th>Vence</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                <tr>
                    <td>
                        <a href="{{ route('admin.invoices.show', $inv) }}"
                           class="font-600 text-indigo-600 hover:text-indigo-800 font-mono text-xs" style="font-weight:600">{{ $inv->number }}</a>
                    </td>
                    <td>
                        <div class="font-600 text-sm text-gray-800" style="font-weight:600">{{ $inv->businessGroup->name ?? '—' }}</div>
                        <div class="text-xs text-gray-400">{{ $inv->legalEntity->name ?? '' }}</div>
                    </td>
                    <td class="text-sm text-gray-600">{{ $inv->branch->name ?? '—' }}</td>
                    <td class="text-sm text-gray-500">{{ $inv->period_label }}</td>
                    <td class="text-right text-sm text-gray-600">${{ number_format($inv->subtotal, 2) }}</td>
                    <td class="text-right text-sm text-gray-500">${{ number_format($inv->iva_amount, 2) }}</td>
                    <td class="text-right font-700 text-sm" style="font-weight:700">${{ number_format($inv->total, 2) }}</td>
                    <td class="text-center">
                        @switch($inv->status)
                            @case('emitted')   <span class="badge badge-blue">Emitida</span> @break
                            @case('paid')      <span class="badge badge-green">Pagada</span> @break
                            @case('overdue')   <span class="badge badge-red">Vencida</span> @break
                            @case('cancelled') <span class="badge badge-gray">Anulada</span> @break
                            @default           <span class="badge badge-gray">{{ $inv->status }}</span>
                        @endswitch
                    </td>
                    <td class="text-xs text-gray-500">{{ $inv->issue_date?->format('d/m/Y') }}</td>
                    <td class="text-xs {{ $inv->due_date?->isPast() && $inv->status!=='paid' ? 'text-red-500 font-600' : 'text-gray-500' }}">
                        {{ $inv->due_date?->format('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.invoices.show', $inv) }}" class="btn-secondary btn-xs">Ver</a>
                            <a href="{{ route('admin.invoices.show', $inv) }}?export=pdf" class="btn-secondary btn-xs">PDF</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-14">
                        <p class="text-gray-400 text-sm">No hay facturas emitidas aún.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($invoices->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $invoices->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
