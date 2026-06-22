@extends('layouts.admin')
@section('title', 'Facturas a emitir — ' . $now->locale('es')->isoFormat('MMMM YYYY'))
@section('breadcrumb', 'Facturación → Emitir facturas')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">Facturas a emitir</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ ucfirst($now->locale('es')->isoFormat('MMMM YYYY')) }} — {{ $services->count() }} servicio(s) pendientes</p>
    </div>
    @if($services->isNotEmpty())
    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-xs text-gray-500">Total a facturar</p>
            <p class="text-xl font-bold text-white">${{ number_format($services->sum('total_value'), 2) }}</p>
        </div>
    </div>
    @endif
</div>

@if($services->isEmpty())
<div class="bg-navy-800 border border-gray-800 rounded-xl p-16 text-center">
    <svg class="w-14 h-14 mx-auto mb-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-base font-semibold text-gray-300">¡Todo al día!</p>
    <p class="text-sm text-gray-500 mt-1">No hay facturas pendientes de emisión para este mes.</p>
    <a href="{{ route('admin.invoices.index') }}" class="inline-block mt-4 text-sm text-indigo-400 hover:underline">Ver facturas emitidas →</a>
</div>
@else

<form method="POST" action="{{ route('admin.invoices.emit-batch') }}" id="emitForm">
    @csrf

    {{-- Batch controls --}}
    <div class="flex items-center gap-3 mb-4 p-4 bg-navy-800 border border-gray-800 rounded-xl">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="chkAll" onchange="toggleAll(this.checked)"
                   class="w-4 h-4 rounded border-gray-600 text-indigo-500 bg-gray-900">
            <span class="text-sm text-gray-300 font-medium">Seleccionar todas</span>
        </label>
        <div class="h-4 w-px bg-gray-700 mx-1"></div>
        <span class="text-sm text-gray-500" id="selectedCount">0 seleccionadas</span>
        <div class="ml-auto">
            <button type="submit"
                    class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Emitir seleccionadas
            </button>
        </div>
    </div>

    {{-- Services table --}}
    <div class="bg-navy-800 border border-gray-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-navy-900/60 border-b border-gray-800">
                    <th class="px-4 py-3.5 w-10"></th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente / Grupo</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">RUC</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sucursal</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                    <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subtotal</th>
                    <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">IVA</th>
                    <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Próx. fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50" id="servicesBody">
                @foreach($services as $s)
                <tr class="hover:bg-navy-700/30 transition-colors" data-row>
                    <td class="px-4 py-3.5 text-center">
                        <input type="checkbox" name="service_ids[]" value="{{ $s->id }}"
                               class="svc-chk w-4 h-4 rounded border-gray-600 text-indigo-500 bg-gray-900"
                               onchange="updateCount()">
                    </td>
                    <td class="px-5 py-3.5">
                        <p class="font-medium text-gray-200 text-xs">{{ $s->businessGroup?->name ?? '—' }}</p>
                        <p class="text-gray-500 text-xs">{{ $now->locale('es')->isoFormat('MMMM YYYY') }}</p>
                    </td>
                    <td class="px-4 py-3.5">
                        <code class="text-xs text-gray-400 font-mono">{{ $s->legalEntity?->ruc ?? '—' }}</code>
                    </td>
                    <td class="px-4 py-3.5 text-xs text-gray-300">{{ $s->branch?->name ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-xs text-gray-300">{{ $s->plan?->name ?? '—' }}</td>
                    <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-300">${{ number_format($s->value, 2) }}</td>
                    <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-400">${{ number_format($s->iva_amount, 2) }}</td>
                    <td class="px-4 py-3.5 text-right font-mono text-sm font-bold text-white">${{ number_format($s->total_value, 2) }}</td>
                    <td class="px-4 py-3.5 text-xs text-gray-400">{{ $s->next_invoice_date?->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t border-gray-700 bg-navy-900/40">
                <tr>
                    <td colspan="5" class="px-5 py-3.5 text-sm font-semibold text-gray-400">Total a facturar este mes</td>
                    <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-400">${{ number_format($services->sum('value'), 2) }}</td>
                    <td class="px-4 py-3.5 text-right font-mono text-xs text-gray-400">${{ number_format($services->sum('iva_amount'), 2) }}</td>
                    <td class="px-4 py-3.5 text-right font-mono text-lg font-bold text-white">${{ number_format($services->sum('total_value'), 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">Las facturas se crearán y se generarán cuentas por cobrar automáticamente.</p>
        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Emitir facturas seleccionadas
        </button>
    </div>
</form>

@endif

@push('scripts')
<script>
function toggleAll(checked) {
    document.querySelectorAll('.svc-chk').forEach(c => c.checked = checked);
    updateCount();
}
function updateCount() {
    const n = document.querySelectorAll('.svc-chk:checked').length;
    document.getElementById('selectedCount').textContent = n + ' seleccionada' + (n === 1 ? '' : 's');
    document.getElementById('chkAll').checked = n === document.querySelectorAll('.svc-chk').length;
}
// Select all by default
document.addEventListener('DOMContentLoaded', () => {
    toggleAll(true);
    document.getElementById('chkAll').checked = true;
});
</script>
@endpush
@endsection
