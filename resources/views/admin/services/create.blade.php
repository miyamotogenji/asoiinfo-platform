@extends('layouts.admin')
@section('title', 'Nuevo contrato de servicio')
@section('content')
<div class="card" style="max-width:720px">
  <div class="card-header"><span class="card-title">Contratar servicio / plan</span></div>
  <form method="POST" action="{{ route('admin.servicios.store') }}" style="padding-top:8px" id="svcForm">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
      <div class="form-group">
        <label>Grupo empresarial *</label>
        <select name="business_group_id" id="grpSel" class="form-control" required onchange="filterBranches()">
          <option value="">Seleccionar grupo</option>
          @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ old('business_group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Empresa legal *</label>
        <select name="legal_entity_id" class="form-control" required>
          <option value="">Seleccionar empresa</option>
          @foreach($entities as $e)
            <option value="{{ $e->id }}" data-group="{{ $e->business_group_id }}" {{ old('legal_entity_id')==$e->id?'selected':'' }}>
              {{ $e->legal_name }} — {{ $e->ruc }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Sucursal *</label>
        <select name="branch_id" class="form-control" required>
          <option value="">Seleccionar sucursal</option>
          @foreach($branches as $b)
            <option value="{{ $b->id }}" data-group="{{ $b->business_group_id }}" {{ old('branch_id')==$b->id?'selected':'' }}>
              {{ $b->name }} ({{ $b->code }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Plan *</label>
        <select name="plan_id" id="planSel" class="form-control" required onchange="showPlanInfo()">
          <option value="">Seleccionar plan</option>
          @foreach($plans as $p)
            <option value="{{ $p->id }}" data-price="{{ $p->total_price }}" data-period="{{ $p->period }}" data-day="{{ $p->billing_day_suggestion }}">
              {{ $p->name }} — ${{ number_format($p->total_price,2) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Fecha de inicio *</label>
        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Día de facturación</label>
        <input type="number" name="billing_day" id="billingDay" value="{{ old('billing_day', 1) }}" min="1" max="28" class="form-control">
      </div>
      <div class="form-group" style="grid-column:1/-1">
        <label>Observaciones</label>
        <textarea name="observations" class="form-control" rows="2">{{ old('observations') }}</textarea>
      </div>
    </div>
    <div id="planInfo" style="background:var(--card-bg);border:1px solid var(--border);border-radius:8px;padding:14px;margin:10px 0;display:none">
      Plan seleccionado: <strong id="piName">—</strong> · Total: <strong id="piTotal">—</strong> · Periodicidad: <span id="piPeriod">—</span>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Contratar servicio</button>
      <a href="{{ route('admin.servicios.index') }}" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>
@push('scripts')
<script>
function filterBranches() {
    const gid = document.getElementById('grpSel').value;
    ['[name=legal_entity_id]','[name=branch_id]'].forEach(sel => {
        document.querySelectorAll(sel + ' option[data-group]').forEach(opt => {
            opt.style.display = (!gid || opt.dataset.group === gid) ? '' : 'none';
        });
    });
}
function showPlanInfo() {
    const sel = document.getElementById('planSel');
    const opt = sel.options[sel.selectedIndex];
    if (!opt || !opt.value) { document.getElementById('planInfo').style.display='none'; return; }
    document.getElementById('piName').textContent    = opt.text.split('—')[0].trim();
    document.getElementById('piTotal').textContent   = '$' + opt.dataset.price;
    document.getElementById('piPeriod').textContent  = opt.dataset.period;
    if (opt.dataset.day) document.getElementById('billingDay').value = opt.dataset.day;
    document.getElementById('planInfo').style.display = 'block';
}
filterBranches();
</script>
@endpush
@endsection
