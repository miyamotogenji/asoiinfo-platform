@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY'))

@section('content')

{{-- ── Welcome banner ──────────────────────────────────────────────────────── --}}
<div class="relative mb-6 rounded-2xl overflow-hidden px-6 py-5"
     style="background:linear-gradient(135deg,#1e1b4b 0%,#1e3a5f 60%,#064e3b 100%);border:1px solid #2d3a5a">
    <div class="relative z-10">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <p class="text-xs font-semibold mb-1" style="color:#818cf8">
                    ✦ Bienvenido, {{ auth()->user()->name }}
                </p>
                <h1 class="text-xl font-extrabold text-white tracking-tight">ASOIINFO — Plataforma Multiempresa</h1>
                <p class="text-sm mt-1" style="color:#a5b4fc">M0 + M1 completados · Demostrando al cliente hoy</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                      style="background:#27ae6030;border:1px solid #27ae6060;color:#6ee7b7">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse-dot inline-block"></span>
                    M0 Completado
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                      style="background:#27ae6030;border:1px solid #27ae6060;color:#6ee7b7">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse-dot inline-block"></span>
                    M1 Completado
                </span>
                <a href="{{ route('admin.milestone-download') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
                   style="background:#6366f130;border:1px solid #6366f160;color:#a5b4fc"
                   onmouseover="this.style.background='#6366f150'" onmouseout="this.style.background='#6366f130'">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Plan 20 días (.xlsx)
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── KPI Cards ─────────────────────────────────────────────────────────────── --}}
@php
use App\Models\User;
use App\Models\LegalEntity;
use App\Models\Contact;
use App\Models\Plan;
$userCount    = User::count();
$entityCount  = LegalEntity::count();
$contactCount = Contact::count();
$planCount    = Plan::where('status','active')->count();
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Grupos + Sucursales --}}
    <div class="card-glass stat-card-gradient-indigo p-5 rounded-2xl">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#1e1b4b50">
                <svg class="w-5 h-5" style="color:#818cf8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="badge badge-active" style="font-size:10px">CRM</span>
        </div>
        <p class="text-2xl font-extrabold text-white">{{ $stats['groups'] }}</p>
        <p class="text-xs font-semibold mt-1" style="color:#818cf8">Grupos empresariales</p>
        <p class="text-xs mt-0.5" style="color:#4b5563">{{ $stats['branches'] }} sucursales · {{ $entityCount }} empresas</p>
    </div>

    {{-- Contactos --}}
    <div class="card-glass p-5 rounded-2xl" style="background:linear-gradient(135deg,#0c4a6e15,#0c4a6e08);border-color:#0284c740">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#0c4a6e50">
                <svg class="w-5 h-5" style="color:#7dd3fc" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-white">{{ $contactCount }}</p>
        <p class="text-xs font-semibold mt-1" style="color:#7dd3fc">Contactos registrados</p>
        <p class="text-xs mt-0.5" style="color:#4b5563">{{ $planCount }} planes activos</p>
    </div>

    {{-- Usuarios & Roles --}}
    <div class="card-glass p-5 rounded-2xl" style="background:linear-gradient(135deg,#4c1d9515,#4c1d9508);border-color:#7c3aed40">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#4c1d9550">
                <svg class="w-5 h-5" style="color:#c4b5fd" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="badge" style="background:#4c1d9530;color:#c4b5fd;border-color:#7c3aed40;font-size:10px">RBAC</span>
        </div>
        <p class="text-2xl font-extrabold text-white">{{ $userCount }}</p>
        <p class="text-xs font-semibold mt-1" style="color:#c4b5fd">Usuarios del sistema</p>
        <p class="text-xs mt-0.5" style="color:#4b5563">6 roles configurados</p>
    </div>

    {{-- Por cobrar (phase 2 preview) --}}
    <div class="card-glass p-5 rounded-2xl" style="background:linear-gradient(135deg,#7f1d1d10,#7f1d1d08);border-color:#9919194d">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#7f1d1d50">
                <svg class="w-5 h-5" style="color:#f87171" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full" style="background:#0ea5e920;color:#38bdf8;border:1px solid #0ea5e930;font-size:10px">M2</span>
        </div>
        <p class="text-2xl font-extrabold text-white">${{ number_format($stats['total_receivable'], 0) }}</p>
        <p class="text-xs font-semibold mt-1" style="color:#f87171">Por cobrar (CxC)</p>
        <p class="text-xs mt-0.5" style="color:#4b5563">Facturación automática en M2</p>
    </div>
