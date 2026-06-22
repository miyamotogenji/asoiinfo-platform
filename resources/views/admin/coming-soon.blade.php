@extends('layouts.admin')
@section('title', $phase['title'] ?? 'Próximamente')
@section('breadcrumb', 'Funcionalidad en desarrollo')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center max-w-lg px-6">

        {{-- Phase badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6 text-sm font-semibold"
             style="background:{{ $phase['bg'] ?? '#1e1b4b' }}20;border:1px solid {{ $phase['bg'] ?? '#6366f1' }}40;color:{{ $phase['color'] ?? '#818cf8' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $phase['label'] ?? 'Phase 2' }} — Planificado para {{ $phase['period'] ?? 'próximas semanas' }}
        </div>

        {{-- Icon --}}
        <div class="w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center"
             style="background:{{ $phase['bg'] ?? '#6366f1' }}15;border:2px solid {{ $phase['bg'] ?? '#6366f1' }}30">
            @if(isset($phase['icon']))
                {!! $phase['icon'] !!}
            @else
            <svg class="w-12 h-12" style="color:{{ $phase['bg'] ?? '#818cf8' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            @endif
        </div>

        <h2 class="text-2xl font-bold text-white mb-2 tracking-tight">{{ $phase['title'] ?? 'Próximamente' }}</h2>
        <p class="text-sm mb-6" style="color:#6b7280">{{ $phase['description'] ?? 'Esta funcionalidad estará disponible en la próxima fase del proyecto.' }}</p>

        {{-- What's included --}}
        @if(!empty($phase['features']))
        <div class="text-left rounded-2xl p-5 mb-6" style="background:#0f1623;border:1px solid #1e2a42">
            <p class="text-xs font-semibold mb-3 uppercase tracking-wider" style="color:#6b7280">Incluye en esta fase:</p>
            <div class="space-y-2">
                @foreach($phase['features'] as $feat)
                <div class="flex items-center gap-2 text-sm" style="color:#9ca3af">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:{{ $phase['bg'] ?? '#818cf8' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    {{ $feat }}
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Client requirements --}}
        @if(!empty($phase['requires']))
        <div class="text-left rounded-2xl p-5 mb-6" style="background:#78350f10;border:1px solid #92400e30">
            <p class="text-xs font-semibold mb-3 uppercase tracking-wider" style="color:#f59e0b">Credenciales requeridas del cliente:</p>
            <div class="space-y-2">
                @foreach($phase['requires'] as $req)
                <div class="flex items-center gap-2 text-sm" style="color:#fbbf24">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    {{ $req }}
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">← Volver al dashboard</a>
            <a href="{{ route('admin.milestone-download') }}" class="btn btn-ghost" target="_blank">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Plan de Hitos Excel
            </a>
        </div>
    </div>
</div>
@endsection
