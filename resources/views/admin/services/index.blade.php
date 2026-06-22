@extends('layouts.admin')
@section('title', 'Servicios contratados')
@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:16px">
  <a href="{{ route('admin.servicios.create') }}" class="btn btn-primary">+ Nuevo contrato</a>
</div>
<div class="card">
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Sucursal..." class="form-control" style="max-width:220px">
    <select name="group_id" class="form-control" style="max-width:200px">
      <option value="">Todos los grupos</option>
      @foreach($groups as $g)
        <option value="{{ $g->id }}" {{ request('group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>
      @endforeach
    </select>
    <select name="status" class="form-control" style="max-width:150px">
      <option value="">Todos</option>
      <option value="active"       {{ request('status')==='active'      ?'selected':'' }}>Activo</option>
      <option value="suspended"    {{ request('status')==='suspended'   ?'selected':'' }}>Suspendido</option>
      <option value="cancelled"    {{ request('status')==='cancelled'   ?'selected':'' }}>Cancelado</option>
      <option value="blocked"      {{ request('status')==='blocked'     ?'selected':'' }}>Bloqueado</option>
    </select>
    <button type="submit" class="btn btn-ghost">Filtrar</button>
  </form>
  <table>
    <tr><th>Grupo</th><th>Sucursal</th><th>Plan</th><th>Inicio</th><th>Próx. factura</th><th>Valor</th><th>Estado</th><th>Acciones</th></tr>
    @forelse($services as $s)
    <tr>
      <td>{{ $s->businessGroup->name }}</td>
      <td>{{ $s->branch->name }}<br><small style="color:var(--muted)">{{ $s->legalEntity->ruc }}</small></td>
      <td>{{ $s->plan->name }}<br><small style="color:var(--muted)">{{ $s->plan->period_label }}</small></td>
      <td>{{ $s->start_date?->format('d/m/Y') }}</td>
      <td>{{ $s->next_invoice_date?->format('d/m/Y') ?? '—' }}</td>
      <td>${{ number_format($s->total_value, 2) }}</td>
      <td>
        @if($s->status==='active')     <span class="badge badge-green">Activo</span>
        @elseif($s->status==='blocked')   <span class="badge badge-red">Bloqueado</span>
        @elseif($s->status==='cancelled') <span class="badge badge-gray">Cancelado</span>
        @else <span class="badge badge-yellow">{{ $s->status }}</span>
        @endif
      </td>
      <td>
        @if($s->status === 'active')
        <form method="POST" action="{{ route('admin.servicios.destroy', $s) }}" style="display:inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-ghost btn-sm" onclick="return confirm('¿Cancelar servicio?')">Cancelar</button>
        </form>
        @endif
      </td>
    </tr>
    @empty
    <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px">Sin contratos</td></tr>
    @endforelse
  </table>
  <div class="pagination">{{ $services->withQueryString()->links() }}</div>
</div>
@endsection
