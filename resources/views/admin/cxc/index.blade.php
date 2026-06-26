@extends('layouts.admin')
@section('title', 'Cuentas por Cobrar')
@section('breadcrumb', 'Facturación → Cuentas por Cobrar')

@section('content')

{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card border-l-4" style="border-left-color:#4f46e5">
        <p class="text-xs text-gray-500 font-600 mb-1" style="font-weight:600">Total por Cobrar</p>
        <p class="text-2xl font-800 text-gray-900" style="font-weight:800">${{ number_format($totals['total_receivable'], 2) }}</p>
        <p class="text-xs text-gray-400 mt-1">Pendiente + Vencido + Parcial</p>
    </div>
    <div class="stat-card border-l-4" style="border-left-color:#ef4444">
        <p class="text-xs text-gray-500 font-600 mb-1" style="font-weight:600">Vencido</p>
        <p class="text-2xl font-800 text-red-500" style="font-weight:800">${{ number_format($totals['overdue'], 2) }}</p>
        <p class="text-xs text-gray-400 mt-1">Facturas vencidas</p>
    </div>
    <div class="stat-card border-l-4" style="border-left-color:#f59e0b">
        <p class="text-xs text-gray-500 font-600 mb-1" style="font-weight:600">Pendiente</p>
        <p class="text-2xl font-800 text-amber-500" style="font-weight:800">${{ number_format($totals['pending'], 2) }}</p>
        <p class="text-xs text-gray-400 mt-1">Aún no vencido</p>
    </div>
    <div class="stat-card border-l-4" style="border-left-color:#10b981">
        <p class="text-xs text-gray-500 font-600 mb-1" style="font-weight:600">Cobrado este mes</p>
        <p class="text-2xl font-800 text-green-600" style="font-weight:800">${{ number_format($totals['paid_month'], 2) }}</p>
        <p class="text-xs text-gray-400 mt-1">Pagos aprobados</p>
    </div>
</div>

{{-- Filters --}}
<div class="page-card mb-4">
    <form method="GET" class="flex flex-wrap gap-3 p-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Buscar cliente, sucursal, factura…"
               class="form-input" style="width:260px">
        <select name="status" class="form-select" style="width:200px">
            <option value="">Todos los estados</option>
            <option value="pending"      {{ request('status')=='pending'     ?'selected':'' }}>Pendiente</option>
            <option value="overdue"      {{ request('status')=='overdue'     ?'selected':'' }}>Vencido</option>
            <option value="partial"      {{ request('status')=='partial'     ?'selected':'' }}>Parcial</option>
            <option value="paid"         {{ request('status')=='paid'        ?'selected':'' }}>Pagado</option>
            <option value="in_agreement" {{ request('status')=='in_agreement'?'selected':'' }}>En convenio</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">Filtrar</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.cxc.index') }}" class="btn-secondary btn-sm">Limpiar</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="page-card">
    <div class="page-card-header">
        <h2 class="text-sm font-700 text-gray-800" style="font-weight:700">Cuentas por Cobrar</h2>
        <span class="badge badge-blue">{{ $accounts->total() }} registros</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Cliente / Sucursal</th>
                    <th>Factura</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Saldo</th>
                    <th class="text-center">Días</th>
                    <th class="text-center">Estado</th>
                    <th>Vence</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $ar)
                <tr>
                    <td>
                        <div class="font-600 text-gray-800 text-sm" style="font-weight:600">{{ $ar->branch->name ?? '—' }}</div>
                        <div class="text-xs text-gray-400">{{ $ar->businessGroup->name ?? '' }}</div>
                    </td>
                    <td>
                        <div class="font-600 text-indigo-600 text-xs font-mono" style="font-weight:600">{{ $ar->invoice->number ?? '—' }}</div>
                        <div class="text-xs text-gray-400">{{ $ar->invoice?->issue_date?->format('d/m/Y') ?? '' }}</div>
                    </td>
                    <td class="text-right text-sm text-gray-600">${{ number_format($ar->amount, 2) }}</td>
                    <td class="text-right font-700 text-sm" style="font-weight:700">${{ number_format($ar->balance, 2) }}</td>
                    <td class="text-center">
                        @if($ar->days_overdue > 0)
                            <span class="badge badge-red">{{ $ar->days_overdue }}d</span>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @switch($ar->status)
                            @case('pending')     <span class="badge badge-yellow">Pendiente</span> @break
                            @case('overdue')     <span class="badge badge-red">Vencido</span> @break
                            @case('partial')     <span class="badge badge-orange">Parcial</span> @break
                            @case('paid')        <span class="badge badge-green">Pagado</span> @break
                            @case('in_agreement')<span class="badge badge-blue">Convenio</span> @break
                            @default             <span class="badge badge-gray">{{ $ar->status }}</span>
                        @endswitch
                    </td>
                    <td class="text-sm {{ $ar->due_date?->isPast() ? 'text-red-500 font-600' : 'text-gray-500' }}">
                        {{ $ar->due_date?->format('d/m/Y') ?? '—' }}
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            @if($ar->status !== 'paid')
                            <button onclick="openPaymentModal({{ $ar->id }}, '{{ addslashes($ar->branch->name ?? '') }}', {{ $ar->balance }})"
                                    class="btn-primary btn-xs" style="background:#10b981;font-size:.72rem">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Pago
                            </button>
                            @endif
                            @if($ar->branch && $ar->branch->status !== 'blocked')
                            <form method="POST" action="{{ route('admin.cxc.block-branch', $ar->branch_id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Bloquear {{ addslashes($ar->branch->name ?? '') }}?')"
                                        class="btn-danger btn-xs">Bloquear</button>
                            </form>
                            @elseif($ar->branch && $ar->branch->status === 'blocked')
                            <form method="POST" action="{{ route('admin.cxc.unblock-branch', $ar->branch_id) }}">
                                @csrf
                                <button type="submit" class="btn-secondary btn-xs" style="color:#10b981;border-color:#10b981">Desbloquear</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-14">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-400 text-sm">Sin cuentas por cobrar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($accounts->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $accounts->withQueryString()->links() }}</div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════
     REGISTRA PAGO MODAL (matches image 3 style)
