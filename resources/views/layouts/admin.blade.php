<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ASOIINFO') — ASOIINFO Platform</title>

    {{-- Premium fonts: Inter + Space Grotesk --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', 'system-ui', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
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
        *, *::before, *::after { font-feature-settings:"cv02","cv03","cv04","cv11"; box-sizing:border-box }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width:4px; height:4px }
        ::-webkit-scrollbar-track { background:transparent }
        ::-webkit-scrollbar-thumb { background:#1e2a42; border-radius:4px }
        ::-webkit-scrollbar-thumb:hover { background:#6366f1 }

        /* ── Nav links ── */
        .nav-link {
            display:flex; align-items:center; gap:10px;
            padding:9px 13px; border-radius:12px;
            font-size:.815rem; font-weight:500; letter-spacing:-.005em;
            color:#4b5563; text-decoration:none;
            transition:all .18s ease;
        }
        .nav-link:hover {
            background:rgba(99,102,241,.08);
            color:#c7d2fe;
        }
        .nav-link.active {
            background:linear-gradient(135deg,rgba(99,102,241,.18),rgba(124,58,237,.12));
            color:#a5b4fc;
            box-shadow:inset 0 0 0 1px rgba(99,102,241,.2), 0 2px 12px rgba(99,102,241,.08);
        }
        .nav-link.active .nav-icon { color:#818cf8 }
        .nav-section {
            padding:18px 14px 8px;
            font-size:.67rem; font-weight:700;
            letter-spacing:.12em; text-transform:uppercase;
            color:#374151;
        }

        /* ── Cards ── */
        .card-glass {
            background:rgba(10,15,28,.8);
            border:1px solid rgba(30,42,66,.8);
            border-radius:18px;
            box-shadow:0 4px 24px rgba(0,0,0,.25);
        }
        .stat-card-gradient-indigo { background:linear-gradient(135deg,rgba(30,27,75,.35),rgba(30,27,75,.15)); border-color:rgba(55,48,163,.25) }
        .stat-card-gradient-emerald { background:linear-gradient(135deg,rgba(6,78,59,.35),rgba(6,78,59,.15)); border-color:rgba(6,84,54,.25) }
        .stat-card-gradient-amber   { background:linear-gradient(135deg,rgba(120,53,15,.35),rgba(120,53,15,.15)); border-color:rgba(146,64,14,.25) }
        .stat-card-gradient-red     { background:linear-gradient(135deg,rgba(127,29,29,.35),rgba(127,29,29,.15)); border-color:rgba(153,27,27,.25) }

        /* ── Tables ── */
        .data-table { border-collapse:separate; border-spacing:0 }
        .data-table thead th { background:rgba(5,9,18,.9); font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#374151; padding:12px 16px }
        .data-table thead th:first-child { border-radius:10px 0 0 10px }
        .data-table thead th:last-child  { border-radius:0 10px 10px 0 }
        .data-table tbody tr { transition:background .15s }
        .data-table tbody tr:hover td { background:rgba(99,102,241,.05) }
        .data-table td { padding:13px 16px; border-bottom:1px solid rgba(30,42,66,.4); font-size:.86rem }
        .data-table tbody tr:last-child td { border-bottom:none }

        /* ── Badges ── */
        .badge { display:inline-flex; align-items:center; gap:4px; padding:4px 11px; border-radius:20px; font-size:.7rem; font-weight:700; letter-spacing:.02em }
        .badge-active   { background:rgba(6,78,59,.3);  color:#34d399; border:1px solid rgba(6,84,54,.3) }
        .badge-blocked  { background:rgba(127,29,29,.3); color:#fca5a5; border:1px solid rgba(153,27,27,.3) }
        .badge-pending  { background:rgba(120,53,15,.3); color:#fcd34d; border:1px solid rgba(146,64,14,.3) }
        .badge-overdue  { background:rgba(127,29,29,.3); color:#f87171; border:1px solid rgba(185,28,28,.3) }
        .badge-paid     { background:rgba(6,78,59,.3);  color:#6ee7b7; border:1px solid rgba(6,84,54,.3) }
        .badge-info     { background:rgba(30,58,95,.3);  color:#93c5fd; border:1px solid rgba(30,64,175,.3) }

        /* ── Inputs ── */
        .form-input {
            width:100%; background:rgba(4,8,18,.9);
            border:1.5px solid rgba(30,42,66,.9);
            border-radius:12px; padding:11px 15px;
            font-size:.9rem; color:#e5e7eb;
            font-family:inherit; outline:none; transition:all .18s;
        }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.1), 0 0 16px rgba(99,102,241,.06) }
        .form-input::placeholder { color:#1f2937 }
        select.form-input option { background:#0d1420 }
        textarea.form-input { resize:vertical }

        /* ── Buttons ── */
        .btn {
            display:inline-flex; align-items:center; gap:7px;
            padding:10px 20px; border-radius:12px;
            font-size:.845rem; font-weight:600; letter-spacing:.01em;
            cursor:pointer; border:none; transition:all .2s ease;
            font-family:inherit; text-decoration:none; line-height:1;
        }
        .btn:hover { transform:translateY(-1px) }
        .btn:active { transform:translateY(0) }

        .btn-primary {
            background:linear-gradient(135deg,#6366f1,#4f46e5,#7c3aed);
            color:#fff;
            box-shadow:0 4px 18px rgba(99,102,241,.35), 0 1px 0 rgba(255,255,255,.1) inset;
        }
        .btn-primary:hover { box-shadow:0 8px 28px rgba(99,102,241,.5) }

        .btn-success {
            background:linear-gradient(135deg,#059669,#047857);
            color:#fff;
            box-shadow:0 4px 18px rgba(5,150,105,.3), 0 1px 0 rgba(255,255,255,.1) inset;
        }
        .btn-success:hover { box-shadow:0 8px 24px rgba(5,150,105,.45) }

        .btn-danger {
            background:linear-gradient(135deg,#dc2626,#b91c1c);
            color:#fff;
            box-shadow:0 4px 18px rgba(220,38,38,.3);
        }
        .btn-danger:hover { box-shadow:0 8px 24px rgba(220,38,38,.45) }

        .btn-ghost {
            background:rgba(15,22,40,.9);
            color:#9ca3af;
            border:1.5px solid rgba(30,42,66,.9);
        }
        .btn-ghost:hover { background:rgba(26,34,58,.9); color:#e5e7eb; border-color:rgba(99,102,241,.3) }

        .btn-sm { padding:7px 14px; font-size:.8rem; border-radius:10px; gap:5px }
        .btn-xs { padding:5px 11px; font-size:.75rem; border-radius:8px; gap:4px }

        /* ── Page heading ── */
        .page-heading { font-size:1.5rem; font-weight:700; color:#f1f5f9; letter-spacing:-.035em; line-height:1.2 }
        .page-sub { font-size:.85rem; color:#6b7280; margin-top:3px; line-height:1.4 }

        /* ── Animations ── */
        @keyframes slideIn { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        .animate-slide-in { animation:slideIn .25s ease }
        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.35} }
        .animate-pulse-dot { animation:pulse-dot 2s ease infinite }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation:fadeInUp .3s ease }
    </style>
    @stack('styles')
</head>
<body class="h-full text-gray-100" style="font-family:'Sora',system-ui,sans-serif;background:#040810"
      x-data="{ sidebarOpen: false, notifOpen: false }">

{{-- Mobile overlay --}}
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"
     class="fixed inset-0 z-30 bg-black/70 backdrop-blur-sm lg:hidden"></div>

{{-- ══════════════════ SIDEBAR ══════════════════ --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col transition-transform duration-200 lg:translate-x-0"
       style="background:linear-gradient(180deg,#060b18 0%,#04080f 100%);border-right:1px solid rgba(30,42,66,.5);box-shadow:4px 0 32px rgba(0,0,0,.5)">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-4 py-5" style="border-bottom:1px solid rgba(30,42,66,.5)">

        {{-- Purple orb / galaxy logo --}}
        <div style="position:relative;flex-shrink:0;width:52px;height:52px">
            {{-- Outer glow ring --}}
            <div style="
                position:absolute;inset:-4px;border-radius:50%;
                background:conic-gradient(from 0deg,#7c3aed,#a855f7,#818cf8,#6366f1,#7c3aed);
                animation:orbSpin 6s linear infinite;
                opacity:.7;filter:blur(2px);">
            </div>
            {{-- Orb body --}}
            <div style="
                position:absolute;inset:0;border-radius:50%;
                background:radial-gradient(circle at 35% 35%,#a78bfa 0%,#7c3aed 40%,#4c1d95 80%,#1e1040 100%);
                box-shadow:0 0 24px rgba(124,58,237,.80),0 0 48px rgba(124,58,237,.40),inset 0 2px 4px rgba(255,255,255,.25);
                display:flex;align-items:center;justify-content:center;
                overflow:hidden;">
                {{-- Equator ring --}}
                <div style="
                    position:absolute;width:110%;height:14px;
                    background:rgba(167,139,250,.22);
                    transform:rotate(-20deg);
                    border-radius:50%;"></div>
                {{-- Chain SVG --}}
                <svg width="26" height="26" viewBox="0 0 48 48" fill="none" style="position:relative;z-index:1">
                    <path d="M22 15C18.134 15 15 18.134 15 22C15 25.866 18.134 29 22 29H26C26.552 29 27 28.552 27 28C27 27.448 26.552 27 26 27H22C19.239 27 17 24.761 17 22C17 19.239 19.239 17 22 17H26C26.552 17 27 16.552 27 16C27 15.448 26.552 15 26 15H22Z" fill="white" opacity=".9"/>
                    <path d="M26 19C29.866 19 33 22.134 33 26C33 29.866 29.866 33 26 33H22C21.448 33 21 32.552 21 32C21 31.448 21.448 31 22 31H26C28.761 31 31 28.761 31 26C31 23.239 28.761 21 26 21H22C21.448 21 21 20.552 21 20C21 19.448 21.448 19 22 19H26Z" fill="white" opacity=".9"/>
                    <rect x="20" y="22" width="8" height="4" rx="2" fill="white" opacity=".7"/>
                </svg>
            </div>
        </div>

        {{-- Wordmark --}}
        <div>
            <div style="
                font-size:1.18rem;font-weight:800;letter-spacing:.06em;line-height:1;
                background:linear-gradient(90deg,#e0d7ff 0%,#c4b5fd 40%,#93c5fd 100%);
                -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                background-clip:text;">ASOIINFO</div>
            <div style="font-size:.62rem;color:#1e2a3a;letter-spacing:.05em;font-weight:500;margin-top:3px">
                Plataforma Multiempresa
            </div>
        </div>
    </div>

    <style>
    @keyframes orbSpin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
    </style>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

        @php
        $pendingMsgs = \App\Models\Conversation::where('queue','new_messages')->count();
        $overdueCount = \App\Models\Branch::where('status','blocked')->count();
        @endphp

        {{-- Principal --}}
        <p class="nav-section">Principal</p>

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
        <p class="nav-section">Clientes CRM</p>

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

        {{-- Facturación --}}
        <p class="nav-section">Facturación</p>

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

        <a href="{{ route('admin.invoices.to-emit') }}" class="nav-link {{ request()->routeIs('admin.invoices.to-emit') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Facturas a emitir
        </a>

        <a href="{{ route('admin.invoices.index') }}" class="nav-link {{ request()->routeIs('admin.invoices.index') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Facturas emitidas
        </a>

        <a href="{{ route('admin.cxc.index') }}" class="nav-link {{ request()->routeIs('admin.cxc.*') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cuentas por cobrar
        </a>

        <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Pagos recibidos
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
        <p class="nav-section">Reportes</p>

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

        {{-- Auditoría --}}
        <a href="{{ route('admin.audit.index') }}" class="nav-link {{ request()->routeIs('admin.audit.*') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Auditoría
        </a>

        {{-- Administración --}}
        <p class="nav-section">Administración</p>

        <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active':'' }}">
            <svg class="nav-icon w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Usuarios y roles
        </a>
    </nav>

    {{-- User footer --}}
    <div class="px-3 py-4" style="border-top:1px solid rgba(30,42,66,.5)">
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-2xl" style="background:rgba(99,102,241,.07);border:1px solid rgba(99,102,241,.12)">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                 style="background:linear-gradient(135deg,#6366f1,#7c3aed);box-shadow:0 4px 12px rgba(99,102,241,.35)">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate" style="color:#e2e8f0">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs truncate" style="color:#4b5563">{{ auth()->user()->roles->first()->name ?? 'admin' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Salir"
                        class="p-2 rounded-xl transition-all"
                        style="color:#4b5563;background:rgba(239,68,68,.0)"
                        onmouseover="this.style.background='rgba(239,68,68,.12)';this.style.color='#f87171'"
                        onmouseout="this.style.background='transparent';this.style.color='#4b5563'">
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
    <header class="sticky top-0 z-20 px-4 lg:px-6 h-14 flex items-center gap-4 backdrop-blur-xl"
            style="background:rgba(4,8,16,.88);border-bottom:1px solid rgba(30,42,66,.45);box-shadow:0 1px 0 rgba(99,102,241,.05)">

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
