@extends('layouts.admin')
@section('title', 'Reporte de Atención')
@section('breadcrumb', 'Reportes → Atención WhatsApp')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="page-heading">Reporte de Atención WhatsApp</h2>
        <p class="page-sub">{{ now()->locale('es')->isoFormat('MMMM YYYY') }} — Chatbot omnicanal</p>
    </div>
    <a href="{{ route('admin.chatbot.index') }}" class="btn btn-ghost btn-sm">Ir al inbox →</a>
</div>

{{-- KPI --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="card-glass p-5 stat-card-gradient-indigo">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Conversaciones este mes</p>
        <p class="text-3xl font-bold" style="color:#818cf8">{{ $data['total_conversations'] }}</p>
        <p class="text-xs mt-1" style="color:#6b7280">Total iniciadas</p>
    </div>
    <div class="card-glass p-5 stat-card-gradient-emerald">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Atendidas</p>
        <p class="text-3xl font-bold" style="color:#34d399">{{ $data['attended'] }}</p>
        @php $pct = $data['total_conversations'] > 0 ? round($data['attended']/$data['total_conversations']*100) : 0; @endphp
        <p class="text-xs mt-1" style="color:#6b7280">{{ $pct }}% del total</p>
    </div>
    <div class="card-glass p-5 stat-card-gradient-amber">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Pendientes ahora</p>
        <p class="text-3xl font-bold" style="color:#fbbf24">{{ $data['pending'] }}</p>
        <p class="text-xs mt-1" style="color:#6b7280">Sin atender</p>
    </div>
    <div class="card-glass p-5" style="border-color:#1e2a42">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">T. resp. promedio</p>
        <p class="text-3xl font-bold" style="color:#f9fafb">{{ number_format($data['avg_response_minutes'] ?? 0, 1) }}<span class="text-base font-normal ml-1" style="color:#6b7280">min</span></p>
    </div>
    <div class="card-glass p-5" style="border-color:#1e2a42">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Prospectos activos</p>
        <p class="text-3xl font-bold" style="color:#a78bfa">{{ $data['prospects'] }}</p>
        <p class="text-xs mt-1" style="color:#6b7280">Canal ventas</p>
    </div>
    <div class="card-glass p-5" style="border-color:#1e2a42">
        <p class="text-xs font-semibold mb-2" style="color:#9ca3af">Cerradas hoy</p>
        <p class="text-3xl font-bold" style="color:#f9fafb">{{ $data['closed_today'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Agent stats --}}
    <div class="card-glass overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Desempeño por agente</h3>
            <p class="text-xs mt-0.5" style="color:#6b7280">Conversaciones atendidas este mes</p>
        </div>
        @forelse($agentStats as $agent)
        <div class="flex items-center gap-4 px-5 py-3" style="border-top:1px solid #1a2235">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5)">{{ strtoupper(substr($agent->name,0,2)) }}</div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-200">{{ $agent->name }}</p>
            </div>
            <span class="text-xl font-bold" style="color:#818cf8">{{ $agent->attended_this_month }}</span>
        </div>
        @empty
        <div class="py-12 text-center text-xs" style="color:#6b7280">Sin datos de agentes este mes</div>
        @endforelse
    </div>

    {{-- Recent closed --}}
    <div class="card-glass overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">Últimas conversaciones cerradas</h3>
        </div>
        <div class="divide-y" style="border-color:#1a2235">
            @forelse($recentConversations as $c)
            <div class="px-5 py-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-200 truncate">{{ $c->contact->name ?? $c->whatsapp_number ?? 'Desconocido' }}</p>
                        <p class="text-xs truncate" style="color:#6b7280">{{ $c->branch->name ?? 'Sin sucursal' }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs" style="color:#6b7280">{{ $c->closed_at ? \Carbon\Carbon::parse($c->closed_at)->diffForHumans() : '—' }}</p>
                        @if($c->assignedAgent)
                        <p class="text-xs" style="color:#818cf8">{{ $c->assignedAgent->name }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 text-center text-xs" style="color:#6b7280">Sin conversaciones cerradas recientes</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
