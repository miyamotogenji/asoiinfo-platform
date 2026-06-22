@extends('layouts.admin')
@section('title', $group->name)
@section('breadcrumb', 'CRM → Grupos → ' . $group->name)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.grupos.index') }}" class="btn btn-ghost btn-sm">← Grupos</a>
        <div>
            <div class="flex items-center gap-2">
                <h2 class="page-heading">{{ $group->name }}</h2>
                @if($group->status==='active')
                    <span class="badge badge-active">Activo</span>
                @else
                    <span class="badge badge-blocked">{{ ucfirst($group->status) }}</span>
                @endif
            </div>
            <p class="page-sub">Grupo empresarial · Código: <code style="color:#818cf8">{{ $group->code }}</code></p>
        </div>
    </div>
    <a href="{{ route('admin.grupos.edit', $group) }}" class="btn btn-ghost">Editar</a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $cards = [
        ['Empresas (RUC)',     $group->legalEntities->count(),    '#1e1b4b', '#818cf8'],
        ['Sucursales activas', $group->branches->where('status','active')->count(), '#064e3b','#34d399'],
        ['Por cobrar',         '$'.number_format($group->branches->sum(fn($b) => $b->accountsReceivable->whereIn('status',['pending','overdue','partial'])->sum('balance')),0), '#7f1d1d','#f87171'],
        ['Contactos',          $group->contacts->count(),          '#1e3a5f', '#60a5fa'],
    ];
    @endphp
    @foreach($cards as [$label, $val, $bg, $color])
    <div class="card-glass p-5" style="background:{{ $bg }}15;border-color:{{ $bg }}60">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">{{ $label }}</p>
        <p class="text-2xl font-bold" style="color:{{ $color }}">{{ $val }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Entities --}}
    <div class="card-glass overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Empresas registradas ({{ $group->legalEntities->count() }})</h3>
            <a href="{{ route('admin.empresas.create') }}" class="btn btn-ghost btn-sm">+ Agregar</a>
        </div>
        @forelse($group->legalEntities as $entity)
        <div class="flex items-center justify-between px-5 py-3" style="border-top:1px solid #1a2235">
            <div>
                <p class="text-sm font-medium text-gray-200">{{ $entity->legal_name }}</p>
                <code class="text-xs font-mono" style="color:#818cf8">{{ $entity->ruc }}</code>
            </div>
            <div class="flex items-center gap-2">
                @if($entity->status==='active') <span class="badge badge-active">Activa</span>
                @else <span class="badge badge-blocked">{{ ucfirst($entity->status) }}</span> @endif
                <a href="{{ route('admin.empresas.edit', $entity) }}" class="btn btn-ghost btn-sm">Editar</a>
            </div>
        </div>
        @empty
        <div class="py-8 text-center text-xs" style="color:#6b7280">Sin empresas registradas</div>
        @endforelse
    </div>

    {{-- Branches --}}
    <div class="card-glass overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Sucursales ({{ $group->branches->count() }})</h3>
            <a href="{{ route('admin.sucursales.create') }}" class="btn btn-ghost btn-sm">+ Agregar</a>
        </div>
        @forelse($group->branches as $branch)
        <div class="flex items-center justify-between px-5 py-3" style="border-top:1px solid #1a2235">
            <div>
                <p class="text-sm font-medium text-gray-200">{{ $branch->name }}</p>
                <p class="text-xs" style="color:#6b7280">{{ $branch->city }} · Día {{ $branch->billing_day }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if($branch->status==='active')  <span class="badge badge-active">Activa</span>
                @elseif($branch->status==='blocked') <span class="badge badge-blocked">Bloqueada</span>
                @else <span class="badge badge-pending">{{ ucfirst($branch->status) }}</span> @endif
                <a href="{{ route('admin.sucursales.360', $branch) }}" class="btn btn-ghost btn-sm">360°</a>
            </div>
        </div>
        @empty
        <div class="py-8 text-center text-xs" style="color:#6b7280">Sin sucursales registradas</div>
        @endforelse
    </div>

    {{-- Contacts --}}
    <div class="card-glass overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Contactos principales ({{ $group->contacts->count() }})</h3>
        </div>
        @forelse($group->contacts->take(5) as $c)
        <div class="flex items-center justify-between px-5 py-3" style="border-top:1px solid #1a2235">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                     style="background:linear-gradient(135deg,#6366f1,#4f46e5)">{{ strtoupper(substr($c->name??'?',0,2)) }}</div>
                <div>
                    <p class="text-sm font-medium text-gray-200">{{ $c->name }}</p>
                    <p class="text-xs" style="color:#6b7280">{{ $c->position ?? $c->email ?? '—' }}</p>
                </div>
            </div>
            @if($c->whatsapp)
                <a href="https://wa.me/{{ $c->whatsapp }}" target="_blank" class="text-xs" style="color:#25d366">{{ $c->whatsapp }}</a>
            @endif
        </div>
        @empty
        <div class="py-8 text-center text-xs" style="color:#6b7280">Sin contactos</div>
        @endforelse
    </div>

    {{-- Group info --}}
    <div class="card-glass p-5">
        <h3 class="text-sm font-semibold text-gray-200 mb-4">Datos del grupo</h3>
        <div class="space-y-3">
            @foreach([
                ['Código', $group->code],
                ['Estado', ucfirst($group->status)],
                ['Dirección', $group->address ?? '—'],
                ['Teléfono', $group->phone ?? '—'],
                ['Email facturación', $group->billing_email ?? '—'],
                ['Registrado', $group->created_at->format('d/m/Y')],
                ['Observaciones', $group->observations ?? '—'],
            ] as [$label, $val])
            <div class="flex justify-between gap-4">
                <span class="text-xs" style="color:#6b7280">{{ $label }}</span>
                <span class="text-xs font-medium text-gray-300 text-right">{{ $val }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
