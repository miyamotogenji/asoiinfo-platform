<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — ASOIINFO</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
        body { background: #f5f6fa; color: #111827; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #6366f1; }

        /* Sidebar */
        .sidebar { width: 230px; min-height: 100vh; background: #fff; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; flex-shrink: 0; }

        /* Nav links */
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px; margin: 1px 0;
            font-size: .825rem; font-weight: 500; color: #6b7280;
            text-decoration: none; transition: all .15s;
        }
        .nav-link:hover { background: #f3f4f6; color: #111827; }
        .nav-link.active { background: #eef2ff; color: #4f46e5; font-weight: 600; }
        .nav-link.active .ni { color: #4f46e5; }
        .nav-link .ni { color: #9ca3af; width: 16px; height: 16px; flex-shrink: 0; }
        .nav-section {
            padding: 16px 12px 6px;
            font-size: .65rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: #9ca3af;
        }

        /* Top bar */
        .topbar { height: 56px; background: #fff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; padding: 0 24px; gap: 12px; position: sticky; top: 0; z-index: 30; }

        /* Cards */
        .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px 22px; }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }

        /* Tables */
        .data-table { width: 100%; border-collapse: collapse; font-size: .845rem; }
        .data-table th { padding: 11px 16px; text-align: left; font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: #6b7280; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
        .data-table td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #374151; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: #f9fafb; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: .72rem; font-weight: 600; }
        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }
        .badge-gray   { background: #f3f4f6; color: #4b5563; }
        .badge-purple { background: #ede9fe; color: #5b21b6; }
        .badge-orange { background: #ffedd5; color: #9a3412; }

        /* Buttons */
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #4f46e5; color: #fff; border: none; border-radius: 8px; font-size: .84rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all .15s; }
        .btn-primary:hover { background: #4338ca; box-shadow: 0 4px 12px rgba(79,70,229,.3); }
        .btn-secondary { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fff; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; font-size: .84rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .15s; }
        .btn-secondary:hover { background: #f9fafb; border-color: #9ca3af; }
        .btn-danger { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #ef4444; color: #fff; border: none; border-radius: 8px; font-size: .84rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all .15s; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 5px 11px; font-size: .78rem; }
        .btn-xs { padding: 3px 8px; font-size: .72rem; }

        /* Forms */
        .form-input { width: 100%; padding: 9px 13px; background: #fff; border: 1px solid #d1d5db; border-radius: 8px; font-size: .875rem; color: #111827; outline: none; transition: border-color .15s, box-shadow .15s; }
        .form-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
        .form-label { display: block; font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-select { width: 100%; padding: 9px 13px; background: #fff; border: 1px solid #d1d5db; border-radius: 8px; font-size: .875rem; color: #111827; outline: none; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 16px; padding-right: 36px; }
        .form-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }

        /* Page section */
        .page-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .page-card-header { padding: 16px 20px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; }

        /* Alert flash */
        .flash-success { background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; font-size: .875rem; display: flex; align-items: center; gap: 8px; }
        .flash-error   { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-size: .875rem; display: flex; align-items: center; gap: 8px; }
    </style>
    @stack('styles')
</head>
<body class="h-full" x-data="{ sideOpen: true }">

<div class="flex h-full min-h-screen">

    {{-- ═══════════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════════ --}}
    <aside class="sidebar" :class="sideOpen ? '' : '-translate-x-full hidden'">
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center flex-shrink-0">
                <svg viewBox="0 0 24 24" fill="white" class="w-4.5 h-4.5" style="width:18px;height:18px">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-800 text-gray-900 leading-none" style="font-weight:800">ASOIINFO</div>
                <div class="text-[10px] text-gray-400 font-medium mt-0.5">Platform</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-3">

            <div class="nav-section">Principal</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>

            <div class="nav-section">CRM</div>
            <a href="{{ route('admin.grupos.index') }}" class="nav-link {{ request()->routeIs('admin.grupos.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                Grupos Empresariales
            </a>
            <a href="{{ route('admin.empresas.index') }}" class="nav-link {{ request()->routeIs('admin.empresas.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-2M5 21H3m2 0h2M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                Empresas Legales
            </a>
            <a href="{{ route('admin.sucursales.index') }}" class="nav-link {{ request()->routeIs('admin.sucursales.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Sucursales
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="nav-link {{ request()->routeIs('admin.contactos.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Contactos
            </a>

            <div class="nav-section">Planes & Servicios</div>
            <a href="{{ route('admin.planes.index') }}" class="nav-link {{ request()->routeIs('admin.planes.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Planes
            </a>
            <a href="{{ route('admin.servicios.index') }}" class="nav-link {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Servicios Contratados
            </a>

            <div class="nav-section">Facturación</div>
            <a href="{{ route('admin.invoices.to-emit') }}" class="nav-link {{ request()->routeIs('admin.invoices.to-emit') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Facturas a Emitir
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="nav-link {{ request()->routeIs('admin.invoices.index') || request()->routeIs('admin.invoices.show') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                Facturas Emitidas
            </a>
            <a href="{{ route('admin.cxc.index') }}" class="nav-link {{ request()->routeIs('admin.cxc.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Cuentas x Cobrar
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Pagos Recibidos
            </a>

            <div class="nav-section">Operaciones</div>
            <a href="{{ route('admin.reports.financial') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                Reportes
            </a>
            <a href="{{ route('admin.audit.index') }}" class="nav-link {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Auditoría
            </a>

            <div class="nav-section">Administración</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                Usuarios
            </a>
            <a href="{{ route('admin.two-factor.show') }}" class="nav-link {{ request()->routeIs('admin.two-factor.*') ? 'active' : '' }}">
                <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                Seguridad 2FA
                @php $u = auth()->user(); @endphp
                @if($u && $u->two_factor_confirmed)
                    <span class="badge badge-green ml-auto" style="padding:2px 7px;font-size:.65rem">ON</span>
                @endif
            </a>
        </nav>

        {{-- Bottom user --}}
        <div class="border-t border-gray-100 p-3">
            <div class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-700 text-indigo-600" style="font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-600 text-gray-800 truncate" style="font-weight:600">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="nav-link w-full" style="color:#ef4444">
                    <svg class="ni" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════════
         MAIN
    ═══════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top bar --}}
        <header class="topbar">
            <button @click="sideOpen = !sideOpen" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            {{-- Breadcrumb --}}
            <div class="flex-1">
                <span class="text-sm text-gray-500">@yield('breadcrumb', 'Panel')</span>
            </div>

            {{-- Right --}}
            <div class="flex items-center gap-3">
                {{-- Date --}}
                <span class="text-xs text-gray-400 hidden sm:block">{{ now()->locale('es')->isoFormat('D [de] MMMM, YYYY') }}</span>

                {{-- Notifications bell --}}
                <button class="relative p-1.5 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>

                {{-- User avatar --}}
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-700 text-white cursor-pointer" style="font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="text-sm font-500 text-gray-700 hidden sm:block" style="font-weight:500">{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-6 mt-4 flash-success">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mx-6 mt-4 flash-error">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
