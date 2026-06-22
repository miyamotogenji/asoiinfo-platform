@extends('layouts.admin')
@section('title', 'Planes y Servicios')
@section('breadcrumb', 'Facturación → Planes')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Planes y Servicios</h2>
        <p class="page-sub">{{ $plans->total() }} plan(es) configurado(s)</p>
    </div>
    <a href="{{ route('admin.planes.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nuevo plan
    </a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, código…" class="form-input" style="max-width:220px">
    <select name="type" class="form-input" style="max-width:160px">
        <option value="">Todos los tipos</option>
        <option value="recurring" {{ request('type')==='recurring'?'selected':'' }}>Recurrente</option>
        <option value="one_time"  {{ request('type')==='one_time' ?'selected':'' }}>Venta única</option>
    </select>
    <select name="status" class="form-input" style="max-width:140px">
        <option value="">Todos</option>
        <option value="active"   {{ request('status')==='active'  ?'selected':'' }}>Activo</option>
        <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactivo</option>
    </select>
    <button type="submit" class="btn btn-ghost btn-sm">Filtrar</button>
</form>

<div class="card-glass overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Código / Nombre</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Tipo</th>
                <th class="text-right text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Precio base</th>
                <th class="text-right text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">IVA</th>
                <th class="text-right text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Total</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Período</th>
                <th class="text-center text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Días gracia</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #1a2235">
            @forelse($plans as $plan)
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <code class="text-xs font-mono" style="color:#818cf8">{{ $plan->code }}</code>
                    <p class="text-sm font-semibold text-gray-200 mt-0.5">{{ $plan->name }}</p>
                    @if($plan->description)
                        <p class="text-xs" style="color:#6b7280">{{ Str::limit($plan->description, 50) }}</p>
                    @endif
                </td>
                <td>
                    @if($plan->type==='recurring')
                        <span class="badge badge-info">Recurrente</span>
                    @else
                        <span class="badge badge-pending">Venta única</span>
                    @endif
                </td>
                <td class="text-right font-mono text-sm" style="color:#9ca3af">${{ number_format($plan->base_price, 2) }}</td>
                <td class="text-right font-mono text-sm" style="color:#9ca3af">{{ $plan->iva_percentage ?? 0 }}%</td>
                <td class="text-right font-mono text-sm font-semibold" style="color:#f9fafb">
                    ${{ number_format($plan->base_price * (1 + ($plan->iva_percentage ?? 0)/100), 2) }}
                </td>
                <td class="text-sm" style="color:#9ca3af">{{ ucfirst($plan->billing_period ?? $plan->period ?? '—') }}</td>
                <td class="text-center text-sm" style="color:#9ca3af">{{ $plan->grace_days ?? 0 }}d</td>
                <td>
                    @if($plan->status==='active')
                        <span class="badge badge-active">Activo</span>
                    @else
                        <span class="badge badge-blocked">Inactivo</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-1 justify-end">
                        <a href="{{ route('admin.planes.edit', $plan) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.planes.destroy', $plan) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este plan?')" class="btn btn-ghost btn-sm" style="color:#ef4444">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center py-16" style="color:#6b7280">
                Sin planes configurados — <a href="{{ route('admin.planes.create') }}" style="color:#818cf8">crear el primero</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($plans->hasPages())
<div class="mt-4 flex justify-end">{{ $plans->withQueryString()->links() }}</div>
@endif
@endsection
