@extends('layouts.admin')
@section('title', 'Nuevo plan')
@section('breadcrumb', 'Planes → Nuevo')
@section('content')
<div class="max-w-3xl">
  <div class="flex items-center gap-3 mb-5">
    <a href="{{ route('admin.planes.index') }}" class="btn-secondary btn-sm">← Volver</a>
    <h1 class="text-lg font-700 text-gray-800" style="font-weight:700">Nuevo Plan / Servicio</h1>
  </div>
  <div class="page-card">
    <form method="POST" action="{{ route('admin.planes.store') }}" class="p-6">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Código *</label>
          <input type="text" name="code" value="{{ old('code') }}" class="form-input" placeholder="SPARTHA-POS-M" required>
          @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Nombre del plan *</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Spartha POS Mensual" required></div>
        <div><label class="form-label">Tipo *</label>
          <select name="type" class="form-select" required>
            <option value="recurring" {{ old('type')==='recurring'?'selected':'' }}>Recurrente</option>
            <option value="one_time"  {{ old('type')==='one_time' ?'selected':'' }}>Venta única</option>
          </select></div>
        <div><label class="form-label">Periodicidad *</label>
          <select name="period" class="form-select" required>
            <option value="monthly"   {{ old('period')==='monthly'  ?'selected':'' }}>Mensual</option>
            <option value="annual"    {{ old('period')==='annual'   ?'selected':'' }}>Anual</option>
            <option value="quarterly" {{ old('period')==='quarterly'?'selected':'' }}>Trimestral</option>
            <option value="biannual"  {{ old('period')==='biannual' ?'selected':'' }}>Semestral</option>
          </select></div>
        <div><label class="form-label">Precio sin IVA * ($)</label>
          <input type="number" name="price_without_iva" value="{{ old('price_without_iva') }}" class="form-input" step="0.01" min="0" required></div>
        <div><label class="form-label">Tarifa IVA (Ecuador)</label>
          <select name="iva_rate" class="form-select">
            <option value="0"  {{ old('iva_rate','15')==='0'  ?'selected':'' }}>0% — Tarifa 0</option>
            <option value="5"  {{ old('iva_rate','15')==='5'  ?'selected':'' }}>5% — Tarifa reducida</option>
            <option value="15" {{ old('iva_rate','15')==='15' ?'selected':'' }}>15% — Tarifa general</option>
          </select></div>
        <div><label class="form-label">Producto facturable</label>
          <input type="text" name="billable_product" value="{{ old('billable_product') }}" class="form-input" placeholder="Servicio de software"></div>
        <div><label class="form-label">Día de facturación sugerido</label>
          <input type="number" name="billing_day_suggestion" value="{{ old('billing_day_suggestion', 1) }}" min="1" max="28" class="form-input"></div>
        <div><label class="form-label">Días de gracia</label>
          <input type="number" name="grace_days" value="{{ old('grace_days', 5) }}" min="0" class="form-input"></div>
        <div><label class="form-label">Estado</label>
          <select name="status" class="form-select">
            <option value="active">Activo</option>
            <option value="inactive">Inactivo</option>
          </select></div>
        <div class="flex items-center gap-2 mt-5">
          <input type="checkbox" name="auto_block" value="1" id="ab" class="w-4 h-4 accent-indigo-600" {{ old('auto_block') ? 'checked' : '' }}>
          <label for="ab" class="text-sm text-gray-600 cursor-pointer">Aplica bloqueo automático por mora</label>
        </div>
      </div>
      <div class="mt-4"><label class="form-label">Descripción</label>
        <textarea name="description" class="form-input" rows="2">{{ old('description') }}</textarea></div>
      <div class="flex gap-3 mt-5 pt-4 border-t border-gray-100">
        <button type="submit" class="btn-primary">Guardar plan</button>
        <a href="{{ route('admin.planes.index') }}" class="btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection
