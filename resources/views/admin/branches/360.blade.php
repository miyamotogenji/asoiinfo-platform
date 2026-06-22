@extends('layouts.admin')
@section('title', 'Vista 360° — ' . $branch->name)
@section('breadcrumb', 'CRM → Sucursales → 360°')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost btn-sm">← Sucursales</a>
        <div>
            <div class="flex items-center gap-2">
                <h2 class="page-heading">{{ $branch->name }}</h2>
                @if($branch->status==='blocked')     <span class="badge badge-blocked">Bloqueada</span>
                @elseif($branch->status==='active')  <span class="badge badge-active">Activa</span>
                @else                                <span class="badge badge-pending">{{ ucfirst($branch->status) }}</span>
                @endif
            </div>
            <p class="page-sub"><code style="color:#818cf8">{{ $branch->code }}</code> · {{ $branch->city }}</p>
        </div>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.sucursales.edit', $branch) }}" class="btn btn-ghost btn-sm">Editar</a>
        @if($branch->status==='blocked')
            <form method="POST" action="{{ route('admin.sucursales.unblock', $branch) }}" class="inline">
                @csrf <button type="submit" class="btn btn-success btn-sm">Desbloquear</button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.sucursales.block', $branch) }}" class="inline">
                @csrf <button type="submit" onclick="return confirm('¿Bloquear?')" class="btn btn-danger btn-sm">Bloquear</button>
            </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left column: info + contacts --}}
    <div class="space-y-5">
        {{-- Info --}}
        <div class="card-glass p-5">
            <h3 class="text-sm font-semibold text-gray-200 mb-4">Información general</h3>
            <div class="space-y-3">
                @php
                $rows = [
                    ['Empresa (RUC)',  $branch->legalEntity->legal_name ?? '—'],
                    ['Grupo',          $branch->businessGroup->name ?? '—'],
                    ['Responsable',    $branch->responsible_name ?? '—'],
                    ['Dirección',      $branch->address ?? '—'],
                    ['Teléfono',       $branch->phone ?? '—'],
                    ['WhatsApp',       $branch->whatsapp ?? '—'],
                    ['Día facturación','Día ' . ($branch->billing_day ?? '—')],
                    ['Inicio servicio',$branch->service_start_date ?? '—'],
                ];
                @endphp
                @foreach($rows as [$label, $val])
                <div class="flex justify-between gap-3">
                    <span class="text-xs" style="color:#6b7280">{{ $label }}</span>
                    <span class="text-xs font-medium text-right text-gray-300">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Contacts --}}
        <div class="card-glass overflow-hidden">
            <div class="px-5 py-3" style="border-bottom:1px solid #1a2235">
                <h3 class="text-sm font-semibold text-gray-200">Contactos ({{ $branch->contacts->count() }})</h3>
            </div>
            @forelse($branch->contacts->take(5) as $c)
            <div class="px-5 py-3" style="border-top:1px solid #1a2235">
                <p class="text-xs font-semibold text-gray-200">{{ $c->name }}</p>
                <p class="text-xs" style="color:#6b7280">{{ $c->email ?? $c->phone ?? '—' }}</p>
                @if($c->position)<p class="text-xs" style="color:#818cf8">{{ $c->position }}</p>@endif
            </div>
            @empty
            <div class="px-5 py-6 text-center text-xs" style="color:#6b7280">Sin contactos</div>
            @endforelse
        </div>
    </div>

    {{-- Center: services + invoices --}}
    <div class="space-y-5">
        {{-- Contracted services --}}
        <div class="card-glass overflow-hidden">
            <div class="px-5 py-3" style="border-bottom:1px solid #1a2235">
                <h3 class="text-sm font-semibold text-gray-200">Servicios contratados</h3>
            </div>
            @forelse($branch->contractedServices as $svc)
            <div class="px-5 py-3" style="border-top:1px solid #1a2235">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-200">{{ $svc->plan->name ?? 'Plan' }}</p>
                        <p class="text-xs" style="color:#6b7280">{{ ucfirst($svc->period ?? '') }} · Inicio: {{ $svc->start_date }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold font-mono" style="color:#f9fafb">${{ number_format($svc->total_value, 2) }}</p>
                        @if($svc->status==='active')    <span class="badge badge-active">Activo</span>
                        @elseif($svc->status==='paused') <span class="badge badge-pending">Pausado</span>
                        @else                            <span class="badge badge-blocked">{{ ucfirst($svc->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-xs" style="color:#6b7280">Sin servicios contratados</div>
            @endforelse
        </div>

        {{-- Accounts receivable --}}
        <div class="card-glass overflow-hidden">
            <div class="px-5 py-3" style="border-bottom:1px solid #1a2235">
                <h3 class="text-sm font-semibold text-gray-200">Estado de cuenta</h3>
            </div>
            @forelse($branch->accountsReceivable->take(5) as $ar)
            <div class="px-5 py-3" style="border-top:1px solid #1a2235">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-200">{{ $ar->invoice->invoice_number ?? 'Sin factura' }}</p>
                        <p class="text-xs" style="color:#6b7280">Vence: {{ $ar->due_date }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold font-mono" style="color:{{ $ar->status==='overdue' ? '#f87171' : '#f9fafb' }}">${{ number_format($ar->balance, 2) }}</p>
                        @if($ar->status==='overdue')  <span class="badge badge-overdue">Vencido {{ $ar->days_overdue }}d</span>
                        @elseif($ar->status==='paid')  <span class="badge badge-paid">Pagado</span>
                        @else                          <span class="badge badge-pending">Pendiente</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-xs" style="color:#6b7280">Sin cuentas por cobrar</div>
            @endforelse
        </div>
    </div>

    {{-- Right: WhatsApp conversations --}}
    <div class="card-glass overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid #1a2235">
            <h3 class="text-sm font-semibold text-gray-200">WhatsApp reciente</h3>
            <a href="{{ route('admin.chatbot.index') }}" class="text-xs" style="color:#25d366">Inbox →</a>
        </div>
        @forelse($branch->conversations as $conv)
        <div class="px-5 py-3" style="border-top:1px solid #1a2235">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <p class="text-xs font-semibold text-gray-200">{{ $conv->contact->name ?? $conv->whatsapp_number }}</p>
                    <p class="text-xs" style="color:#6b7280">{{ $conv->updated_at->diffForHumans() }}</p>
                </div>
                @if($conv->queue==='new_messages')   <span class="badge badge-blocked">Nuevo</span>
                @elseif($conv->queue==='in_progress') <span class="badge badge-info">En atención</span>
                @elseif($conv->queue==='closed')      <span class="badge" style="background:#1a2235;color:#6b7280">Cerrado</span>
                @endif
            </div>
        </div>
        @empty
        <div class="px-5 py-10 text-center text-xs" style="color:#6b7280">Sin conversaciones recientes</div>
        @endforelse
    </div>
</div>
@endsection
