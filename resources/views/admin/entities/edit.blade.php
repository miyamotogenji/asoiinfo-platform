@extends('layouts.admin')
@section('title', 'Editar: ' . $entity->legal_name)
@section('content')
<div class="card" style="max-width:700px">
  <div class="card-header"><span class="card-title">Editar empresa legal</span></div>
  <form method="POST" action="{{ route('admin.empresas.update', $entity) }}" style="padding-top:8px">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>RUC *</label>
        <input type="text" name="ruc" value="{{ old('ruc', $entity->ruc) }}" class="form-control" maxlength="13" required>
        @error('ruc') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Razón social *</label>
        <input type="text" name="legal_name" value="{{ old('legal_name', $entity->legal_name) }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Nombre comercial</label>
        <input type="text" name="trade_name" value="{{ old('trade_name', $entity->trade_name) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $entity->phone) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email', $entity->email) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="status" class="form-control">
          @foreach(['active' => 'Activo','suspended' => 'Suspendido','blocked' => 'Bloqueado','inactive' => 'Inactivo'] as $val => $lbl)
            <option value="{{ $val }}" {{ old('status', $entity->status) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group" style="grid-column:1/-1">
        <label>Dirección</label>
        <input type="text" name="address" value="{{ old('address', $entity->address) }}" class="form-control">
      </div>
      <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:24px">
        <input type="checkbox" name="required_accounting" value="1" id="ra" {{ old('required_accounting', $entity->required_accounting) ? 'checked' : '' }}>
        <label for="ra" style="margin-bottom:0">Obligado a llevar contabilidad</label>
      </div>
    </div>
    <div class="form-group">
      <label>Observaciones</label>
      <textarea name="observations" class="form-control" rows="2">{{ old('observations', $entity->observations) }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="{{ route('admin.empresas.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
