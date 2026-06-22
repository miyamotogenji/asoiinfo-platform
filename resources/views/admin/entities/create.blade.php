@extends('layouts.admin')
@section('title', 'Nueva empresa legal')
@section('content')
<div class="card" style="max-width:700px">
  <div class="card-header"><span class="card-title">Nueva empresa legal</span></div>
  <form method="POST" action="{{ route('admin.empresas.store') }}" style="padding-top:8px">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Grupo empresarial *</label>
        <select name="business_group_id" class="form-control" required>
          <option value="">Seleccionar grupo</option>
          @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ old('business_group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
          @endforeach
        </select>
        @error('business_group_id') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>RUC * (13 dígitos)</label>
        <input type="text" name="ruc" value="{{ old('ruc') }}" class="form-control" maxlength="13" required>
        @error('ruc') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Razón social *</label>
        <input type="text" name="legal_name" value="{{ old('legal_name') }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Nombre comercial</label>
        <input type="text" name="trade_name" value="{{ old('trade_name') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
      </div>
      <div class="form-group" style="grid-column:1/-1">
        <label>Dirección</label>
        <input type="text" name="address" value="{{ old('address') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Tipo contribuyente</label>
        <select name="taxpayer_type" class="form-control">
          <option value="juridical">Jurídico</option>
          <option value="natural">Natural</option>
          <option value="public">Público</option>
        </select>
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="status" class="form-control">
          <option value="active">Activo</option>
          <option value="suspended">Suspendido</option>
          <option value="inactive">Inactivo</option>
        </select>
      </div>
      <div class="form-group" style="display:flex;align-items:center;gap:10px;padding-top:24px">
        <input type="checkbox" name="required_accounting" value="1" id="ra" {{ old('required_accounting') ? 'checked' : '' }}>
        <label for="ra" style="margin-bottom:0">Obligado a llevar contabilidad</label>
      </div>
    </div>
    <div class="form-group">
      <label>Observaciones</label>
      <textarea name="observations" class="form-control" rows="2">{{ old('observations') }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Guardar empresa</button>
      <a href="{{ route('admin.empresas.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