══════════════════════════════════════════════════════ --}}
<div id="paymentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,.45)">
    <div class="bg-white rounded-xl w-full max-w-md shadow-2xl border border-gray-200" x-data>
        {{-- Header bar (red like image 3) --}}
        <div class="h-10 rounded-t-xl" style="background:#cc0000;display:flex;align-items:center;padding:0 16px">
            <span class="text-white text-sm font-600" style="font-weight:600">Registra pago</span>
            <button onclick="closePaymentModal()" class="ml-auto text-white hover:text-red-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.cxc.store-payment') }}" class="p-5 space-y-3.5">
            @csrf
            <input type="hidden" name="account_receivable_id" id="modalArId">

            {{-- Client name (read-only, shown as header in modal) --}}
            <div class="text-center pb-1">
                <p id="modalClientName" class="text-sm font-600 text-gray-700" style="font-weight:600"></p>
            </div>

            {{-- Banco - Cuenta --}}
            <div class="flex items-center gap-3">
                <label class="text-sm text-gray-600 w-40 flex-shrink-0">Banco - Cuenta:</label>
                <select name="bank" class="form-select flex-1">
                    <option value="">Seleccionar...</option>
                    <option value="Banco Pichincha">Banco Pichincha</option>
                    <option value="Banco Guayaquil">Banco Guayaquil</option>
                    <option value="Banco Produbanco">Produbanco</option>
                    <option value="Banco Internacional">Banco Internacional</option>
                    <option value="Banco del Pacífico">Banco del Pacífico</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            {{-- Fecha del Pago --}}
            <div class="flex items-center gap-3">
                <label class="text-sm text-gray-600 w-40 flex-shrink-0">Fecha del Pago:</label>
                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="form-input flex-1">
            </div>

            {{-- Número Comprobante --}}
            <div class="flex items-center gap-3">
                <label class="text-sm text-gray-600 w-40 flex-shrink-0">Número Comprobante:</label>
                <input type="text" name="reference" placeholder="Nro. comprobante" class="form-input flex-1">
            </div>

            {{-- Valor --}}
            <div class="flex items-center gap-3">
                <label class="text-sm text-gray-600 w-40 flex-shrink-0">Valor:</label>
                <input type="number" name="amount" id="modalAmount" step="0.01" min="0.01" required
                       class="form-input flex-1" placeholder="0.00">
            </div>

            {{-- Observaciones --}}
            <div class="flex items-start gap-3">
                <label class="text-sm text-gray-600 w-40 flex-shrink-0 mt-2">Observaciones:</label>
                <textarea name="notes" rows="2" class="form-input flex-1" placeholder="Observaciones opcionales"></textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center gap-4 pt-2 border-t border-gray-100">
                <button type="submit" class="btn-primary" style="min-width:100px">Aceptar</button>
                <button type="button" onclick="closePaymentModal()" class="btn-secondary" style="min-width:100px">Cancelar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openPaymentModal(arId, clientName, balance) {
    document.getElementById('modalArId').value = arId;
    document.getElementById('modalClientName').textContent = clientName;
    document.getElementById('modalAmount').value = parseFloat(balance).toFixed(2);
    document.getElementById('paymentModal').classList.remove('hidden');
}
function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) closePaymentModal();
});
</script>
@endpush
