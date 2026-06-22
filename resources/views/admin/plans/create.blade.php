@extends('layouts.admin')
@section('title', 'Nuevo plan')
@section('content')
<div class="card" style="max-width:680px">
  <div class="card-header"><span class="card-title">Nuevo plan / servicio</span></div>
  <form method="POST" action="{{ route('admin.planes.store') }}" style="padding-top:8px">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Código *</label>
        <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="SPARTHA-POS-M" required>
        @error('code') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Nombre del plan *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Spartha POS Mensual" required>
      </div>
      <div class="form-group">
        <label>Tipo *</label>
        <select name="type" class="form-control" required>
          <option value="recurring" {{ old('type')==='recurring'?'selected':'' }}>Recurrente</option>
          <option value="one_time"  {{ old('type')==='one_time' ?'selected':'' }}>Venta única</option>
        </select>
      </div>
      <div class="form-group">
        <label>Periodicidad *</label>
        <select name="period" class="form-control" required>
          <option value="monthly"   {{ old('period')==='monthly'  ?'selected':'' }}>Mensual</option>
          <option value="annual"    {{ old('period')==='annual'   ?'selected':'' }}>Anual</option>
          <option value="quarterly" {{ old('period')==='quarterly'?'selected':'' }}>Trimestral</option>
          <option value="biannual"  {{ old('period')==='biannual' ?'selected':'' }}>Semestral</option>
        </select>
      </div>
      <div class="form-group">
        <label>Precio sin IVA * ($)</label>
        <input type="number" name="price_without_iva" value="{{ old('price_without_iva') }}" class="form-control" step="0.01" min="0" required>
      </div>
      <div class="form-group">
        <label>IVA (%)</label>
        <input type="number" name="iva_rate" value="{{ old('iva_rate', 15) }}" class="form-control" step="0.01" min="0" max="100">
      </div>
      <div class="form-group">
        <label>Producto facturable</label>
        <input type="text" name="billable_product" value="{{ old('billable_product') }}" class="form-control" placeholder="Servicio de software">
      </div>
      <div class="form-group">
        <label>Día de facturación sugerido</label>
        <input type="number" name="billing_day_suggestion" value="{{ old('billing_day_suggestion', 1) }}" min="1" max="28" class="form-control">
      </div>
      <div class="form-group">
        <label>Días de gracia</label>
        <input type="number" name="grace_days" value="{{ old('grace_days', 5) }}" min="0" class="form-control">
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="status" class="form-control">
          <option value="active">Activo</option>
          <option value="inactive">Inactivo</option>
        </select>
      </div>
      <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:24px">
        <input type="checkbox" name="auto_block" value="1" id="ab" {{ old('auto_block') ? 'checked' : '' }}>
        <label for="ab" style="margin-bottom:0">Aplica bloqueo automático</label>
      </div>
    </div>
    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Guardar plan</button>
      <a href="{{ route('admin.planes.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
