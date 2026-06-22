@extends('layouts.admin')
@section('title', 'Pagos recibidos')
@section('breadcrumb', 'Facturación → Pagos')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">Pagos recibidos</h2>
        <p class="text-sm text-gray-500 mt-0.5">Registro de todos los pagos — pendientes de aprobación y aprobados</p>
    </div>
    <a href="{{ route('admin.cxc.index') }}"
       class="flex items-center gap-2 px-4 py-2 bg-emerald-700 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Registrar pago
    </a>
</div>

<div class="bg-navy-800 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-navy-900/60 border-b border-gray-800">
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Monto</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Método</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Banco / Referencia</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                <th class="px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-4 py-3.5"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/50">
            @forelse($payments as $payment)
            <tr class="hover:bg-navy-700/30 transition-colors">
                <td class="px-5 py-3.5">
                    <p class="font-medium text-gray-200 text-xs">{{ $payment->branch?->name ?? $payment->businessGroup?->name ?? '—' }}</p>
                    <p class="text-gray-500 text-xs">{{ $payment->businessGroup?->name ?? '' }}</p>
                </td>
                <td class="px-4 py-3.5 text-right font-mono text-sm font-bold text-white">${{ number_format($payment->amount, 2) }}</td>
                <td class="px-4 py-3.5">
                    @php $methods = ['transfer'=>'Transferencia','deposit'=>'Depósito','cash'=>'Efectivo','check'=>'Cheque','card'=>'Tarjeta','manual'=>'Manual']; @endphp
                    <span class="text-xs text-gray-300">{{ $methods[$payment->payment_method] ?? $payment->payment_method }}</span>
                </td>
                <td class="px-4 py-3.5">
                    <p class="text-xs text-gray-400">{{ $payment->bank ?? '—' }}</p>
                    <p class="text-xs text-gray-600 font-mono">{{ $payment->reference_number ?? '' }}</p>
                </td>
                <td class="px-4 py-3.5 text-xs text-gray-400">{{ $payment->payment_date?->format('d/m/Y') }}</td>
                <td class="px-4 py-3.5">
                    @if($payment->status === 'approved')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-900/40 text-emerald-300 border border-emerald-800">Aprobado</span>
                    @elseif($payment->status === 'pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-900/40 text-amber-300 border border-amber-800">Pendiente</span>
                    @elseif($payment->status === 'rejected')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-red-900/40 text-red-300 border border-red-800">Rechazado</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-700 text-gray-400">{{ $payment->status }}</span>
                    @endif
                </td>
                <td class="px-4 py-3.5">
                    @if($payment->status === 'pending')
                    <div class="flex items-center gap-1">
                        <form method="POST" action="{{ route('admin.cxc.approve-payment', $payment) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1.5 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                Aprobar
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.cxc.reject-payment', $payment) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('¿Rechazar este pago?')"
                                    class="px-2.5 py-1.5 bg-red-800/60 hover:bg-red-700 text-red-300 text-xs font-semibold rounded-lg transition-colors">
                                Rechazar
                            </button>
                        </form>
                    </div>
                    @elseif($payment->status === 'approved')
                    <div class="text-xs text-gray-500">
                        Aprobado por {{ $payment->approvedBy?->name ?? 'Sistema' }}
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-16 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p class="font-medium">Sin pagos registrados</p>
                    <p class="text-sm mt-1">
                        <a href="{{ route('admin.cxc.index') }}" class="text-indigo-400 hover:underline">Ir a CxC para registrar un pago</a>
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($payments->hasPages())
<div class="mt-4 flex justify-end">{{ $payments->withQueryString()->links() }}</div>
@endif

@endsection
