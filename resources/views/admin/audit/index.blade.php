@extends('layouts.admin')
@section('title','Auditoría')
@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-purple-400">Seguridad</p>
            <h1 class="text-2xl font-bold text-white">Registro de Auditoría</h1>
            <p class="text-sm text-slate-400 mt-0.5">Historial completo de acciones en el sistema</p>
        </div>
        <div class="text-right">
            <span class="text-slate-400 text-sm">{{ number_format($logs->total()) }} registros</span>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-slate-800/60 rounded-2xl border border-slate-700 p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="text-xs text-slate-400 mb-1 block">Acción</label>
                <select name="action" class="px-3 py-2 text-sm bg-slate-900 border border-slate-600 text-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="">Todas</option>
                    @foreach($actions as $a)
                    <option value="{{ $a }}" @selected(request('action')==$a)>{{ ucfirst($a) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-slate-400 mb-1 block">Desde</label>
                <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 text-sm bg-slate-900 border border-slate-600 text-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
            <div>
                <label class="text-xs text-slate-400 mb-1 block">Hasta</label>
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 text-sm bg-slate-900 border border-slate-600 text-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
            <button class="px-5 py-2 bg-purple-600 text-white text-sm font-semibold rounded-xl hover:bg-purple-700 transition-colors">Filtrar</button>
            <a href="{{ route('admin.audit.index') }}" class="px-5 py-2 bg-slate-700 text-slate-200 text-sm font-semibold rounded-xl hover:bg-slate-600 transition-colors">Limpiar</a>
        </form>
    </div>

    <div class="bg-slate-800/60 rounded-2xl border border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-900/60">
                    <tr class="text-left text-xs font-bold uppercase tracking-wider text-slate-400">
                        <th class="px-5 py-3">Fecha y Hora</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Acción</th>
                        <th class="px-4 py-3">Entidad</th>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-700/30 transition-colors">
                    <td class="px-5 py-3 text-slate-400 whitespace-nowrap text-xs">
                        {{ $log->created_at->format('d/m/Y') }}<br>
                        <span class="text-slate-500">{{ $log->created_at->format('H:i:s') }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-slate-200 font-medium">{{ $log->user?->name ?? 'Sistema' }}</span>
                        <p class="text-xs text-slate-500">{{ $log->user?->email }}</p>
                    </td>
                    <td class="px-4 py-3">
                        @php
                        $colors = [
                            'create'  => 'bg-emerald-900/50 text-emerald-400',
                            'update'  => 'bg-blue-900/50 text-blue-400',
                            'delete'  => 'bg-red-900/50 text-red-400',
                            'login'   => 'bg-amber-900/50 text-amber-400',
                            'logout'  => 'bg-slate-700 text-slate-400',
                            'export'  => 'bg-indigo-900/50 text-indigo-400',
                            'emit'    => 'bg-green-900/50 text-green-400',
                            'approve' => 'bg-teal-900/50 text-teal-400',
                        ];
                        $color = $colors[$log->action] ?? 'bg-slate-700 text-slate-300';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $color }}">{{ ucfirst($log->action) }}</span>
                    </td>
                    <td class="px-4 py-3 text-slate-400 text-xs font-mono">
                        {{ class_basename($log->model_type ?? '') ?: '—' }}
                    </td>
                    <td class="px-4 py-3 text-slate-500 text-xs">#{{ $log->model_id ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-500 text-xs font-mono">{{ $log->ip_address ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Sin registros de auditoría.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-slate-700">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
