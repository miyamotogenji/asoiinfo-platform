@extends('layouts.admin')
@section('title', 'Nueva sucursal')
@section('breadcrumb', 'CRM → Sucursales → Nueva')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost btn-sm">← Volver</a>
        <h2 class="page-heading">Nueva sucursal / agencia</h2>
    </div>

    <div class="card-glass p-6">
        <form method="POST" action="{{ route('admin.sucursales.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Código <span style="color:#ef4444">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" required placeholder="SUC-001" class="form-input @error('code') border-red-500 @enderror">
                    @error('code')<p class="text-xs mt-1" style="color:#f87171">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Nombre <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Sucursal Centro" class="form-input @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-xs mt-1" style="color:#f87171">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Grupo empresarial <span style="color:#ef4444">*</span></label>
                    <select name="business_group_id" required class="form-input">
                        <option value="">Seleccionar grupo...</option>
                        @foreach($groups as $g)<option value="{{ $g->id }}" {{ old('business_group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Empresa (RUC) <span style="color:#ef4444">*</span></label>
                    <select name="legal_entity_id" required class="form-input">
                        <option value="">Seleccionar empresa...</option>
                        @foreach($entities as $e)<option value="{{ $e->id }}" {{ old('legal_entity_id')==$e->id?'selected':'' }}>{{ $e->legal_name }} ({{ $e->ruc }})</option>@endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Guayaquil" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Responsable</label>
                    <input type="text" name="responsible_name" value="{{ old('responsible_name') }}" placeholder="María González" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="042234567" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">WhatsApp (con código país)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="593998881111" class="form-input">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Dirección</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="Cdla Kennedy Norte, Local 15" class="form-input">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Día de facturación</label>
                    <input type="number" name="billing_day" value="{{ old('billing_day', 1) }}" min="1" max="28" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Inicio del servicio</label>
                    <input type="date" name="service_start_date" value="{{ old('service_start_date', date('Y-m-d')) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Estado inicial</label>
                    <select name="status" class="form-input">
                        <option value="active">Activa</option>
                        <option value="suspended">Suspendida</option>
                        <option value="inactive">Inactiva</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Observaciones</label>
                <textarea name="observations" rows="2" placeholder="Notas internas…" class="form-input">{{ old('observations') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Crear sucursal</button>
                <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
