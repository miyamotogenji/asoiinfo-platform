@extends('layouts.admin')
@section('title', 'Sucursales')
@section('breadcrumb', 'CRM → Sucursales')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Sucursales / Agencias</h2>
        <p class="page-sub">{{ $branches->total() }} sucursal(es) registrada(s)</p>
    </div>
    <a href="{{ route('admin.sucursales.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nueva sucursal
    </a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar nombre o código…" class="form-input" style="max-width:240px">
    <select name="group_id" class="form-input" style="max-width:200px">
        <option value="">Todos los grupos</option>
        @foreach($groups as $g)<option value="{{ $g->id }}" {{ request('group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach
    </select>
    <select name="status" class="form-input" style="max-width:150px">
        <option value="">Todos los estados</option>
        <option value="active"    {{ request('status')=='active'   ?'selected':'' }}>Activas</option>
        <option value="blocked"   {{ request('status')=='blocked'  ?'selected':'' }}>Bloqueadas</option>
        <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspendidas</option>
        <option value="inactive"  {{ request('status')=='inactive' ?'selected':'' }}>Inactivas</option>
    </select>
    <button type="submit" class="btn btn-ghost btn-sm">Filtrar</button>
    @if(request()->hasAny(['search','group_id','status']))
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost btn-sm">Limpiar</a>
    @endif
</form>

<div class="card-glass overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Código / Sucursal</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Grupo / RUC</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Ciudad</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">WhatsApp</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Día facturación</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Estado fin.</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #1a2235">
            @forelse($branches as $branch)
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <code class="font-mono text-xs" style="color:#818cf8">{{ $branch->code }}</code>
                    <p class="text-sm font-semibold text-gray-200 mt-0.5">{{ $branch->name }}</p>
                    <p class="text-xs" style="color:#6b7280">{{ $branch->responsible_name }}</p>
                </td>
                <td>
                    <p class="text-sm text-gray-300">{{ $branch->businessGroup->name ?? '—' }}</p>
                    <code class="text-xs font-mono" style="color:#6b7280">{{ $branch->legalEntity->ruc ?? '' }}</code>
                </td>
                <td class="text-sm" style="color:#9ca3af">{{ $branch->city ?? '—' }}</td>
                <td>
                    @if($branch->whatsapp)
                        <a href="https://wa.me/{{ $branch->whatsapp }}" target="_blank" class="text-xs font-mono" style="color:#25d366">{{ $branch->whatsapp }}</a>
                    @else
                        <span style="color:#4b5563">—</span>
                    @endif
                </td>
                <td class="text-sm" style="color:#9ca3af">Día {{ $branch->billing_day ?? '—' }}</td>
                <td>
                    @php $fs = $branch->financial_status ?? 'unknown'; @endphp
                    @if($fs==='current')     <span class="badge badge-active">Al día</span>
                    @elseif($fs==='overdue') <span class="badge badge-overdue">Vencido</span>
                    @elseif($fs==='blocked') <span class="badge badge-blocked">Bloqueado</span>
                    @else                    <span class="badge" style="background:#1a2235;color:#6b7280">Desconocido</span>
                    @endif
                </td>
                <td>
                    @if($branch->status==='active')     <span class="badge badge-active">Activa</span>
                    @elseif($branch->status==='blocked') <span class="badge badge-blocked">Bloqueada</span>
                    @else                                <span class="badge badge-pending">{{ ucfirst($branch->status) }}</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-1 justify-end">
                        <a href="{{ route('admin.sucursales.360', $branch) }}" class="btn btn-ghost btn-sm" title="Vista 360">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            360°
                        </a>
                        <a href="{{ route('admin.sucursales.edit', $branch) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @if($branch->status==='blocked')
                        <form method="POST" action="{{ route('admin.sucursales.unblock', $branch) }}" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#064e3b30;color:#6ee7b7;border:1px solid #05946640">Desbloquear</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('admin.sucursales.block', $branch) }}" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('¿Bloquear {{ addslashes($branch->name) }}?')" class="btn btn-sm" style="background:#7f1d1d30;color:#fca5a5;border:1px solid #99191940">Bloquear</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-16" style="color:#6b7280">
                <svg class="w-10 h-10 mx-auto mb-3" style="color:#1e2a42" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Sin sucursales registradas — <a href="{{ route('admin.sucursales.create') }}" style="color:#818cf8">crear la primera</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($branches->hasPages())
<div class="mt-4 flex justify-end">{{ $branches->withQueryString()->links() }}</div>
@endif
@endsection