</div>

{{-- ── Alerts ──────────────────────────────────────────────────────────────────── --}}
@if($stats['blocked_clients'] > 0)
<div class="flex items-center gap-3 mb-4 px-4 py-3 rounded-xl text-sm"
     style="background:#7f1d1d20;border:1px solid #9919194d;color:#f87171">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
    </svg>
    <span><strong>{{ $stats['blocked_clients'] }}</strong> sucursales bloqueadas actualmente.
        <a href="{{ route('admin.sucursales.index', ['status'=>'blocked']) }}" style="color:#fca5a5;text-decoration:underline">Ver sucursales →</a>
    </span>
</div>
@endif

{{-- ── Quick Actions ───────────────────────────────────────────────────────────── --}}
<div class="mb-6">
    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#374151">Acciones rápidas — M0 & M1</p>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
    @php
    $actions = [
        ['Nuevo grupo',     route('admin.grupos.create'),     '#1e1b4b', '#818cf8', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['Nueva empresa',   route('admin.empresas.create'),   '#1e3a5f', '#60a5fa', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['Nueva sucursal',  route('admin.sucursales.create'), '#064e3b', '#34d399', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Nuevo contacto',  route('admin.contactos.create'),  '#0c4a6e', '#7dd3fc', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['Nuevo plan',      route('admin.planes.create'),     '#065f46', '#6ee7b7', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['Usuarios',        route('admin.usuarios.index'),    '#4c1d95', '#c4b5fd', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['Finanzas',        route('admin.reports.financial'), '#1a3a2a', '#10b981', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        ['Soporte',         route('admin.reports.support'),   '#1a2a3a', '#93c5fd', 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'],
    ];
    @endphp
    @foreach($actions as [$label, $href, $bg, $color, $path])
    <a href="{{ $href }}"
       class="flex flex-col items-center gap-2.5 p-4 rounded-2xl transition-all duration-200 group"
       style="background:{{ $bg }}25;border:1px solid {{ $bg }}50"
       onmouseover="this.style.background='{{ $bg }}45';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px {{ $bg }}30'"
       onmouseout="this.style.background='{{ $bg }}25';this.style.transform='none';this.style.boxShadow='none'">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $bg }}60">
            <svg class="w-4 h-4" style="color:{{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
            </svg>
        </div>
        <span class="text-xs font-semibold text-center leading-tight" style="color:{{ $color }}">{{ $label }}</span>
    </a>
    @endforeach
    </div>
</div>

{{-- ── Two columns: CRM summary + M2 Preview ─────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- CRM Summary --}}
    <div class="card-glass rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #1a2235">
            <div>
                <h3 class="text-sm font-semibold text-gray-200">CRM — Vista general</h3>
                <p class="text-xs mt-0.5" style="color:#6b7280">Grupos, sucursales y estados</p>
            </div>
            <a href="{{ route('admin.grupos.index') }}" class="btn btn-ghost btn-sm">Ver grupos →</a>
        </div>
        <table class="w-full data-table">
            <thead><tr>
                <th class="text-left text-xs" style="color:#6b7280">Sucursal</th>
                <th class="text-left text-xs" style="color:#6b7280">Grupo</th>
                <th class="text-center text-xs" style="color:#6b7280">Estado</th>
                <th class="text-right text-xs" style="color:#6b7280">Acciones</th>
            </tr></thead>
            <tbody style="border-top:1px solid #1a2235">
            @php
            $branches = \App\Models\Branch::with('businessGroup')->latest()->limit(6)->get();
            @endphp
            @forelse($branches as $b)
            <tr style="border-top:1px solid #1a2235">
                <td>
                    <p class="text-xs font-semibold text-gray-200">{{ $b->name }}</p>
                    <p class="text-xs font-mono" style="color:#4b5563">{{ $b->code }}</p>
                </td>
                <td class="text-xs" style="color:#9ca3af">{{ $b->businessGroup->name ?? '—' }}</td>
                <td class="text-center">
                    @if($b->status==='active')    <span class="badge badge-active">Activa</span>
                    @elseif($b->status==='blocked')<span class="badge badge-blocked">Bloqueada</span>
                    @else                          <span class="badge badge-pending">{{ ucfirst($b->status) }}</span>
                    @endif
                </td>
                <td class="text-right">
                    <a href="{{ route('admin.sucursales.360', $b) }}"
                       class="text-xs" style="color:#818cf8">360°</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-8 text-center text-xs" style="color:#4b5563">Sin sucursales aún</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Next Steps — M2 Preview --}}
    <div class="space-y-4">

        {{-- M2 coming --}}
        <div class="card-glass rounded-2xl p-5" style="background:linear-gradient(135deg,#0c2a3a15,#0c2a3a08);border-color:#0284c730">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#0284c720;border:1px solid #0284c740">
                    <svg class="w-4 h-4" style="color:#38bdf8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#7dd3fc">Próximo: M2 — Facturación & CxC</p>
                    <p class="text-xs" style="color:#4b5563">Días 4–6 del plan de trabajo</p>
                </div>
            </div>
            <div class="space-y-2">
                @foreach(['Generación automática de facturas PDF','Cuentas por cobrar (CxC) en tiempo real','Webhook de pago (PayPhone/banco)','Bloqueo automático por mora'] as $item)
                <div class="flex items-center gap-2 text-xs" style="color:#6b7280">
                    <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#0284c7"></div>
                    {{ $item }}
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.invoices.to-emit') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold" style="color:#38bdf8">
                Ver plan M2 →
            </a>
        </div>

        {{-- M1 completion checklist --}}
        <div class="card-glass rounded-2xl p-5">
            <p class="text-sm font-semibold mb-4 text-gray-200">M1 — Estado de módulos</p>
            <div class="space-y-2.5">
            @php
            $modules = [
                ['Grupos empresariales CRUD',    route('admin.grupos.index'),      true],
                ['Empresas legales (RUC)',        route('admin.empresas.index'),    true],
                ['Sucursales + bloqueo',          route('admin.sucursales.index'),  true],
                ['Vista 360° de sucursal',        '#',                              true],
                ['Contactos',                     route('admin.contactos.index'),   true],
                ['Catálogo de planes',            route('admin.planes.index'),      true],
                ['Servicios contratados',         route('admin.servicios.index'),   true],
                ['Usuarios y 6 roles RBAC',       route('admin.usuarios.index'),    true],
                ['Reporte financiero',            route('admin.reports.financial'), true],
                ['Reporte soporte',               route('admin.reports.support'),   true],
                ['API REST (Sanctum)',             '#',                              true],
            ];
            @endphp
            @foreach($modules as [$name, $href, $done])
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    @if($done)
                    <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:#10b981" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    @else
                    <div class="w-3.5 h-3.5 rounded-full flex-shrink-0" style="border:2px solid #374151"></div>
                    @endif
                    <span class="text-xs truncate" style="color:{{ $done ? '#d1fae5' : '#6b7280' }}">{{ $name }}</span>
                </div>
                @if($href !== '#' && $done)
                <a href="{{ $href }}" class="text-xs flex-shrink-0" style="color:#4b5563"
                   onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#4b5563'">abrir →</a>
                @endif
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
