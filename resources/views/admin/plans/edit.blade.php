@extends('layouts.admin')
@section('title', 'Editar plan: ' . $plan->name)
@section('content')
<div class="card" style="max-width:680px">
  <div class="card-header"><span class="card-title">Editar plan — {{ $plan->code }}</span></div>
  <form method="POST" action="{{ route('admin.planes.update', $plan) }}" style="padding-top:8px">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Código *</label>
        <input type="text" name="code" value="{{ old('code', $plan->code) }}" class="form-control" required>
        @error('code') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Nombre *</label>
        <input type="text" name="name" value="{{ old('name', $plan->name) }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Precio sin IVA *</label>
        <input type="number" name="price_without_iva" value="{{ old('price_without_iva', $plan->price_without_iva) }}" class="form-control" step="0.01" min="0" required>
      </div>
      <div class="form-group">
        <label>IVA (%)</label>
        <input type="number" name="iva_rate" value="{{ old('iva_rate', $plan->iva_rate) }}" class="form-control" step="0.01" min="0" max="100">
      </div>
      <div class="form-group">
        <label>Días de gracia</label>
        <input type="number" name="grace_days" value="{{ old('grace_days', $plan->grace_days) }}" min="0" class="form-control">
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="status" class="form-control">
          <option value="active"   {{ old('status',$plan->status)==='active'  ?'selected':'' }}>Activo</option>
          <option value="inactive" {{ old('status',$plan->status)==='inactive'?'selected':'' }}>Inactivo</option>
        </select>
      </div>
      <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:24px">
        <input type="checkbox" name="auto_block" value="1" id="ab" {{ old('auto_block',$plan->auto_block)?'checked':'' }}>
        <label for="ab" style="margin-bottom:0">Bloqueo automático</label>
      </div>
    </div>
    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description" class="form-control" rows="2">{{ old('description', $plan->description) }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="{{ route('admin.planes.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
