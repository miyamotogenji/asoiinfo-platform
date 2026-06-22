@extends('layouts.admin')
@section('title','Usuarios y Roles')
@section('breadcrumb','Administración → Usuarios')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="page-heading">Usuarios y Roles</h2>
        <p class="page-sub">{{ $users->total() }} usuarios registrados · 6 roles disponibles</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Nuevo usuario
    </a>
</div>

{{-- Role legend --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @php
    $roleStyles = [
        'superadmin'    => ['bg'=>'#4c1d9540','border'=>'#7c3aed','color'=>'#c4b5fd','icon'=>'⚡'],
        'admin'         => ['bg'=>'#1e3a5f40','border'=>'#2563eb','color'=>'#93c5fd','icon'=>'🛡'],
        'accounting'    => ['bg'=>'#064e3b40','border'=>'#059669','color'=>'#6ee7b7','icon'=>'📊'],
        'sales'         => ['bg'=>'#78350f40','border'=>'#d97706','color'=>'#fcd34d','icon'=>'💼'],
        'support_agent' => ['bg'=>'#0c4a6e40','border'=>'#0284c7','color'=>'#7dd3fc','icon'=>'🎧'],
        'technician'    => ['bg'=>'#1f2937','border'=>'#374151','color'=>'#9ca3af','icon'=>'🔧'],
    ];
    @endphp
    @foreach($roles as $role)
    @php $s = $roleStyles[$role->name] ?? $roleStyles['technician']; @endphp
    <div class="p-3 rounded-xl text-center" style="background:{{ $s['bg'] }};border:1px solid {{ $s['border'] }}">
        <div class="text-lg mb-1">{{ $s['icon'] }}</div>
        <p class="text-xs font-semibold" style="color:{{ $s['color'] }}">{{ ucfirst(str_replace('_',' ',$role->name)) }}</p>
        <p class="text-xs mt-0.5" style="color:#6b7280">{{ $users->getCollection()->filter(fn($u)=>$u->roles->contains('name',$role->name))->count() }} usuarios</p>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o email…"
           class="form-input flex-1 min-w-48" style="max-width:320px">
    <select name="role" class="form-input" style="min-width:160px">
        <option value="">Todos los roles</option>
        @foreach($roles as $r)
            <option value="{{ $r->name }}" {{ request('role')==$r->name ? 'selected':'' }}>
                {{ ucfirst(str_replace('_',' ',$r->name)) }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-ghost">Filtrar</button>
    @if(request('search') || request('role'))
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-ghost">Limpiar</a>
    @endif
</form>

{{-- Table --}}
<div class="card-glass overflow-hidden">
    <table class="w-full data-table">
        <thead>
            <tr>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Usuario</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Email</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Rol</th>
                <th class="text-left text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Registrado</th>
                <th class="text-right text-xs font-semibold uppercase tracking-wider" style="color:#6b7280">Acciones</th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #1a2235">
            @forelse($users as $user)
            @php
            $roleName = $user->roles->first()?->name ?? 'sin rol';
            $s = $roleStyles[$roleName] ?? $roleStyles['technician'];
            $isMe = $user->id === auth()->id();
            @endphp
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                             style="background:{{ $s['bg'] }};border:1px solid {{ $s['border'] }};color:{{ $s['color'] }}">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-100">{{ $user->name }}
                                @if($isMe) <span class="text-xs px-1.5 py-0.5 rounded ml-1" style="background:#1e2a42;color:#818cf8">Tú</span>@endif
                            </p>
                        </div>
                    </div>
                </td>
                <td class="text-sm" style="color:#9ca3af">{{ $user->email }}</td>
                <td>
                    <span class="badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};border:1px solid {{ $s['border'] }}">
                        {{ ucfirst(str_replace('_',' ',$roleName)) }}
                    </span>
                </td>
                <td class="text-sm" style="color:#6b7280">{{ $user->created_at->format('d M Y') }}</td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.usuarios.edit', $user) }}" class="btn btn-ghost btn-sm">Editar</a>
                        @if(!$isMe)
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}"
                              onsubmit="return confirm('¿Eliminar a {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:#7f1d1d30;color:#fca5a5;border:1px solid #991b1b40">Eliminar</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-12 text-center" style="color:#4b5563">No se encontraron usuarios</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="mt-4">{{ $users->appends(request()->query())->links() }}</div>
@endif
@endsection
