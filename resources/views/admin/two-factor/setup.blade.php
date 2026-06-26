@extends('layouts.admin')
@section('title','Autenticación de Dos Factores')
@section('content')
<div class="max-w-lg mx-auto space-y-5">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-purple-400">Seguridad</p>
        <h1 class="text-2xl font-bold text-white">Autenticación de Dos Factores</h1>
        <p class="text-sm text-slate-400 mt-1">Protege tu cuenta con un segundo factor de verificación.</p>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-900/40 border border-emerald-700 text-emerald-300 text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-slate-800/60 rounded-2xl border border-slate-700 p-6">
        @if($user->two_factor_confirmed)
        {{-- 2FA is active --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-emerald-900/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-emerald-400 font-semibold">2FA Activado</p>
                <p class="text-slate-400 text-sm">Tu cuenta está protegida con autenticación de dos factores.</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.two-factor.disable') }}">
            @csrf @method('DELETE')
            <div class="mb-4">
                <label class="block text-sm text-slate-300 mb-1.5">Confirma tu contraseña para desactivar</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="••••••••">
                @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="px-5 py-2.5 bg-red-700 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition-colors">Desactivar 2FA</button>
        </form>

        @elseif($user->two_factor_secret && $qrCode)
        {{-- QR code scan step --}}
        <h3 class="text-white font-semibold mb-4">Paso 2: Escanea el código QR</h3>
        <p class="text-slate-400 text-sm mb-4">Abre <strong class="text-slate-200">Google Authenticator</strong> o <strong class="text-slate-200">Authy</strong> y escanea este código:</p>
        <div class="flex justify-center mb-5 p-4 bg-white rounded-2xl">
            <img src="data:image/svg+xml;base64,{{ $qrCode }}" class="w-48 h-48" alt="QR Code">
        </div>
        <p class="text-slate-400 text-sm mb-4">Luego ingresa el código de 6 dígitos que aparece en tu app:</p>
        <form method="POST" action="{{ route('admin.two-factor.confirm') }}" class="flex gap-3">
            @csrf
            <input type="text" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                   class="w-32 text-center text-xl font-mono px-3 py-2.5 bg-slate-900 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none"
                   placeholder="000000" autofocus>
            <button class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition-colors">Confirmar</button>
            @error('code')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </form>

        @else
        {{-- 2FA disabled, offer to enable --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <p class="text-slate-200 font-semibold">2FA Desactivado</p>
                <p class="text-slate-400 text-sm">Activa 2FA para mayor seguridad de tu cuenta.</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.two-factor.enable') }}">
            @csrf
            <button class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition-colors">
                Activar autenticación de dos factores
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
