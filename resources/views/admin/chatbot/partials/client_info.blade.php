@php
    $branch = $conversation->branch;
    $group  = $conversation->businessGroup;
    $contact = $conversation->contact;
    $status = $conversation->financial_status;
@endphp

<div class="info-section">
    <h4>Contacto</h4>
    <div class="info-row"><span class="label">Nombre</span><span class="value">{{ $conversation->contact_name ?? '—' }}</span></div>
    <div class="info-row"><span class="label">WhatsApp</span><span class="value">{{ $conversation->contact_phone }}</span></div>
    @if($contact)
    <div class="info-row"><span class="label">Cargo</span><span class="value">{{ $contact->position ?? '—' }}</span></div>
    <div class="info-row"><span class="label">Soporte</span>
        <span class="value">
            @if($contact->authorized_support) <span class="badge b-green">Autorizado</span>
            @else <span class="badge b-red">No autorizado</span>
            @endif
        </span>
    </div>
    @endif
</div>

@if($group)
<div class="info-section">
    <h4>Empresa</h4>
    <div class="info-row"><span class="label">Grupo</span><span class="value">{{ $group->name }}</span></div>
    @if($branch)
    <div class="info-row"><span class="label">Sucursal</span><span class="value">{{ $branch->name }}</span></div>
    <div class="info-row"><span class="label">Ciudad</span><span class="value">{{ $branch->city ?? '—' }}</span></div>
    @endif
</div>
@endif

<div class="info-section">
    <h4>Estado financiero</h4>
    <div class="info-row">
        <span class="label">Estado</span>
        <span class="value">
            @switch($status)
                @case('current') <span class="badge b-green">Al día</span> @break
                @case('due_soon') <span class="badge b-yellow">Por vencer</span> @break
                @case('overdue') <span class="badge b-red">Vencido</span> @break
                @case('blocked') <span class="badge b-red">Bloqueado</span> @break
                @default <span class="badge b-gray">Desconocido</span>
            @endswitch
        </span>
    </div>
    @if($branch)
    <div class="info-row">
        <span class="label">Saldo</span>
        <span class="value" style="color:{{ $branch->total_balance > 0 ? '#fca5a5' : '#6ee7b7' }}">
            ${{ number_format($branch->total_balance, 2) }}
        </span>
    </div>
    @endif
</div>

@if($branch)
<div class="info-section">
    <h4>Servicios contratados</h4>
    @foreach($branch->contractedServices->where('status', 'active') as $svc)
    <div style="padding:6px 0;border-bottom:1px solid var(--border);font-size:.8rem">
        <div>{{ $svc->plan->name }}</div>
        <div style="color:var(--muted)">{{ $svc->plan->period_label }} · ${{ number_format($svc->total_value, 2) }}</div>
    </div>
    @endforeach
</div>
@endif

<div class="info-section">
    <h4>Acciones rápidas</h4>
    <div class="info-actions">
        @if($branch)
        <a href="{{ route('admin.sucursales.360', $branch) }}" class="btn btn-ghost btn-sm">👁️ Ver cliente 360</a>
        <a href="{{ route('admin.cxc.index') }}?branch={{ $branch->id }}" class="btn btn-ghost btn-sm">💰 Ver CxC</a>
        @if($branch->status !== 'blocked')
        <form method="POST" action="{{ route('admin.sucursales.block', $branch) }}">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm" style="width:100%" onclick="return confirm('¿Bloquear esta sucursal?')">🔒 Bloquear sucursal</button>
        </form>
        @else
        <form method="POST" action="{{ route('admin.sucursales.unblock', $branch) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" style="width:100%">🔓 Desbloquear</button>
        </form>
        @endif
        @endif
        @if(!$contact)
        <button onclick="createContact('{{ $conversation->contact_phone }}')" class="btn btn-ghost btn-sm">➕ Crear contacto</button>
        @endif
    </div>
</div>

<div class="info-section">
    <h4>Última atención</h4>
    <div class="info-row"><span class="label">Inicio</span><span class="value">{{ $conversation->created_at->format('d/m H:i') }}</span></div>
    @if($conversation->attended_at)
    <div class="info-row"><span class="label">Atendido</span><span class="value">{{ $conversation->attended_at->format('d/m H:i') }}</span></div>
    @endif
    <div class="info-row"><span class="label">Asesor</span><span class="value">{{ $conversation->assignedAgent?->name ?? '—' }}</span></div>
</div>

<script>
function createContact(phone) {
    window.location.href = '/admin/contactos/create?whatsapp=' + phone + '&conv={{ $conversation->id }}';
}
</script>
