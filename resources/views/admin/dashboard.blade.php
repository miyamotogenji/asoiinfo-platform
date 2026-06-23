@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY'))

@push('styles')
<style>
    .kpi-card {
        background:rgba(10,15,28,.85);
        border:1px solid rgba(30,42,66,.7);
        border-left:3px solid var(--card-accent);
        border-radius:20px;
        padding:22px 22px 18px;
        position:relative; overflow:hidden;
        transition:transform .2s, box-shadow .2s;
    }
    .kpi-card:hover { transform:translateY(-3px); box-shadow:0 16px 40px rgba(0,0,0,.35),0 0 30px var(--card-shadow) }
    .kpi-card::before {
        content:''; position:absolute; inset:0; opacity:.08;
        background:radial-gradient(ellipse at 0% 50%, var(--card-glow-color) 0%, transparent 60%);
        border-radius:20px;
    }

    .quick-btn {
        display:inline-flex; align-items:center; gap:9px;
        padding:13px 22px; border-radius:12px;
        font-size:.87rem; font-weight:700; cursor:pointer;
        border:none; font-family:inherit; text-decoration:none;
        transition:all .2s; white-space:nowrap; color:#fff;
    }
    .quick-btn:hover { transform:translateY(-2px); filter:brightness(1.12); box-shadow:0 8px 24px rgba(0,0,0,.3) }
    .quick-btn:active { transform:translateY(0); filter:brightness(.95) }

    .crm-row { transition:background .15s }
    .crm-row:hover { background:rgba(99,102,241,.06) }

    /* Gradient heading */
    .gradient-heading {
        background:linear-gradient(135deg,#818cf8 0%,#a855f7 40%,#c084fc 70%,#818cf8 100%);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        background-clip:text;
        background-size:200% auto;
        animation:gradientShift 4s linear infinite;
    }
    @keyframes gradientShift { 0%{background-position:0% 50%} 100%{background-position:200% 50%} }

    /* Sparkline */
    .spark { width:80px; height:28px; opacity:.7 }

    /* Section label */
    .section-label {
        font-size:.68rem; font-weight:700; letter-spacing:.14em;
        text-transform:uppercase; color:#6b7280; margin-bottom:14px;
    }
</style>
@endpush

@section('content')

@php
use App\Models\User;
use App\Models\LegalEntity;
use App\Models\Contact;
use App\Models\Plan;
use App\Models\Branch;
$userCount    = User::count();
$entityCount  = LegalEntity::count();
$contactCount = Contact::count();
$planCount    = Plan::where('status','active')->count();
$branchCount  = Branch::count();
$blockedCount = Branch::where('status','blocked')->count();
$groupCount   = $stats['groups'] ?? 0;
$latest       = LegalEntity::with('businessGroup')->latest()->limit(7)->get();
@endphp

{{-- ══ HEADING ═══════════════════════════════════════════════════════════════ --}}
<div class="mb-7">
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div>
            <p class="text-xs font-semibold mb-1.5" style="color:#374151;letter-spacing:.08em;text-transform:uppercase">
                ✦ Bienvenido, {{ auth()->user()->name }}
            </p>
            <h1 class="text-3xl font-extrabold gradient-heading tracking-tight" style="letter-spacing:-.04em">
                ASOIINFO — Plataforma Multiempresa
            </h1>
            <p class="text-sm mt-2" style="color:#4b5563">
                M0 + M1 completados &nbsp;·&nbsp; {{ now()->locale('es')->isoFormat('D [de] MMMM YYYY') }}
            </p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                  style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);color:#34d399">
                <span class="w-1.5 h-1.5 rounded-full animate-pulse-dot inline-block" style="background:#34d399"></span>
                M0 + M1 Live
            </span>
            <a href="{{ route('admin.milestone-download') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
               style="background:rgba(99,102,241,.12);border:1px solid rgba(99,102,241,.25);color:#818cf8"
               onmouseover="this.style.background='rgba(99,102,241,.22)'" onmouseout="this.style.background='rgba(99,102,241,.12)'">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Plan 20 días (.xlsx)
            </a>
        </div>
    </div>
</div>

