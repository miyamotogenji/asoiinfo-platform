@extends('layouts.admin')
@section('title','Editar — ' . $user->name)
@section('breadcrumb','Administración → Usuarios → Editar')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-ghost btn-sm">← Usuarios</a>
        <div>
            <h2 class="page-heading">Editar usuario</h2>
            <p class="page-sub">{{ $user->email }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 p-4 rounded-xl text-sm" style="background:#7f1d1d30;border:1px solid #dc2626;color:#fca5a5">
        <ul class="space-y-1">@foreach($errors->all() as $e)<li>· {{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card-glass p-6">
        <form method="POST" action="{{ route('admin.usuarios.update', $user) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Nombre completo *</label>
                <input name="name" value="{{ old('name', $user->name) }}" required class="form-input">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Email *</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Rol *</label>
                <select name="role" required class="form-input">
                    @php
                    $roleDesc = [
                        'superadmin'    => 'Acceso total al sistema',
                        'admin'         => 'Gestión de clientes y configuración',
                        'accounting'    => 'Facturación, cobros y reportes',
                        'sales'         => 'CRM y gestión comercial',
                        'support_agent' => 'Atención WhatsApp y soporte',
                        'technician'    => 'Soporte técnico básico',
                    ];
                    $currentRole = $user->roles->first()?->name;
                    @endphp
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ (old('role',$currentRole)==$role->name) ? 'selected':'' }}>
                        {{ ucfirst(str_replace('_',' ',$role->name)) }} — {{ $roleDesc[$role->name] ?? '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div style="border-top:1px solid #1a2235;padding-top:1.25rem">
                <p class="text-xs font-semibold mb-3" style="color:#6b7280">Cambiar contraseña (dejar en blanco para mantener)</p>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Nueva contraseña</label>
                        <input name="password" type="password" placeholder="Mínimo 8 caracteres" class="form-input">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:#9ca3af">Confirmar contraseña</label>
                        <input name="password_confirmation" type="password" placeholder="Repetir contraseña" class="form-input">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>

    @if($user->id !== auth()->id())
    <div class="mt-5 p-4 rounded-xl" style="background:#7f1d1d15;border:1px solid #991b1b30">
        <p class="text-xs font-semibold mb-2" style="color:#fca5a5">Zona peligrosa</p>
        <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}"
              onsubmit="return confirm('¿Eliminar definitivamente a {{ $user->name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Eliminar este usuario</button>
        </form>
    </div>
    @endif
</div>
@endsection
