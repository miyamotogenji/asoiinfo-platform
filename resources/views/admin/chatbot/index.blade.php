<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>WhatsApp Omnicanal — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{fontFamily:{sans:['Inter','sans-serif']},colors:{navy:{950:'#060c1a',900:'#0a0f1e',800:'#111827',700:'#1a2035'}}}}}</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
<style>
[x-cloak]{display:none!important}
body{font-family:'Inter',sans-serif}
.chat-messages::-webkit-scrollbar{width:4px}
.chat-messages::-webkit-scrollbar-thumb{background:#374151;border-radius:4px}
.conv-item{transition:background .1s}
</style>
</head>
<body class="h-screen bg-navy-900 text-gray-100 flex flex-col overflow-hidden" x-data="chatApp()">

{{-- ── Top bar ── --}}
<header class="flex-shrink-0 bg-navy-800 border-b border-gray-800 px-4 h-13 flex items-center gap-4" style="height:52px">
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-1.5 text-gray-400 hover:text-white text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Dashboard
    </a>
    <div class="h-5 w-px bg-gray-700"></div>

    {{-- WhatsApp brand --}}
    <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-white leading-tight">WhatsApp Omnicanal</p>
            <p class="text-xs text-gray-500 leading-tight">{{ $numbers->pluck('phone_number')->join(' · ') }}</p>
        </div>
    </div>

    {{-- Status badges --}}
    <div class="flex items-center gap-2 ml-2">
        <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-900/40 border border-red-800 text-red-300 text-xs font-semibold rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
            {{ $inbox['soporte']->count() }} Soporte
        </span>
        <span class="flex items-center gap-1.5 px-2.5 py-1 bg-blue-900/40 border border-blue-800 text-blue-300 text-xs font-semibold rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
            {{ $inbox['en_atencion']->count() }} En atención
        </span>
        <span class="flex items-center gap-1.5 px-2.5 py-1 bg-indigo-900/40 border border-indigo-800 text-indigo-300 text-xs font-semibold rounded-full">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
            {{ $inbox['ventas']->count() }} Ventas
        </span>
    </div>

    <div class="ml-auto flex items-center gap-2">
        <button onclick="window.location.reload()" class="flex items-center gap-1.5 px-3 py-1.5 bg-navy-700 hover:bg-navy-600 border border-gray-700 text-gray-400 hover:text-white text-xs rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Actualizar
        </button>
        <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
        </div>
    </div>
</header>

{{-- ── 3-column layout ── --}}
<div class="flex flex-1 overflow-hidden">

    {{-- ── LEFT: Conversation list ── --}}
    <div class="w-72 flex-shrink-0 bg-navy-800 border-r border-gray-800 flex flex-col">

        {{-- Tabs --}}
        <div class="flex border-b border-gray-800 flex-shrink-0">
            <button onclick="switchTab('soporte')" id="tab-btn-soporte"
                    class="tab-btn flex-1 py-2.5 text-xs font-semibold transition-colors border-b-2 {{ $tab==='soporte' ? 'text-green-400 border-green-500 bg-green-500/5' : 'text-gray-500 border-transparent hover:text-gray-300' }}">
                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536"/>
                </svg>
                Soporte
                @if($inbox['soporte']->count() > 0)
                    <span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $inbox['soporte']->count() }}</span>
                @endif
            </button>
            <button onclick="switchTab('en_atencion')" id="tab-btn-en_atencion"
                    class="tab-btn flex-1 py-2.5 text-xs font-semibold transition-colors border-b-2 {{ $tab==='en_atencion' ? 'text-blue-400 border-blue-500 bg-blue-500/5' : 'text-gray-500 border-transparent hover:text-gray-300' }}">
                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728M9 10a2.5 2.5 0 100 4 2.5 2.5 0 000-4zm6 0a2.5 2.5 0 100 4 2.5 2.5 0 000-4z"/>
                </svg>
                Atención
                @if($inbox['en_atencion']->count() > 0)
                    <span class="ml-1 bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $inbox['en_atencion']->count() }}</span>
                @endif
            </button>
            <button onclick="switchTab('ventas')" id="tab-btn-ventas"
                    class="tab-btn flex-1 py-2.5 text-xs font-semibold transition-colors border-b-2 {{ $tab==='ventas' ? 'text-indigo-400 border-indigo-500 bg-indigo-500/5' : 'text-gray-500 border-transparent hover:text-gray-300' }}">
                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Ventas
                @if($inbox['ventas']->count() > 0)
                    <span class="ml-1 bg-indigo-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $inbox['ventas']->count() }}</span>
                @endif
            </button>
        </div>

        {{-- Soporte tab --}}
        <div id="tab-soporte" class="tab-content {{ $tab==='soporte' ? '' : 'hidden' }} flex-1 overflow-y-auto">
            <div class="px-3 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider border-b border-gray-800/50">
                Mensajes sin atender — permanecen hasta que un agente presione "Atender"
            </div>
            @forelse($inbox['soporte'] as $conv)
            <a href="?conv={{ $conv->id }}&tab=soporte"
               class="conv-item flex items-start gap-2.5 px-3 py-3 border-b border-gray-800/40 hover:bg-navy-700/50 {{ $activeConvId == $conv->id ? 'bg-navy-700 border-l-2 border-l-green-500' : '' }}">
                <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold
                    @if($conv->financial_status === 'overdue') bg-red-800/60 text-red-300
                    @elseif($conv->financial_status === 'blocked') bg-red-900/60 text-red-400
                    @else bg-green-800/40 text-green-300 @endif">
                    {{ strtoupper(substr($conv->contact_name ?? $conv->contact_phone, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <p class="text-xs font-semibold text-gray-200 truncate">{{ $conv->contact_name ?? $conv->contact_phone }}</p>
                        <span class="text-xs text-gray-600 flex-shrink-0 ml-1">{{ $conv->updated_at->diffForHumans(null, true) }}</span>
                    </div>
                    <p class="text-xs text-gray-500 truncate">{{ $conv->messages->first()?->body ?? 'Sin mensajes' }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        @if($conv->financial_status === 'current')
                            <span class="text-xs text-green-400 font-medium">● Al día</span>
                        @elseif($conv->financial_status === 'overdue')
                            <span class="text-xs text-red-400 font-medium">● Vencido</span>
                        @elseif($conv->financial_status === 'blocked')
                            <span class="text-xs text-red-500 font-medium">● Bloqueado</span>
                        @else
                            <span class="text-xs text-gray-500">● Desconocido</span>
                        @endif
                        @if($conv->businessGroup)
                            <span class="text-xs text-gray-600">· {{ $conv->businessGroup->name }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-gray-600">
                <svg class="w-10 h-10 mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">Sin mensajes nuevos</p>
                <p class="text-xs text-gray-700 mt-1">Todos atendidos</p>
            </div>
            @endforelse
        </div>

        {{-- En atención tab --}}
        <div id="tab-en_atencion" class="tab-content {{ $tab==='en_atencion' ? '' : 'hidden' }} flex-1 overflow-y-auto">
            <div class="px-3 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider border-b border-gray-800/50">
                Conversaciones en atención activa
            </div>
            @forelse($inbox['en_atencion'] as $conv)
            <a href="?conv={{ $conv->id }}&tab=en_atencion"
               class="conv-item flex items-start gap-2.5 px-3 py-3 border-b border-gray-800/40 hover:bg-navy-700/50 {{ $activeConvId == $conv->id ? 'bg-navy-700 border-l-2 border-l-blue-500' : '' }}">
                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-blue-800/40 text-blue-300 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr($conv->contact_name ?? $conv->contact_phone, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <p class="text-xs font-semibold text-gray-200 truncate">{{ $conv->contact_name ?? $conv->contact_phone }}</p>
                        <span class="text-xs text-gray-600">{{ $conv->attended_at?->diffForHumans(null, true) ?? '' }}</span>
                    </div>
                    <p class="text-xs text-gray-500">Asesor: {{ $conv->assignedAgent?->name ?? 'Sin asignar' }}</p>
                    <p class="text-xs text-gray-600 truncate mt-0.5">{{ $conv->messages->first()?->body ?? '' }}</p>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-gray-600">
                <svg class="w-10 h-10 mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728"/>
                </svg>
                <p class="text-sm font-medium">Nada en atención</p>
            </div>
            @endforelse
        </div>

        {{-- Ventas/Prospectos tab --}}
        <div id="tab-ventas" class="tab-content {{ $tab==='ventas' ? '' : 'hidden' }} flex-1 overflow-y-auto">
            <div class="px-3 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider border-b border-gray-800/50">
                Nuevos prospectos · Clientes nuevos
            </div>
            @forelse($inbox['ventas'] as $conv)
            <a href="?conv={{ $conv->id }}&tab=ventas"
               class="conv-item flex items-start gap-2.5 px-3 py-3 border-b border-gray-800/40 hover:bg-navy-700/50 {{ $activeConvId == $conv->id ? 'bg-navy-700 border-l-2 border-l-indigo-500' : '' }}">
                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-indigo-800/40 text-indigo-300 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr($conv->contact_phone ?? '??', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-0.5">
                        <p class="text-xs font-semibold text-gray-200 truncate">{{ $conv->contact_name ?? $conv->contact_phone }}</p>
                        <span class="text-xs text-gray-600">{{ $conv->updated_at->diffForHumans(null, true) }}</span>
                    </div>
                    <p class="text-xs text-gray-500 truncate">{{ $conv->messages->first()?->body ?? 'Sin mensajes' }}</p>
                    <span class="text-xs text-indigo-400 font-medium mt-1 block">● Prospecto nuevo</span>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-gray-600">
                <svg class="w-10 h-10 mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <p class="text-sm font-medium">Sin prospectos nuevos</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── CENTER: Chat ── --}}
    <div class="flex-1 flex flex-col bg-navy-900 min-w-0">
        @if($activeConversation)

        {{-- Chat header --}}
        <div class="flex-shrink-0 bg-navy-800 border-b border-gray-800 px-5 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-green-800/40 text-green-300 flex items-center justify-center font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($activeConversation->contact_name ?? $activeConversation->contact_phone, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white">{{ $activeConversation->contact_name ?? $activeConversation->contact_phone }}</p>
                <p class="text-xs text-gray-500">{{ $activeConversation->contact_phone }}
                    @if($activeConversation->whatsappNumber) · {{ $activeConversation->whatsappNumber->name }} @endif
                </p>
            </div>
            {{-- Status badge --}}
            @php $fs = $activeConversation->financial_status; @endphp
            @if($fs === 'current') <span class="px-2.5 py-1 bg-emerald-900/40 border border-emerald-700 text-emerald-300 text-xs font-semibold rounded-full">Al día</span>
            @elseif($fs === 'overdue') <span class="px-2.5 py-1 bg-red-900/40 border border-red-700 text-red-300 text-xs font-semibold rounded-full">Vencido</span>
            @elseif($fs === 'blocked') <span class="px-2.5 py-1 bg-red-900/60 border border-red-600 text-red-200 text-xs font-semibold rounded-full">Bloqueado</span>
            @else <span class="px-2.5 py-1 bg-gray-700 text-gray-400 text-xs font-semibold rounded-full">Desconocido</span>
            @endif

            {{-- Queue actions --}}
            @if($activeConversation->queue === 'new_messages')
                <form method="POST" action="{{ route('admin.chatbot.attend', $activeConversation) }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white text-xs font-semibold rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Atender cliente
                    </button>
                </form>
            @elseif($activeConversation->queue === 'in_progress')
                <form method="POST" action="{{ route('admin.chatbot.close', $activeConversation) }}">
                    @csrf
                    <button type="submit" onclick="return confirm('¿Finalizar esta atención?')"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-700 hover:bg-red-800 text-gray-300 hover:text-white text-xs font-semibold rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cerrar atención
                    </button>
                </form>
            @elseif($activeConversation->queue === 'new_prospects')
                <form method="POST" action="{{ route('admin.chatbot.attend', $activeConversation) }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Gestionar prospecto
                    </button>
                </form>
            @endif
        </div>

        {{-- Financial alert bar --}}
        @if($activeConversation->financial_status === 'overdue' || $activeConversation->financial_status === 'blocked')
        <div class="flex-shrink-0 bg-red-900/20 border-b border-red-800/40 px-5 py-2 flex items-center gap-2 text-xs text-red-300">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <strong>CLIENTE MOROSO</strong> —
            @php
                $pendingAR = $activeConversation->branch?->accountsReceivable ?? collect();
                $totalDue = $pendingAR->sum('balance');
            @endphp
            Total adeudado: <strong>${{ number_format($totalDue, 2) }}</strong>.
            {{ $activeConversation->financial_status === 'blocked' ? 'Servicio BLOQUEADO.' : 'Envíe recordatorio de pago.' }}
        </div>
        @endif

        {{-- Messages --}}
        <div class="flex-1 overflow-y-auto chat-messages p-4 space-y-3">
            @forelse($activeConversation->messages as $msg)
                @if($msg->direction === 'inbound')
                <div class="flex items-end gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-700 flex-shrink-0 flex items-center justify-center text-xs">
                        {{ strtoupper(substr($activeConversation->contact_name ?? '?', 0, 1)) }}
                    </div>
                    <div class="max-w-md">
                        <div class="bg-navy-800 border border-gray-700 rounded-2xl rounded-bl-sm px-4 py-2.5 text-sm text-gray-200">
                            {{ $msg->body }}
                        </div>
                        <p class="text-xs text-gray-600 mt-1 ml-1">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
                @elseif($msg->direction === 'outbound')
                <div class="flex items-end justify-end gap-2">
                    <div class="max-w-md">
                        <div class="bg-indigo-600 rounded-2xl rounded-br-sm px-4 py-2.5 text-sm text-white">
                            {{ $msg->body }}
                        </div>
                        <p class="text-xs text-gray-600 mt-1 text-right mr-1">
                            {{ $msg->sender?->name ?? 'Sistema' }} · {{ $msg->created_at->format('H:i') }}
                            @if($msg->status === 'sent') ✓ @elseif($msg->status === 'delivered') ✓✓ @elseif($msg->status === 'read') <span class="text-blue-400">✓✓</span> @endif
                        </p>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-indigo-700 flex-shrink-0 flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($msg->sender?->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
                @else
                <div class="flex justify-center">
                    <div class="bg-amber-900/20 border border-amber-800/30 text-amber-300 text-xs px-3 py-1.5 rounded-full">
                        {{ $msg->body }}
                    </div>
                </div>
                @endif
            @empty
            <div class="flex flex-col items-center justify-center h-full text-gray-600 py-20">
                <svg class="w-10 h-10 mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-sm">Sin mensajes en esta conversación</p>
            </div>
            @endforelse
        </div>

        {{-- Message input --}}
        <div class="flex-shrink-0 bg-navy-800 border-t border-gray-800 p-3">
            {{-- Quick responses --}}
            <div class="flex gap-2 mb-2 flex-wrap">
                @php $templates = [
                    'Hola, ¿en qué le puedo ayudar hoy?',
                    'Verificando su cuenta, un momento por favor.',
                    'Su pago ha sido registrado correctamente.',
                    'Le enviaré la factura en un momento.',
                    'Por favor comuníquese al +593 99 587 8586.',
                ]; @endphp
                @foreach($templates as $t)
                <button onclick="setMessage('{{ addslashes($t) }}')"
                        class="text-xs px-2 py-1 bg-navy-700 hover:bg-navy-600 border border-gray-700 text-gray-400 hover:text-gray-200 rounded-md transition-colors truncate max-w-xs">
                    {{ Str::limit($t, 30) }}
                </button>
                @endforeach
            </div>
            <form method="POST" action="{{ route('admin.chatbot.send', $activeConversation) }}" class="flex items-end gap-2">
                @csrf
                <input type="hidden" name="tab" value="{{ $tab }}">
                <textarea id="msgInput" name="body" rows="2" placeholder="Escribe un mensaje… (Enter para enviar)"
                          class="flex-1 bg-navy-900 border border-gray-700 focus:border-indigo-500 rounded-xl px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors resize-none"></textarea>
                <div class="flex flex-col gap-1.5">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @else
        {{-- Empty state --}}
        <div class="flex-1 flex flex-col items-center justify-center text-gray-600 p-10">
            <img src="/inbox-illustration.png" alt="Selecciona una conversación" class="w-64 h-auto opacity-70 mb-6 rounded-xl">
            <p class="text-base font-semibold text-gray-400">Selecciona una conversación</p>
            <p class="text-sm text-gray-600 mt-1 text-center max-w-sm">Haz clic en cualquier mensaje de la lista izquierda para ver el historial y responder al cliente</p>
        </div>
        @endif
    </div>

    {{-- ── RIGHT: Client info ── --}}
    <div class="w-72 flex-shrink-0 bg-navy-800 border-l border-gray-800 flex flex-col overflow-y-auto">
        @if($activeConversation)
        <div class="p-4 border-b border-gray-800">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Información del cliente</p>

            {{-- Client identity --}}
            @if($activeConversation->branch)
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-500">Sucursal</span>
                    <span class="text-gray-200 font-medium text-right">{{ $activeConversation->branch->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Grupo</span>
                    <span class="text-gray-200 font-medium text-right truncate ml-2">{{ $activeConversation->businessGroup?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ciudad</span>
                    <span class="text-gray-200">{{ $activeConversation->branch->city ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Responsable</span>
                    <span class="text-gray-200 text-right">{{ $activeConversation->branch->responsible_name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Estado sucursal</span>
                    @if($activeConversation->branch->status === 'active')
                        <span class="text-emerald-400 font-semibold">Activa</span>
                    @elseif($activeConversation->branch->status === 'blocked')
                        <span class="text-red-400 font-semibold">Bloqueada</span>
                    @else
                        <span class="text-gray-400">{{ ucfirst($activeConversation->branch->status) }}</span>
                    @endif
                </div>
            </div>
            @else
            <p class="text-xs text-gray-500">Cliente no identificado en el sistema</p>
            @endif
        </div>

        {{-- Pending invoices --}}
        @if($activeConversation->branch && $activeConversation->branch->accountsReceivable->count() > 0)
        <div class="p-4 border-b border-gray-800">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Facturas pendientes</p>
            <div class="space-y-2">
                @foreach($activeConversation->branch->accountsReceivable as $ar)
                <div class="flex items-center justify-between p-2 bg-red-900/20 border border-red-800/30 rounded-lg">
                    <div>
                        <p class="text-xs font-semibold text-red-300">${{ number_format($ar->balance, 2) }}</p>
                        <p class="text-xs text-gray-600">{{ $ar->due_date?->format('d/m/Y') }} · {{ $ar->days_overdue }}d venc.</p>
                    </div>
                    @if($ar->status === 'overdue')
                        <span class="text-xs text-red-400 font-semibold">Vencido</span>
                    @else
                        <span class="text-xs text-amber-400 font-semibold">{{ ucfirst($ar->status) }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Contracted services --}}
        @if($activeConversation->branch && $activeConversation->branch->contractedServices->count() > 0)
        <div class="p-4 border-b border-gray-800">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Servicios contratados</p>
            <div class="space-y-2">
                @foreach($activeConversation->branch->contractedServices as $svc)
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-400">{{ $svc->plan?->name ?? 'Plan' }}</span>
                    <span class="text-gray-200 font-semibold">${{ number_format($svc->total_value, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Quick actions --}}
        <div class="p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Acciones rápidas</p>
            <div class="space-y-2">
                <a href="{{ route('admin.cxc.index', ['search' => $activeConversation->contact_phone]) }}"
                   class="flex items-center gap-2 px-3 py-2 bg-navy-700 hover:bg-navy-600 border border-gray-700 text-gray-300 hover:text-white text-xs rounded-lg transition-colors w-full">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Ver CxC del cliente
                </a>
                <a href="{{ route('admin.invoices.to-emit') }}"
                   class="flex items-center gap-2 px-3 py-2 bg-navy-700 hover:bg-navy-600 border border-gray-700 text-gray-300 hover:text-white text-xs rounded-lg transition-colors w-full">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Facturas a emitir
                </a>
                @if($activeConversation->branch)
                    @if($activeConversation->branch->status !== 'blocked')
                    <form method="POST" action="{{ route('admin.cxc.block-branch', $activeConversation->branch) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('¿Bloquear esta sucursal?')"
                                class="flex items-center gap-2 px-3 py-2 bg-red-900/30 hover:bg-red-900/50 border border-red-800/50 text-red-400 hover:text-red-300 text-xs rounded-lg transition-colors w-full">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Bloquear sucursal
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.cxc.unblock-branch', $activeConversation->branch) }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-3 py-2 bg-emerald-900/30 hover:bg-emerald-900/50 border border-emerald-800/50 text-emerald-400 hover:text-emerald-300 text-xs rounded-lg transition-colors w-full">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Desbloquear sucursal
                        </button>
                    </form>
                    @endif
                @endif
                @if($activeConversation->queue === 'new_prospects')
                <form method="POST" action="{{ route('admin.chatbot.convert', $activeConversation) }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 px-3 py-2 bg-indigo-900/30 hover:bg-indigo-900/50 border border-indigo-800/50 text-indigo-400 hover:text-indigo-300 text-xs rounded-lg transition-colors w-full">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Convertir en cliente
                    </button>
                </form>
                @endif
            </div>
        </div>
        @else
        <div class="flex-1 flex flex-col items-center justify-center text-gray-600 p-6">
            <svg class="w-10 h-10 mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <p class="text-sm text-center">Selecciona una conversación para ver la información del cliente</p>
        </div>
        @endif
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.className = el.className.replace(/text-\w+-400|border-\w+-500|bg-\w+-500\/5/g, '');
    });

    const content = document.getElementById('tab-' + tab);
    if (content) content.classList.remove('hidden');

    const colors = { soporte: 'green', en_atencion: 'blue', ventas: 'indigo' };
    const c = colors[tab] || 'gray';
    const btn = document.getElementById('tab-btn-' + tab);
    if (btn) {
        btn.classList.add(`text-${c}-400`, `border-${c}-500`, `bg-${c}-500/5`);
        btn.classList.remove('text-gray-500', 'border-transparent');
    }
}

function setMessage(text) {
    const ta = document.getElementById('msgInput');
    if (ta) ta.value = text;
    ta.focus();
}

// Auto-scroll messages to bottom
const msgContainer = document.querySelector('.chat-messages');
if (msgContainer) msgContainer.scrollTop = msgContainer.scrollHeight;

// Auto-refresh every 45 seconds
setTimeout(() => window.location.reload(), 45000);
</script>
</body>
</html>
