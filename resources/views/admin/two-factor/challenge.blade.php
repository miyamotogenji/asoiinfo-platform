<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verificación 2FA — ASOIINFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif;background:#0a0f1e;min-height:100vh;display:flex;align-items:center;justify-content:center;}</style>
</head>
<body>
<div class="w-full max-w-sm px-4">
    <div class="text-center mb-8">
        <div class="w-14 h-14 mx-auto rounded-2xl flex items-center justify-center mb-4" style="background:linear-gradient(135deg,#6366f1,#7c3aed)">
            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="text-2xl font-bold text-white">Verificación 2FA</h1>
        <p class="text-slate-400 text-sm mt-1">Ingresa el código de tu aplicación autenticadora</p>
    </div>

    <div class="bg-slate-800/60 rounded-2xl border border-slate-700 p-6">
        @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-900/40 border border-red-700 text-red-300 text-sm">
            {{ $errors->first() }}
        </div>
        @endif
        <form method="POST" action="{{ route('admin.two-factor.verify') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-sm text-slate-300 mb-2">Código de verificación</label>
                <input type="text" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                       class="w-full text-center text-2xl font-mono tracking-widest px-4 py-3 bg-slate-900 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none"
                       placeholder="000 000" autofocus autocomplete="one-time-code">
            </div>
            <button type="submit" class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-colors">
                Verificar
            </button>
        </form>
        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="text-sm text-slate-500 hover:text-slate-300 transition-colors">← Cerrar sesión</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
