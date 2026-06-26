@extends('layouts.admin')
@section('title', 'Facturas a Emitir')
@section('breadcrumb', 'Facturación → Facturas a Emitir')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-xl font-800 text-gray-900" style="font-weight:800">Facturas a Emitir</h1>
        <p class="text-sm text-gray-400 mt-0.5">Servicios activos que deben facturarse en {{ $now->locale('es')->isoFormat('MMMM YYYY') }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.invoices.emit-batch') }}" id="emitForm">
@csrf

<div class="page-card mb-4">
    <div class="page-card-header">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="selectAll" class="w-4 h-4 accent-indigo-600 cursor-pointer" onchange="toggleAll(this)">
            <label for="selectAll" class="text-sm font-600 text-gray-700 cursor-pointer" style="font-weight:600">Seleccionar todo</label>
            <span class="badge badge-blue">{{ $services->count() }} servicios</span>
        </div>
        <div class="flex gap-2">
            <button type="submit" name="action" value="selected"
                    class="btn-primary btn-sm" onclick="return confirmEmit()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Emitir Seleccionadas
            </button>
            <a href="{{ route('admin.invoices.index') }}" class="btn-secondary btn-sm">Ver emitidas</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-10"></th>
                    <th>Cliente / Grupo</th>
                    <th>Sucursal</th>
                    <th>Plan / Servicio</th>
                    <th>Período</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">IVA</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Periodicidad</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $svc)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}"
                               class="row-check w-4 h-4 accent-indigo-600 cursor-pointer">
                    </td>
                    <td>
                        <div class="font-600 text-gray-800 text-sm" style="font-weight:600">{{ $svc->businessGroup->name ?? '—' }}</div>
                        <div class="text-xs text-gray-400">{{ $svc->legalEntity->name ?? '' }}</div>
                    </td>
                    <td>
                        <div class="text-sm text-gray-600">{{ $svc->branch->name ?? '—' }}</div>
                    </td>
                    <td>
                        <div class="font-500 text-sm text-gray-700" style="font-weight:500">{{ $svc->plan->name ?? '—' }}</div>
                        <div class="text-xs text-gray-400">{{ $svc->plan->billable_product ?? '' }}</div>
                    </td>
                    <td class="text-sm text-gray-500">{{ $now->locale('es')->isoFormat('MMMM YYYY') }}</td>
                    <td class="text-right text-sm text-gray-600">${{ number_format($svc->value, 2) }}</td>
                    <td class="text-right text-sm text-gray-500">
                        {{ $svc->plan->iva_rate ?? 15 }}%
                        <br><span class="text-xs">${{ number_format($svc->iva_amount, 2) }}</span>
                    </td>
                    <td class="text-right font-700 text-sm text-gray-900" style="font-weight:700">${{ number_format($svc->total_value, 2) }}</td>
                    <td class="text-center">
                        @php $p = $svc->plan->period ?? 'monthly'; @endphp
                        @if($p==='monthly')   <span class="badge badge-blue">Mensual</span>
                        @elseif($p==='annual') <span class="badge badge-purple">Anual</span>
                        @elseif($p==='quarterly') <span class="badge badge-gray">Trimestral</span>
                        @else <span class="badge badge-gray">{{ $p }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-14">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-400 text-sm">No hay servicios para facturar este mes.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($services->count() > 0)
            <tfoot>
                <tr class="bg-gray-50">
                    <td colspan="7" class="px-4 py-3 text-right text-sm font-700 text-gray-700" style="font-weight:700">Total a emitir:</td>
                    <td class="px-4 py-3 text-right text-base font-800 text-indigo-600" style="font-weight:800">
                        ${{ number_format($services->sum('total_value'), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
}
function confirmEmit() {
    const checked = document.querySelectorAll('.row-check:checked').length;
    if (checked === 0) { alert('Selecciona al menos una factura para emitir.'); return false; }
    return confirm(`¿Emitir ${checked} factura(s)? Esta acción generará CxC automáticamente.`);
}
</script>
@endpush
