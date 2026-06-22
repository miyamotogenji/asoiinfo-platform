<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — ASOIINFO Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family:'Plus Jakarta Sans',system-ui,sans-serif }
        .form-input {
            width:100%; background:rgba(9,14,26,.9); border:1px solid #1e2a42;
            border-radius:10px; padding:12px 16px; font-size:.875rem;
            color:#e5e7eb; outline:none; transition:all .15s; font-family:inherit;
        }
        .form-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.15) }
        .form-input::placeholder { color:#374151 }
    </style>
</head>
<body class="h-full flex items-center justify-center" style="background:#060b14;background-image:url('/login-bg.png');background-size:cover;background-position:center">

{{-- Glassmorphism overlay --}}
<div class="absolute inset-0" style="background:rgba(6,11,20,.75)"></div>

<div class="relative z-10 w-full max-w-md px-4">

    {{-- Logo / Brand --}}
    <div class="text-center mb-8">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO"
             class="h-20 w-auto object-contain mx-auto mb-2"
             style="filter:drop-shadow(0 0 20px rgba(99,102,241,.6))">
        <p class="text-sm mt-1.5" style="color:#6b7280">Sistema Multiempresa · CRM · Facturación · WhatsApp</p>
    </div>

    {{-- Card --}}
    <div class="rounded-2xl p-8" style="background:rgba(15,22,35,.8);border:1px solid #1e2a42;backdrop-filter:blur(20px);box-shadow:0 25px 50px rgba(0,0,0,.5)">

        <h2 class="text-base font-semibold text-white mb-6">Iniciar sesión</h2>

        @if($errors->any())
        <div class="flex items-start gap-3 rounded-xl p-3 mb-5 text-sm" style="background:#7f1d1d30;border:1px solid #dc2626;color:#fca5a5">
            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-600 mb-2" style="color:#9ca3af;font-weight:600">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@asoiinfo.com" class="form-input">
            </div>
            <div>
                <label class="block text-xs font-600 mb-2" style="color:#9ca3af;font-weight:600">Contraseña</label>
                <input type="password" name="password" required placeholder="••••••••" class="form-input">
            </div>
            <button type="submit"
                    class="w-full py-3 rounded-xl text-sm font-700 text-white transition-all"
                    style="background:linear-gradient(135deg,#6366f1,#4f46e5);box-shadow:0 4px 20px rgba(99,102,241,.4);font-weight:700"
                    onmouseover="this.style.boxShadow='0 6px 28px rgba(99,102,241,.6)'"
                    onmouseout="this.style.boxShadow='0 4px 20px rgba(99,102,241,.4)'">
                Ingresar al sistema →
            </button>
        </form>
    </div>

    {{-- Feature badges --}}
    <div class="mt-6">
        <img src="/feature-badges.png" alt="Features" class="w-full opacity-80 rounded-xl">
    </div>

    {{-- Credentials hint --}}
    <div class="mt-4 text-center space-y-1">
        <p class="text-xs" style="color:#374151">
            <span style="color:#4b5563">Admin:</span>
            <span style="color:#6b7280">admin@asoiinfo.com / Admin2026!</span>
        </p>
        <p class="text-xs" style="color:#374151">
            <span style="color:#4b5563">Asesor:</span>
            <span style="color:#6b7280">asesor@asoiinfo.com / Agent2026!</span>
        </p>
    </div>
</div>

</body>
</html>
