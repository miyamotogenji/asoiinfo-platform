<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ASOIINFO') — ASOIINFO Platform</title>

    {{-- Premium fonts: Plus Jakarta Sans + JetBrains Mono --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        base: { 950: '#060b14', 900: '#090e1a', 800: '#0f1623', 700: '#151d2e', 600: '#1c2640' },
                        surface: { DEFAULT: '#111827', hover: '#1a2235', active: '#1e2a42' },
                        brand: { 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca' },
                    },
                    boxShadow: {
                        'glow-indigo': '0 0 20px rgba(99,102,241,0.15)',
                        'glow-green': '0 0 20px rgba(16,185,129,0.15)',
                        'glow-red': '0 0 20px rgba(239,68,68,0.15)',
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <style>
        [x-cloak]{display:none!important}
        * { font-feature-settings: "cv02","cv03","cv04","cv11" }

        /* Scrollbar */
        ::-webkit-scrollbar { width:5px; height:5px }
        ::-webkit-scrollbar-track { background:#0f1623 }
        ::-webkit-scrollbar-thumb { background:#2d3748; border-radius:4px }
        ::-webkit-scrollbar-thumb:hover { background:#6366f1 }

        /* Navigation */
        .nav-link {
            display:flex; align-items:center; gap:10px;
            padding:9px 12px; border-radius:10px;
            font-size:.8rem; font-weight:500;
            color:#6b7280; text-decoration:none;
            transition:all .15s; border:1px solid transparent;
        }
        .nav-link:hover { background:#1a2235; color:#e5e7eb; border-color:#1e2a42 }
        .nav-link.active {
            background:linear-gradient(135deg,#1e2a42,#1a2235);
            color:#818cf8; border-color:#2d3a5a;
            box-shadow:0 0 12px rgba(99,102,241,.12);
        }
        .nav-link.active .nav-icon { color:#6366f1 }

        /* Cards */
        .card-glass {
            background:linear-gradient(135deg,#111827,#0f1623);
            border:1px solid #1e2a42; border-radius:14px;
        }
        .stat-card-gradient-indigo { background:linear-gradient(135deg,#1e1b4b10,#1e1b4b30); border-color:#3730a360 }
        .stat-card-gradient-emerald { background:linear-gradient(135deg,#064e3b10,#064e3b30); border-color:#06543660 }
        .stat-card-gradient-amber { background:linear-gradient(135deg,#78350f10,#78350f30); border-color:#92400e60 }
        .stat-card-gradient-red { background:linear-gradient(135deg,#7f1d1d10,#7f1d1d30); border-color:#991b1b60 }

        /* Table */
        .data-table thead tr { background:rgba(9,14,26,.8) }
        .data-table tbody tr { transition:background .1s }
        .data-table tbody tr:hover { background:rgba(26,34,53,.5) }
        .data-table td,.data-table th { padding:12px 16px }

        /* Badges */
        .badge-active   { background:#064e3b40; color:#6ee7b7; border:1px solid #06543640 }
        .badge-blocked  { background:#7f1d1d40; color:#fca5a5; border:1px solid #991b1b40 }
        .badge-pending  { background:#78350f40; color:#fcd34d; border:1px solid #92400e40 }
        .badge-overdue  { background:#7f1d1d40; color:#f87171; border:1px solid #b91c1c40 }
        .badge-paid     { background:#064e3b40; color:#34d399; border:1px solid #06543640 }
        .badge-info     { background:#1e3a5f40; color:#93c5fd; border:1px solid #1e40af40 }
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:.72rem; font-weight:600 }

        /* Input */
        .form-input {
            width:100%; background:#090e1a; border:1px solid #1e2a42;
            border-radius:10px; padding:10px 14px;
            font-size:.875rem; color:#e5e7eb;
            font-family:inherit; outline:none; transition:all .15s;
        }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1) }
        .form-input::placeholder { color:#374151 }
        select.form-input option { background:#111827 }
        textarea.form-input { resize:vertical }

        /* Buttons */
        .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; font-size:.825rem; font-weight:600; cursor:pointer; border:none; transition:all .15s; font-family:inherit; text-decoration:none }
        .btn-primary { background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; box-shadow:0 4px 14px rgba(99,102,241,.3) }
        .btn-primary:hover { background:linear-gradient(135deg,#818cf8,#6366f1); box-shadow:0 6px 20px rgba(99,102,241,.4) }
        .btn-success { background:linear-gradient(135deg,#059669,#047857); color:#fff; box-shadow:0 4px 14px rgba(5,150,105,.25) }
        .btn-success:hover { background:linear-gradient(135deg,#10b981,#059669) }
        .btn-danger { background:linear-gradient(135deg,#dc2626,#b91c1c); color:#fff }
        .btn-ghost { background:#1a2235; color:#9ca3af; border:1px solid #1e2a42 }
        .btn-ghost:hover { background:#1e2a42; color:#e5e7eb }
        .btn-sm { padding:6px 12px; font-size:.775rem; border-radius:8px }

        /* Page title */
        .page-heading { font-size:1.3rem; font-weight:700; color:#f9fafb; letter-spacing:-.02em }
        .page-sub { font-size:.825rem; color:#6b7280; margin-top:2px }

        /* Animations */
        @keyframes slideIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .animate-slide-in { animation:slideIn .2s ease }
        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
        .animate-pulse-dot { animation:pulse-dot 2s ease infinite }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-base-950 text-gray-100" style="font-family:'Plus Jakarta Sans',system-ui,sans-serif"
      x-data="{ sidebarOpen: false, notifOpen: false }">

{{-- Mobile overlay --}}
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"
     class="fixed inset-0 z-30 bg-black/70 backdrop-blur-sm lg:hidden"></div>

{{-- ══════════════════ SIDEBAR ══════════════════ --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col transition-transform duration-200 lg:translate-x-0"
       style="background:linear-gradient(180deg,#0d1421 0%,#090e1a 100%);border-right:1px solid #1a2235">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-4 py-4" style="border-bottom:1px solid #1a2235">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO Logo"
             class="h-10 w-auto object-contain rounded-xl flex-shrink-0"
             style="filter:drop-shadow(0 0 10px rgba(99,102,241,.5))">
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

        @php
        $pendingMsgs = \App\Models\Conversation::where('queue','new_messages')->count();
        $overdueCount = \App\Models\Branch::where('status','blocked')->count();
        @endphp

        {{-- Principal --}}
        <p class="px-3 pt-1 pb-2 text-xs font-700 tracking-widest uppercase" style="color:#374151;font-weight:700">Principal</p>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.chatbot.index') }}" class="nav-link opacity-50" style="cursor:default">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" style="color:#4b5563">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp Inbox
            <span class="ml-auto text-xs px-1.5 py-0.5 rounded" style="background:#25d36620;color:#25d366;font-size:10px">Fase 3</span>
        </a>

        {{-- Clientes --}}
        <p class="px-3 pt-4 pb-2 text-xs font-700 tracking-widest uppercase" style="color:#374151;font-weight:700">Clientes CRM</p>

        <a href="{{ route('admin.grupos.index') }}" class="nav-link {{ request()->routeIs('admin.grupos.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Grupos empresariales
        </a>

        <a href="{{ route('admin.empresas.index') }}" class="nav-link {{ request()->routeIs('admin.empresas.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Empresas (RUC)
        </a>

        <a href="{{ route('admin.sucursales.index') }}" class="nav-link {{ request()->routeIs('admin.sucursales.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Sucursales
            @if($overdueCount > 0)
                <span class="ml-auto text-xs font-bold px-1.5 py-0.5 rounded-full" style="background:#7f1d1d;color:#fca5a5">{{ $overdueCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.contactos.index') }}" class="nav-link {{ request()->routeIs('admin.contactos.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Contactos
        </a>

        {{-- Facturación — Phase 1 active ─────────────────────────────── --}}
        <p class="px-3 pt-4 pb-2 text-xs font-700 tracking-widest uppercase" style="color:#374151;font-weight:700">Facturación</p>

        <a href="{{ route('admin.planes.index') }}" class="nav-link {{ request()->routeIs('admin.planes.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Planes
        </a>

        <a href="{{ route('admin.servicios.index') }}" class="nav-link {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Servicios contratados
        </a>

        {{-- Phase 2 locked items ──────────────────────────────────────── --}}
        <div class="mt-2 mb-1 px-3">
            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-full" style="background:#0ea5e920;color:#0ea5e9;border:1px solid #0ea5e930">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Fase 2 — Próximamente
            </span>
        </div>

        <a href="{{ route('admin.invoices.to-emit') }}" class="nav-link opacity-50" style="cursor:default">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Facturas a emitir
            <span class="ml-auto text-xs px-1.5 py-0.5 rounded" style="background:#0ea5e920;color:#0ea5e9;font-size:10px">Fase 2</span>
        </a>

        <a href="{{ route('admin.invoices.index') }}" class="nav-link opacity-50" style="cursor:default">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Facturas emitidas
            <span class="ml-auto text-xs px-1.5 py-0.5 rounded" style="background:#0ea5e920;color:#0ea5e9;font-size:10px">Fase 2</span>
        </a>

        <a href="{{ route('admin.cxc.index') }}" class="nav-link opacity-50" style="cursor:default">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cuentas por cobrar
            <span class="ml-auto text-xs px-1.5 py-0.5 rounded" style="background:#0ea5e920;color:#0ea5e9;font-size:10px">Fase 2</span>
        </a>

        <a href="{{ route('admin.payments.index') }}" class="nav-link opacity-50" style="cursor:default">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Pagos recibidos
            <span class="ml-auto text-xs px-1.5 py-0.5 rounded" style="background:#0ea5e920;color:#0ea5e9;font-size:10px">Fase 2</span>
        </a>

        {{-- Download milestone plan ─────────────────────────────────── --}}
        <div class="mx-3 my-3 p-3 rounded-xl" style="background:#6366f110;border:1px solid #6366f120">
            <p class="text-xs font-semibold mb-1.5" style="color:#818cf8">Plan de hitos del proyecto</p>
            <a href="{{ route('admin.milestone-download') }}" class="flex items-center gap-2 text-xs" style="color:#6b7280" onmouseover="this.style.color='#818cf8'" onmouseout="this.style.color='#6b7280'">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Descargar Excel (.xlsx)
            </a>
        </div>

        {{-- Reportes --}}
        <p class="px-3 pt-4 pb-2 text-xs font-700 tracking-widest uppercase" style="color:#374151;font-weight:700">Reportes</p>

        <a href="{{ route('admin.reports.financial') }}" class="nav-link {{ request()->routeIs('admin.reports.financial') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Reporte financiero
        </a>

        <a href="{{ route('admin.reports.support') }}" class="nav-link {{ request()->routeIs('admin.reports.support') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Reporte atención
        </a>

        {{-- Administración --}}
        <p class="px-3 pt-4 pb-2 text-xs font-700 tracking-widest uppercase" style="color:#374151;font-weight:700">Administración</p>

        <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Usuarios y roles
        </a>
    </nav>

    {{-- User footer --}}
    <div class="px-3 py-4" style="border-top:1px solid #1a2235">
        <div class="flex items-center gap-3 px-2 py-2 rounded-xl" style="background:#0f1623">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5)">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-200 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs truncate" style="color:#4b5563">{{ auth()->user()->roles->first()->name ?? 'admin' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Salir" class="p-1.5 rounded-lg transition-colors" style="color:#4b5563" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#4b5563'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ══════════════════ MAIN ══════════════════ --}}
<div class="lg:pl-64 flex flex-col min-h-screen">

    {{-- Top bar --}}
    <header class="sticky top-0 z-20 px-4 lg:px-6 h-14 flex items-center gap-4 backdrop-blur-md"
            style="background:rgba(9,14,26,.85);border-bottom:1px solid #1a2235">

        <button @click="sidebarOpen=true" class="lg:hidden p-1.5 rounded-lg" style="color:#6b7280">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Breadcrumb --}}
        <div class="flex-1 min-w-0">
            <h1 class="text-sm font-semibold text-gray-100">@yield('title', 'Dashboard')</h1>
            @hasSection('breadcrumb')
                <p class="text-xs" style="color:#4b5563">@yield('breadcrumb')</p>
            @endif
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3">
            {{-- Notification bell --}}
            @php $msgs = \App\Models\Conversation::where('queue','new_messages')->count(); @endphp
            <a href="{{ route('admin.chatbot.index') }}" class="relative p-2 rounded-xl transition-colors" style="color:#6b7280" onmouseover="this.style.background='#1a2235'" onmouseout="this.style.background='transparent'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($msgs > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-xs font-bold flex items-center justify-center" style="background:#dc2626;color:#fff">{{ $msgs }}</span>
                @endif
            </a>

            {{-- Avatar --}}
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0 cursor-default"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5)" title="{{ auth()->user()->name }}">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-cloak x-init="setTimeout(()=>show=false,4500)"
             class="animate-slide-in mx-4 lg:mx-6 mt-4 flex items-center gap-3 rounded-xl px-4 py-3 text-sm"
             style="background:#064e3b30;border:1px solid #059669;color:#6ee7b7">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="flex-1">{{ session('success') }}</span>
            <button @click="show=false" class="opacity-60 hover:opacity-100 ml-2">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-cloak x-init="setTimeout(()=>show=false,6000)"
             class="animate-slide-in mx-4 lg:mx-6 mt-4 flex items-center gap-3 rounded-xl px-4 py-3 text-sm"
             style="background:#7f1d1d30;border:1px solid #dc2626;color:#fca5a5">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="flex-1">{{ session('error') }}</span>
            <button @click="show=false" class="opacity-60 hover:opacity-100 ml-2">✕</button>
        </div>
    @endif

    {{-- Content --}}
    <main class="flex-1 px-4 lg:px-6 py-6 animate-slide-in">
        @yield('content')
    </main>

    <footer class="px-6 py-3 text-xs text-center" style="border-top:1px solid #1a2235;color:#374151">
        ASOIINFO Platform · {{ now()->year }} · v2.0
    </footer>
</div>

@stack('scripts')
</body>
</html>
