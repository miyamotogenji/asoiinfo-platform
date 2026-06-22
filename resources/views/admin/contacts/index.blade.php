@extends('layouts.admin')
@section('title', 'Contactos')
@section('breadcrumb', 'CRM → Contactos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Contactos</h2>
        <p class="page-sub">{{ $contacts->total() }} contacto(s) registrado(s)</p>
    </div>
    <a href="{{ route('admin.contactos.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nuevo contacto
    </a>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, WhatsApp, email…" class="form-input" style="max-width:260px">
    <select name="type" class="form-input" style="max-width:180px">
        <option value="">Todos los tipos</option>
        <option value="employee" {{ request('type')==='employee'?'selected':'' }}>Empleado</option>
        <option value="prospect" {{ request('type')==='prospect'?'selected':'' }}>Prospecto</option>
        <option value="unknown"  {{ request('type')==='unknown' ?'selected':'' }}>Desconocido</option>
    </select>
    @if(isset($groups))
    <select name="group_id" class="form-input" style="max-width:200px">
        <option value="">Todos los grupos</option>
        @foreach($groups as $g)<option value="{{ $g->id }}" {{ request('group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach
    </select>
    @endif
    <button type="submit" class="btn btn-ghost btn-sm">Filtrar</button>
    @if(request()->hasAny(['search','type','group_id']))
        <a href="{{ route('admin.contactos.index') }}" class="btn btn-ghost btn-sm">Limpiar</a>
    @endif
</form>

<div class="card-glass overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Nombre / WhatsApp</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Empresa / Sucursal</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Cargo</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Tipo</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Última actividad</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #1a2235">
            @forelse($contacts as $contact)
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                             style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                            {{ strtoupper(substr($contact->name ?? 'C', 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-200">{{ $contact->name ?? 'Sin nombre' }}</p>
                            @if($contact->whatsapp)
                                <a href="https://wa.me/{{ $contact->whatsapp }}" target="_blank" class="text-xs font-mono" style="color:#25d366">{{ $contact->whatsapp }}</a>
                            @elseif($contact->phone)
                                <p class="text-xs font-mono" style="color:#6b7280">{{ $contact->phone }}</p>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-medium text-gray-300">{{ $contact->branch->name ?? $contact->businessGroup->name ?? '—' }}</p>
                    <p class="text-xs" style="color:#6b7280">{{ $contact->email ?? '' }}</p>
                </td>
                <td class="text-sm" style="color:#9ca3af">{{ $contact->position ?? '—' }}</td>
                <td>
                    @if($contact->type==='employee')    <span class="badge badge-info">Empleado</span>
                    @elseif($contact->type==='prospect') <span class="badge badge-pending">Prospecto</span>
                    @else                               <span class="badge" style="background:#1a2235;color:#6b7280">Desconocido</span>
                    @endif
                </td>
                <td class="text-xs" style="color:#6b7280">{{ $contact->updated_at->diffForHumans() }}</td>
                <td>
                    <div class="flex items-center gap-1 justify-end">
                        <a href="{{ route('admin.contactos.edit', $contact) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-16" style="color:#6b7280">
                Sin contactos registrados — <a href="{{ route('admin.contactos.create') }}" style="color:#818cf8">crear el primero</a>
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($contacts->hasPages())
<div class="mt-4 flex justify-end">{{ $contacts->withQueryString()->links() }}</div>
@endif
@endsection