{{-- ══ KPI CARDS ══════════════════════════════════════════════════════════════ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

    {{-- Sucursales --}}
    <div class="kpi-card" style="--card-accent:#6366f1;--card-shadow:rgba(99,102,241,.2);--card-glow-color:#6366f1">
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(99,102,241,.18);border:1px solid rgba(99,102,241,.35)">
                <svg class="w-7 h-7" style="color:#818cf8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <svg class="spark" viewBox="0 0 80 28" fill="none">
                <polyline points="0,22 14,16 28,18 42,10 56,14 70,6 80,8" stroke="#6366f1" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="0,22 14,16 28,18 42,10 56,14 70,6 80,8 80,28 0,28" fill="url(#g1)" opacity=".3"/>
                <defs><linearGradient id="g1" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#6366f1"/><stop offset="100%" stop-color="transparent"/></linearGradient></defs>
            </svg>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color:#818cf8;letter-spacing:.08em">TOTAL SUCURSALES</p>
        <p class="text-4xl font-extrabold text-white tracking-tight">{{ $branchCount }}</p>
        <p class="text-xs mt-1.5" style="color:#6b7280">Sucursales activas</p>
        <div class="flex items-center gap-2 mt-3 pt-3" style="border-top:1px solid rgba(30,42,66,.5)">
            <span style="font-size:.72rem;color:#818cf8;font-weight:700">↑ 25%</span>
            <span style="font-size:.68rem;color:#4b5563">vs. mes anterior</span>
        </div>
    </div>

    {{-- Usuarios --}}
    <div class="kpi-card" style="--card-accent:#10b981;--card-shadow:rgba(16,185,129,.2);--card-glow-color:#10b981">
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.35)">
                <svg class="w-7 h-7" style="color:#34d399" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <svg class="spark" viewBox="0 0 80 28" fill="none">
                <polyline points="0,24 16,20 32,22 48,14 64,16 80,10" stroke="#10b981" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="0,24 16,20 32,22 48,14 64,16 80,10 80,28 0,28" fill="url(#g2)" opacity=".3"/>
                <defs><linearGradient id="g2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#10b981"/><stop offset="100%" stop-color="transparent"/></linearGradient></defs>
            </svg>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color:#34d399;letter-spacing:.08em">USUARIOS</p>
        <p class="text-4xl font-extrabold text-white tracking-tight">{{ $userCount }}</p>
        <p class="text-xs mt-1.5" style="color:#6b7280">Usuarios activos</p>
        <div class="flex items-center gap-2 mt-3 pt-3" style="border-top:1px solid rgba(30,42,66,.5)">
            <span style="font-size:.72rem;color:#34d399;font-weight:700">↑ 50%</span>
            <span style="font-size:.68rem;color:#4b5563">vs. mes anterior</span>
        </div>
    </div>

    {{-- Grupos --}}
    <div class="kpi-card" style="--card-accent:#f59e0b;--card-shadow:rgba(245,158,11,.2);--card-glow-color:#f59e0b">
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.35)">
                <svg class="w-7 h-7" style="color:#fbbf24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <svg class="spark" viewBox="0 0 80 28" fill="none">
                <polyline points="0,22 20,18 40,20 60,12 80,14" stroke="#f59e0b" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="0,22 20,18 40,20 60,12 80,14 80,28 0,28" fill="url(#g3)" opacity=".3"/>
                <defs><linearGradient id="g3" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#f59e0b"/><stop offset="100%" stop-color="transparent"/></linearGradient></defs>
            </svg>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color:#fbbf24;letter-spacing:.08em">GRUPOS</p>
        <p class="text-4xl font-extrabold text-white tracking-tight">{{ $groupCount }}</p>
        <p class="text-xs mt-1.5" style="color:#6b7280">Grupos definidos</p>
        <div class="flex items-center gap-2 mt-3 pt-3" style="border-top:1px solid rgba(30,42,66,.5)">
            <span style="font-size:.72rem;color:#fbbf24;font-weight:700">→ 0%</span>
            <span style="font-size:.68rem;color:#4b5563">vs. mes anterior</span>
        </div>
    </div>

    {{-- Bloqueadas --}}
    <div class="kpi-card" style="--card-accent:#ef4444;--card-shadow:rgba(239,68,68,.2);--card-glow-color:#ef4444">
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.35)">
                <svg class="w-7 h-7" style="color:#f87171" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <svg class="spark" viewBox="0 0 80 28" fill="none">
                <polyline points="0,10 20,14 40,8 60,18 80,12" stroke="#ef4444" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="0,10 20,14 40,8 60,18 80,12 80,28 0,28" fill="url(#g4)" opacity=".3"/>
                <defs><linearGradient id="g4" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#ef4444"/><stop offset="100%" stop-color="transparent"/></linearGradient></defs>
            </svg>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide mb-1" style="color:#f87171;letter-spacing:.08em">BLOQUEADAS</p>
        <p class="text-4xl font-extrabold text-white tracking-tight">{{ $blockedCount }}</p>
        <p class="text-xs mt-1.5" style="color:#6b7280">Sucursales bloqueadas</p>
        <div class="flex items-center gap-2 mt-3 pt-3" style="border-top:1px solid rgba(30,42,66,.5)">
            <span style="font-size:.72rem;color:#f87171;font-weight:700">↓ 50%</span>
            <span style="font-size:.68rem;color:#4b5563">vs. mes anterior</span>
        </div>
    </div>
</div>

