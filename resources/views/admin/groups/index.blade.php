@extends('layouts.admin')
@section('title', 'Grupos empresariales')
@section('breadcrumb', 'CRM → Grupos')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">Grupos empresariales</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $groups->total() }} grupo(s) registrado(s)</p>
    </div>
    <a href="{{ route('admin.grupos.create') }}"
       class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo grupo
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar nombre o código…"
           class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 placeholder-gray-600 outline-none w-64">
    <select name="status"
            class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 outline-none">
        <option value="">Todos los estados</option>
        <option value="active" {{ request('status')=='active'?'selected':'' }}>Activo</option>
        <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspendido</option>
        <option value="blocked" {{ request('status')=='blocked'?'selected':'' }}>Bloqueado</option>
        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactivo</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 text-sm rounded-lg transition-colors">Filtrar</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.grupos.index') }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm rounded-lg transition-colors">Limpiar</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-navy-800 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-navy-900/60 border-b border-gray-800">
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Código / Nombre</th>
                <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresas</th>
                <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sucursales</th>
                <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contactos</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-3.5"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/50">
            @forelse($groups as $group)
            <tr class="hover:bg-navy-700/30 transition-colors">
                <td class="px-5 py-4">
                    <p class="font-medium text-gray-200">{{ $group->name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 font-mono">{{ $group->code }}</p>
                </td>
                <td class="px-4 py-4 text-center text-gray-300 font-semibold">{{ $group->legal_entities_count }}</td>
                <td class="px-4 py-4 text-center text-gray-300 font-semibold">{{ $group->branches_count }}</td>
                <td class="px-4 py-4 text-center text-gray-300 font-semibold">{{ $group->contacts_count }}</td>
                <td class="px-4 py-4">
                    @if($group->status === 'active')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-900/40 text-emerald-300 border border-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Activo
                        </span>
                    @elseif($group->status === 'blocked')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-red-900/40 text-red-300 border border-red-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Bloqueado
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-700 text-gray-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> {{ ucfirst($group->status) }}
                        </span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-1 justify-end">
                        <a href="{{ route('admin.grupos.show', $group) }}"
                           class="p-1.5 text-gray-500 hover:text-indigo-400 hover:bg-indigo-500/10 rounded-md transition-colors" title="Ver detalle">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.grupos.edit', $group) }}"
                           class="p-1.5 text-gray-500 hover:text-amber-400 hover:bg-amber-500/10 rounded-md transition-colors" title="Editar">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.grupos.destroy', $group) }}"
                              onsubmit="return confirm('¿Eliminar el grupo {{ $group->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-500 hover:text-red-400 hover:bg-red-500/10 rounded-md transition-colors" title="Eliminar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-16 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    <p class="font-medium">No hay grupos registrados</p>
                    <p class="text-sm mt-1">
                        <a href="{{ route('admin.grupos.create') }}" class="text-indigo-400 hover:underline">Crear el primero</a>
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($groups->hasPages())
<div class="mt-4 flex justify-end">{{ $groups->withQueryString()->links() }}</div>
@endif

@endsection
