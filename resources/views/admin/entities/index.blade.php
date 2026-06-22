@extends('layouts.admin')
@section('title', 'Empresas (RUC)')
@section('breadcrumb', 'CRM → Empresas legales')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Empresas / Personas jurídicas</h2>
        <p class="page-sub">{{ $entities->total() }} empresa(s) registrada(s)</p>
    </div>
    <a href="{{ route('admin.empresas.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nueva empresa
    </a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="RUC, razón social…" class="form-input" style="max-width:280px">
    <select name="group_id" class="form-input" style="max-width:220px">
        <option value="">Todos los grupos</option>
        @foreach($groups as $g)<option value="{{ $g->id }}" {{ request('group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach
    </select>
    <button type="submit" class="btn btn-ghost btn-sm">Filtrar</button>
    @if(request()->hasAny(['search','group_id']))
        <a href="{{ route('admin.empresas.index') }}" class="btn btn-ghost btn-sm">Limpiar</a>
    @endif
</form>

<div class="card-glass overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">RUC / Razón social</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Nombre comercial</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Grupo</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Contabilidad</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #1a2235">
            @forelse($entities as $entity)
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <code class="text-xs font-mono" style="color:#818cf8">{{ $entity->ruc }}</code>
                    <p class="text-sm font-semibold text-gray-200 mt-0.5">{{ $entity->legal_name }}</p>
                </td>
                <td class="text-sm" style="color:#9ca3af">{{ $entity->trade_name ?? '—' }}</td>
                <td>
                    @if($entity->businessGroup)
                        <span class="badge badge-info">{{ $entity->businessGroup->name }}</span>
                    @else
                        <span style="color:#4b5563">—</span>
                    @endif
                </td>
                <td class="text-xs" style="color:#9ca3af">{{ $entity->accounting_email ?? '—' }}</td>
                <td>
                    @if($entity->status==='active')
                        <span class="badge badge-active">Activa</span>
                    @else
                        <span class="badge badge-blocked">{{ ucfirst($entity->status) }}</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-1 justify-end">
                        <a href="{{ route('admin.empresas.edit', $entity) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Editar
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-16" style="color:#6b7280">
                Sin empresas registradas — <a href="{{ route('admin.empresas.create') }}" style="color:#818cf8">agregar primera</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($entities->hasPages())
<div class="mt-4 flex justify-end">{{ $entities->withQueryString()->links() }}</div>
@endif
@endsection
