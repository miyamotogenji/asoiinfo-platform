@extends('layouts.admin')
@section('title','Nuevo Usuario')
@section('breadcrumb','Administración → Usuarios → Nuevo')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-ghost btn-sm">← Usuarios</a>
        <div>
            <h2 class="page-heading">Nuevo usuario</h2>
            <p class="page-sub">Crear cuenta y asignar rol de acceso</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 p-4 rounded-xl text-sm" style="background:#7f1d1d30;border:1px solid #dc2626;color:#fca5a5">
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>· {{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card-glass p-6">
        <form method="POST" action="{{ route('admin.usuarios.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Nombre completo *</label>
                <input name="name" value="{{ old('name') }}" required placeholder="Ej. María González"
                       class="form-input">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Email *</label>
                <input name="email" type="email" value="{{ old('email') }}" required placeholder="usuario@asoiinfo.com"
                       class="form-input">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Rol *</label>
                <select name="role" required class="form-input">
                    <option value="">— Seleccionar rol —</option>
                    @php
                    $roleDesc = [
                        'superadmin'    => 'Acceso total al sistema',
                        'admin'         => 'Gestión de clientes y configuración',
                        'accounting'    => 'Facturación, cobros y reportes',
                        'sales'         => 'CRM y gestión comercial',
                        'support_agent' => 'Atención WhatsApp y soporte',
                        'technician'    => 'Soporte técnico básico',
                    ];
                    @endphp
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role')==$role->name ? 'selected':'' }}>
                        {{ ucfirst(str_replace('_',' ',$role->name)) }} — {{ $roleDesc[$role->name] ?? '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Contraseña *</label>
                <input name="password" type="password" required placeholder="Mínimo 8 caracteres"
                       class="form-input">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Confirmar contraseña *</label>
                <input name="password_confirmation" type="password" required placeholder="Repetir contraseña"
                       class="form-input">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
