@extends('layouts.admin')
@section('title', 'Editar: ' . $branch->name)
@section('breadcrumb', 'CRM → Sucursales → Editar')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost btn-sm">← Volver</a>
        <h2 class="page-heading">Editar sucursal — <span style="color:#818cf8">{{ $branch->code }}</span></h2>
    </div>

    <div class="card-glass p-6">
        <form method="POST" action="{{ route('admin.sucursales.update', $branch) }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Código</label>
                    <input type="text" value="{{ $branch->code }}" disabled class="form-input opacity-50">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Nombre <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $branch->name) }}" required class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city', $branch->city) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Responsable</label>
                    <input type="text" name="responsible_name" value="{{ old('responsible_name', $branch->responsible_name) }}" class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $branch->whatsapp) }}" class="form-input">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Dirección</label>
                <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="form-input">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Día de facturación</label>
                    <input type="number" name="billing_day" value="{{ old('billing_day', $branch->billing_day) }}" min="1" max="28" class="form-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Estado</label>
                    <select name="status" class="form-input">
                        @foreach(['active'=>'Activa','suspended'=>'Suspendida','blocked'=>'Bloqueada','closed'=>'Cerrada'] as $v=>$l)
                        <option value="{{ $v }}" {{ $branch->status===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Observaciones</label>
                <textarea name="observations" rows="2" class="form-input">{{ old('observations', $branch->observations) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('admin.sucursales.360', $branch) }}" class="btn btn-ghost">Vista 360°</a>
                <a href="{{ route('admin.sucursales.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
