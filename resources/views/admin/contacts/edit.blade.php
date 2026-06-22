@extends('layouts.admin')
@section('title', 'Editar contacto: ' . $contact->name)
@section('content')
<div class="card" style="max-width:680px">
  <div class="card-header"><span class="card-title">Editar contacto</span></div>
  <form method="POST" action="{{ route('admin.contactos.update', $contact) }}" style="padding-top:8px">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group" style="grid-column:1/-1">
        <label>Nombre completo *</label>
        <input type="text" name="name" value="{{ old('name', $contact->name) }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>WhatsApp</label>
        <input type="text" name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}" class="form-control">
        @error('whatsapp') <small style="color:#fca5a5">{{ $message }}</small> @enderror
      </div>
      <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Cargo</label>
        <input type="text" name="position" value="{{ old('position', $contact->position) }}" class="form-control">
      </div>
      <div class="form-group">
        <label>Tipo</label>
        <select name="type" class="form-control">
          @foreach(['employee'=>'Empleado','prospect'=>'Prospecto','unknown'=>'Desconocido'] as $v=>$l)
            <option value="{{ $v }}" {{ old('type',$contact->type)===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="status" class="form-control">
          <option value="active"   {{ old('status',$contact->status)==='active'  ?'selected':'' }}>Activo</option>
          <option value="inactive" {{ old('status',$contact->status)==='inactive'?'selected':'' }}>Inactivo</option>
        </select>
      </div>
      <div class="form-group">
        <label>Grupo empresarial</label>
        <select name="business_group_id" class="form-control">
          <option value="">Ninguno</option>
          @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ old('business_group_id',$contact->business_group_id)==$g->id?'selected':'' }}>{{ $g->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Sucursal</label>
        <select name="branch_id" class="form-control">
          <option value="">Sin sucursal</option>
          @foreach($branches as $b)
            <option value="{{ $b->id }}" {{ old('branch_id',$contact->branch_id)==$b->id?'selected':'' }}>{{ $b->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div style="display:flex;gap:20px;margin-top:8px">
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_support" value="1" {{ old('authorized_support',$contact->authorized_support)?'checked':'' }}> Soporte
      </label>
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_invoices" value="1" {{ old('authorized_invoices',$contact->authorized_invoices)?'checked':'' }}> Facturas
      </label>
      <label style="display:flex;gap:8px;cursor:pointer">
        <input type="checkbox" name="authorized_quotes" value="1" {{ old('authorized_quotes',$contact->authorized_quotes)?'checked':'' }}> Cotizaciones
      </label>
    </div>
    <div class="form-group" style="margin-top:12px">
      <label>Notas</label>
      <textarea name="notes" class="form-control" rows="2">{{ old('notes', $contact->notes) }}</textarea>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="{{ route('admin.contactos.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@endsection
