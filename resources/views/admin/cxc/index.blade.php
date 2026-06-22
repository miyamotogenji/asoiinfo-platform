@extends('layouts.admin')
@section('title', 'Cuentas por cobrar')
@section('breadcrumb', 'Facturación → CxC')

@section('content')

{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-navy-800 border border-gray-800 rounded-xl p-4">
        <p class="text-xs text-gray-500 font-medium mb-1">Total por cobrar</p>
        <p class="text-2xl font-bold text-white">${{ number_format($totals['total_receivable'], 2) }}</p>
        <p class="text-xs text-gray-600 mt-1">Pendiente + Vencido + Parcial</p>
    </div>
    <div class="bg-navy-800 border border-gray-800 rounded-xl p-4">
        <p class="text-xs text-gray-500 font-medium mb-1">Vencido</p>
        <p class="text-2xl font-bold text-red-400">${{ number_format($totals['overdue'], 2) }}</p>
        <p class="text-xs text-gray-600 mt-1">Facturas vencidas</p>
    </div>
    <div class="bg-navy-800 border border-gray-800 rounded-xl p-4">
        <p class="text-xs text-gray-500 font-medium mb-1">Pendiente</p>
        <p class="text-2xl font-bold text-amber-400">${{ number_format($totals['pending'], 2) }}</p>
        <p class="text-xs text-gray-600 mt-1">Aún no vencido</p>
    </div>
    <div class="bg-navy-800 border border-gray-800 rounded-xl p-4">
        <p class="text-xs text-gray-500 font-medium mb-1">Cobrado este mes</p>
        <p class="text-2xl font-bold text-emerald-400">${{ number_format($totals['paid_month'], 2) }}</p>
        <p class="text-xs text-gray-600 mt-1">Pagos aprobados</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Buscar cliente, sucursal, factura…"
           class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 placeholder-gray-600 outline-none w-64">
    <select name="status" class="bg-gray-900 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2 text-sm text-gray-200 outline-none">
        <option value="">Todos los estados</option>
        <option value="pending"     {{ request('status')=='pending'    ?'selected':'' }}>Pendiente</option>
        <option value="overdue"     {{ request('status')=='overdue'    ?'selected':'' }}>Vencido</option>
        <option value="partial"     {{ request('status')=='partial'    ?'selected':'' }}>Parcial</option>
        <option value="paid"        {{ request('status')=='paid'       ?'selected':'' }}>Pagado</option>
        <option value="in_agreement"{{ request('status')=='in_agreement'?'selected':'' }}>En convenio</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 text-sm rounded-lg transition-colors">Filtrar</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.cxc.index') }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-400 text-sm rounded-lg transition-colors">Limpiar</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-navy-800 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-navy-900/60 border-b border-gray-800">
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente / Sucursal</th>
                <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Factura</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Valor</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Días</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vence</th>
                <th class="px-4 py-3.5"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/50">
            @forelse($accounts as $ar)
            <tr class="hover:bg-navy-700/30 transition-colors">
                <td class="px-5 py-3.5">
                    <p class="font-medium text-gray-200 text-xs">{{ $ar->branch->name ?? '—' }}</p>
                    <p class="text-gray-500 text-xs">{{ $ar->businessGroup->name ?? '' }}</p>
                </td>
                <td class="px-4 py-3.5">
                    <code class="text-indigo-400 text-xs font-mono">{{ $ar->invoice->number ?? '—' }}</code>
                    <p class="text-gray-600 text-xs mt-0.5">{{ $ar->invoice?->issue_date?->format('d/m/Y') ?? '' }}</p>
                </td>
                <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-300">${{ number_format($ar->amount, 2) }}</td>
                <td class="px-4 py-3.5 text-right font-mono text-sm font-semibold text-white">${{ number_format($ar->balance, 2) }}</td>
                <td class="px-4 py-3.5 text-right text-xs font-semibold {{ $ar->days_overdue > 0 ? 'text-red-400' : 'text-gray-500' }}">
                    {{ $ar->days_overdue > 0 ? $ar->days_overdue.'d' : '—' }}
                </td>
                <td class="px-4 py-3.5">
                    @switch($ar->status)
                        @case('pending')    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-900/40 text-amber-300 border border-amber-800">Pendiente</span> @break
                        @case('overdue')    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-red-900/40 text-red-300 border border-red-800">Vencido</span> @break
                        @case('partial')    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-900/40 text-amber-300 border border-amber-800">Parcial</span> @break
                        @case('paid')       <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-900/40 text-emerald-300 border border-emerald-800">Pagado</span> @break
                        @case('in_agreement') <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-blue-900/40 text-blue-300 border border-blue-800">Convenio</span> @break
                        @default <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-700 text-gray-400">{{ $ar->status }}</span>
                    @endswitch
                </td>
                <td class="px-4 py-3.5 text-xs {{ $ar->due_date?->isPast() ? 'text-red-400' : 'text-gray-400' }}">
                    {{ $ar->due_date?->format('d/m/Y') ?? '—' }}
                </td>
                <td class="px-4 py-3.5">
                    <div class="flex items-center gap-1">
                        @if($ar->status !== 'paid')
                        <button onclick="openPaymentModal({{ $ar->id }}, '{{ addslashes($ar->branch->name ?? '') }}', {{ $ar->balance }})"
                                class="flex items-center gap-1 px-2.5 py-1.5 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-medium rounded-lg transition-colors">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Pago
                        </button>
                        @endif
                        @if($ar->branch && $ar->branch->status !== 'blocked')
                        <form method="POST" action="{{ route('admin.cxc.block-branch', $ar->branch_id) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('¿Bloquear la sucursal {{ addslashes($ar->branch->name ?? '') }}?')"
                                    class="flex items-center gap-1 px-2.5 py-1.5 bg-red-800/60 hover:bg-red-700 text-red-300 hover:text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Bloquear
                            </button>
                        </form>
                        @elseif($ar->branch && $ar->branch->status === 'blocked')
                        <form method="POST" action="{{ route('admin.cxc.unblock-branch', $ar->branch_id) }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-1 px-2.5 py-1.5 bg-emerald-900/40 hover:bg-emerald-800 text-emerald-400 hover:text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Desbloquear
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-5 py-16 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Sin cuentas por cobrar
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($accounts->hasPages())
<div class="mt-4 flex justify-end">{{ $accounts->withQueryString()->links() }}</div>
@endif

{{-- ── Payment Modal ── --}}
<div id="paymentModal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-700 rounded-2xl w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h3 class="text-base font-semibold text-white">Registrar pago</h3>
            <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-300 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.cxc.store-payment') }}" class="px-6 py-5 space-y-4">
            @csrf
            <input type="hidden" name="account_receivable_id" id="modalArId">
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Cliente</label>
                <input type="text" id="modalClientName" readonly
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3.5 py-2.5 text-sm text-gray-400 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Monto recibido <span class="text-red-400">*</span></label>
                    <input type="number" name="amount" id="modalAmount" step="0.01" min="0.01" required
                           class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Fecha de pago <span class="text-red-400">*</span></label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                           class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 outline-none transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Método de pago <span class="text-red-400">*</span></label>
                <select name="payment_method" required
                        class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 outline-none">
                    <option value="transfer">Transferencia bancaria</option>
                    <option value="deposit">Depósito</option>
                    <option value="cash">Efectivo</option>
                    <option value="check">Cheque</option>
                    <option value="card">Tarjeta</option>
                    <option value="manual">Manual (otro)</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Banco</label>
                    <input type="text" name="bank" placeholder="Banco Pichincha"
                           class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Nro. comprobante</label>
                    <input type="text" name="reference_number" placeholder="001234567890"
                           class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Observaciones</label>
                <textarea name="notes" rows="2" placeholder="Notas internas…"
                          class="w-full bg-gray-950 border border-gray-700 focus:border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold rounded-lg transition-colors">
                    Registrar pago
                </button>
                <button type="button" onclick="closePaymentModal()"
                        class="flex-1 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openPaymentModal(arId, clientName, balance) {
    document.getElementById('modalArId').value = arId;
    document.getElementById('modalClientName').value = clientName;
    document.getElementById('modalAmount').value = balance.toFixed(2);
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
@endsection
