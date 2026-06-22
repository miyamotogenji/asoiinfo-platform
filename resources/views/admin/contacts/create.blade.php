@extends('layouts.admin')
@section('title', 'Nuevo contacto')
@section('content')
<div class="card" style="max-width:680px">
  <div class="card-header"><span class="card-title">Nuevo contacto</span></div>
  <form method="POST" action="{{ route('admin.contactos.store') }}" style="padding-top:8px">
    @csrf
    @if($convId) <input type="hidden" name="conv_id" value="{{ $convId }}"> @endif
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group" style="grid-column:1/-1">
        <label>Nombre completo *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ old('whatsapp', $whatsapp) }}" class="form-control" placeholder="593991234567">
        @error('whatsapp') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Cargo</label>
        <input type="text" name="position" value="{{ old('position') }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Tipo</label>
        <select name="type" class="form-control">
          <option value="employee" {{ old('type') === 'employee' ? 'selected' : '' }}>Empleado del cliente</option>
          <option value="prospect" {{ old('type') === 'prospect' ? 'selected' : '' }}>Prospecto</option>
          <option value="unknown"  {{ old('type') === 'unknown'  ? 'selected' : '' }}>Desconocido</option>
        </select>
      </div>
      <div class="form-group">
        <label>Grupo empresarial</label>
        <select name="business_group_id" class="form-control">
          <option value="">Ninguno / Prospecto</option>
          @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ old('business_group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Sucursal</label>
        <select name="branch_id" class="form-control">
          <option value="">Sin sucursal</option>
          @foreach($branches as $b)
            <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->code }})</option>
          @endforeach
        </select>
      </div>
    </div>
    <div style="display:flex;gap:20px;margin-top:8px">
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_support" value="1" {{ old('authorized_support') ? 'checked' : '' }}> Autorizado soporte
      </label>
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_invoices" value="1" {{ old('authorized_invoices') ? 'checked' : '' }}> Recibir facturas
      </label>
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_quotes" value="1" {{ old('authorized_quotes') ? 'checked' : '' }}> Aprobar cotizaciones
      </label>
    </div>
    <div class="form-group" style="margin-top:12px">
      <label>Notas</label>
      <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Guardar contacto</button>
      <a href="{{ route('admin.contactos.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
