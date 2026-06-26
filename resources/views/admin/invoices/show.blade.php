@extends('layouts.admin')
@section('title','Factura '.$invoice->number)
@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.invoices.index') }}" class="text-sm text-slate-400 hover:text-slate-200 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Volver
            </a>
            <h1 class="text-2xl font-bold text-white mt-1">Factura {{ $invoice->number }}</h1>
        </div>
        <a href="{{ route('admin.invoices.show', $invoice) }}?export=pdf"
           class="flex items-center gap-2 px-4 py-2 bg-rose-700 hover:bg-rose-600 text-white text-sm font-semibold rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Descargar PDF
        </a>
    </div>

    <div class="bg-slate-800/60 rounded-2xl border border-slate-700 p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-slate-500 uppercase font-bold mb-3">Datos del cliente</p>
                <p class="text-white font-semibold">{{ $invoice->businessGroup?->name }}</p>
                <p class="text-slate-400 text-sm">{{ $invoice->legalEntity?->name }}</p>
                <p class="text-slate-500 text-sm">{{ $invoice->branch?->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500 uppercase font-bold mb-3">Datos de factura</p>
                <p class="text-white font-semibold text-lg">{{ $invoice->number }}</p>
                <p class="text-slate-400 text-sm">Período: {{ $invoice->period_label }}</p>
                <p class="text-slate-400 text-sm">Emisión: {{ $invoice->issue_date?->format('d/m/Y') }}</p>
                <p class="text-slate-400 text-sm">Vencimiento: {{ $invoice->due_date?->format('d/m/Y') }}</p>
                @php
                $statusMap = ['emitted'=>'Emitida','paid'=>'Pagada','overdue'=>'Vencida','cancelled'=>'Anulada'];
                $colorMap  = ['emitted'=>'bg-blue-900/50 text-blue-300','paid'=>'bg-emerald-900/50 text-emerald-300','overdue'=>'bg-red-900/50 text-red-300','cancelled'=>'bg-slate-700 text-slate-400'];
                @endphp
                <span class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $colorMap[$invoice->status] ?? 'bg-slate-700 text-slate-300' }}">
                    {{ $statusMap[$invoice->status] ?? ucfirst($invoice->status) }}
                </span>
            </div>
        </div>

        <hr class="border-slate-700 my-5">

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-500 uppercase font-bold border-b border-slate-700">
                    <th class="pb-2">Descripción</th>
                    <th class="pb-2 text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-3 text-slate-200">{{ $invoice->contractedService?->plan?->name ?? 'Servicio contratado' }}</td>
                    <td class="py-3 text-right text-slate-200">$ {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <hr class="border-slate-700 my-3">

        <div class="flex flex-col items-end gap-1.5">
            <div class="flex items-center justify-between w-56">
                <span class="text-slate-400 text-sm">Subtotal</span>
                <span class="text-slate-200 font-medium">$ {{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            <div class="flex items-center justify-between w-56">
                <span class="text-slate-400 text-sm">IVA 12%</span>
                <span class="text-slate-200 font-medium">$ {{ number_format($invoice->iva_amount, 2) }}</span>
            </div>
            <div class="flex items-center justify-between w-56 pt-2 border-t border-slate-600">
                <span class="text-white font-bold">TOTAL</span>
                <span class="text-white font-bold text-lg">$ {{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
