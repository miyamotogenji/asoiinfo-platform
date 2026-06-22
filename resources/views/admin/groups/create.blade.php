@extends('layouts.admin')
@section('title', 'Nuevo grupo empresarial')
@section('breadcrumb', 'CRM → Grupos → Nuevo')

@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.grupos.index') }}" class="text-gray-500 hover:text-gray-300 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-lg font-semibold text-white">Nuevo grupo empresarial</h2>
    </div>

    <div class="bg-navy-800 border border-gray-800 rounded-xl p-6">
        <form method="POST" action="{{ route('admin.grupos.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Código <span class="text-red-400">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="GRP-001"
                       class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors @error('code') border-red-600 @enderror">
                @error('code')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Nombre del grupo <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Farmacias El Cisne"
                       class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors @error('name') border-red-600 @enderror">
                @error('name')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Estado</label>
                <select name="status" class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 outline-none">
                    <option value="active" {{ old('status','active')=='active'?'selected':'' }}>Activo</option>
                    <option value="suspended" {{ old('status')=='suspended'?'selected':'' }}>Suspendido</option>
                    <option value="blocked" {{ old('status')=='blocked'?'selected':'' }}>Bloqueado</option>
                    <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactivo</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Observaciones</label>
                <textarea name="observations" rows="3" placeholder="Notas internas…"
                          class="w-full bg-gray-950 border border-gray-700 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg px-3.5 py-2.5 text-sm text-gray-100 placeholder-gray-600 outline-none transition-colors resize-none">{{ old('observations') }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition-colors">
                    Crear grupo
                </button>
                <a href="{{ route('admin.grupos.index') }}" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