{{-- ══ QUICK ACTIONS ═══════════════════════════════════════════════════════════ --}}
<div class="mb-7">
    <p class="section-label">Accesos Rápidos</p>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.grupos.create') }}" class="quick-btn"
           style="background:#3b82f6;box-shadow:0 4px 14px rgba(59,130,246,.35)">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nueva Empresa
        </a>
        <a href="{{ route('admin.contactos.create') }}" class="quick-btn"
           style="background:#3b82f6;box-shadow:0 4px 14px rgba(59,130,246,.35)">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Nuevo Contacto
        </a>
        <a href="{{ route('admin.planes.create') }}" class="quick-btn"
           style="background:#10b981;box-shadow:0 4px 14px rgba(16,185,129,.35)">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Nueva Factura
        </a>
        <a href="{{ route('admin.servicios.index') }}" class="quick-btn"
           style="background:#f59e0b;box-shadow:0 4px 14px rgba(245,158,11,.35)">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v12m-4-4l4 4 4-4M4 20h16"/></svg>
            Registrar Pago
        </a>
        <a href="{{ route('admin.reports.financial') }}" class="quick-btn"
           style="background:#8b5cf6;box-shadow:0 4px 14px rgba(139,92,246,.35)">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Ver Reportes
        </a>
    </div>
</div>

{{-- ══ CRM TABLE ══════════════════════════════════════════════════════════════ --}}
<div class="rounded-2xl overflow-hidden" style="background:rgba(8,13,26,.85);border:1px solid rgba(30,42,66,.7)">

    {{-- Table header --}}
    <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid rgba(30,42,66,.6)">
        <div>
            <h3 class="text-sm font-bold text-white tracking-tight">Últimas Empresas CRM</h3>
            <p class="text-xs mt-0.5" style="color:#374151">Registro de personas jurídicas y grupos</p>
        </div>
        <a href="{{ route('admin.empresas.index') }}"
           class="text-xs font-semibold transition-colors"
           style="color:#6366f1"
           onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6366f1'">
            Ver todas &rsaquo;
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full" style="border-collapse:collapse">
            <thead>
                <tr style="background:rgba(4,8,16,.8)">
                    <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color:#6b7280;letter-spacing:.1em">Empresa</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color:#6b7280;letter-spacing:.1em">Grupo</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider hidden md:table-cell" style="color:#6b7280;letter-spacing:.1em">RUC</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider hidden lg:table-cell" style="color:#6b7280;letter-spacing:.1em">Ciudad</th>
                    <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider" style="color:#6b7280;letter-spacing:.1em">Estado</th>
                    <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider" style="color:#6b7280;letter-spacing:.1em">Creado el</th>
                </tr>
            </thead>
            <tbody>
            @php
            $avatarColors = [
                ['bg'=>'rgba(59,130,246,.2)','color'=>'#60a5fa'],
                ['bg'=>'rgba(16,185,129,.2)','color'=>'#34d399'],
                ['bg'=>'rgba(245,158,11,.2)','color'=>'#fbbf24'],
                ['bg'=>'rgba(239,68,68,.2)','color'=>'#f87171'],
                ['bg'=>'rgba(139,92,246,.2)','color'=>'#a78bfa'],
                ['bg'=>'rgba(20,184,166,.2)','color'=>'#2dd4bf'],
                ['bg'=>'rgba(236,72,153,.2)','color'=>'#f472b6'],
            ];
            @endphp
            @forelse($latest as $idx => $e)
            @php $ac = $avatarColors[$idx % count($avatarColors)]; @endphp
            <tr class="crm-row" style="border-top:1px solid rgba(30,42,66,.4)">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0"
                             style="background:{{ $ac['bg'] }};color:{{ $ac['color'] }}">
                            {{ strtoupper(substr($e->trade_name ?? $e->legal_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color:#e2e8f0">{{ $e->trade_name ?? $e->legal_name }}</p>
                            <p class="text-xs font-mono" style="color:#374151">{{ $e->legal_name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-sm" style="color:#6b7280">{{ $e->businessGroup->name ?? '—' }}</td>
                <td class="px-4 py-4 text-xs font-mono hidden md:table-cell" style="color:#4b5563">{{ $e->ruc ?? '—' }}</td>
                <td class="px-4 py-4 text-sm hidden lg:table-cell" style="color:#6b7280">{{ $e->city ?? 'Ecuador' }}</td>
                <td class="px-4 py-4 text-center">
                    @if(($e->status ?? 'active') === 'active')
                        <span class="badge badge-active">Activa</span>
                    @else
                        <span class="badge badge-blocked">Inactiva</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-right text-xs" style="color:#374151">
                    {{ $e->created_at->format('d/m/Y') }}
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-12 text-center text-sm" style="color:#374151">Sin empresas registradas aún.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
