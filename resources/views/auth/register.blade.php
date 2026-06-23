<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta — ASOIINFO Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *, *::before, *::after { box-sizing:border-box; font-family:'Space Grotesk',system-ui,sans-serif }

        body { min-height:100vh; background:#04080f; overflow-x:hidden }

        /* Background */
        .bg-layer {
            position:fixed; inset:0; z-index:0;
            background:
                radial-gradient(ellipse 800px 600px at 10% 20%, rgba(99,102,241,.1) 0%, transparent 70%),
                radial-gradient(ellipse 600px 500px at 90% 80%, rgba(139,92,246,.08) 0%, transparent 70%);
        }
        .grid-bg {
            position:fixed; inset:0; z-index:0;
            background-image:linear-gradient(rgba(99,102,241,.035) 1px,transparent 1px),
                             linear-gradient(90deg,rgba(99,102,241,.035) 1px,transparent 1px);
            background-size:64px 64px;
        }
        /* Glowing line accent */
        .line-accent {
            position:fixed; top:0; left:0; right:0; height:2px; z-index:20;
            background:linear-gradient(90deg,transparent 0%,#6366f1 30%,#a78bfa 60%,transparent 100%);
            opacity:.8;
        }

        /* Card */
        .auth-card {
            background:rgba(8,14,26,.82);
            border:1px solid rgba(99,102,241,.18);
            border-radius:24px;
            backdrop-filter:blur(32px);
            -webkit-backdrop-filter:blur(32px);
            box-shadow:0 32px 72px rgba(0,0,0,.7), 0 0 0 1px rgba(255,255,255,.03) inset;
        }

        /* Input */
        .inp {
            width:100%; background:rgba(4,8,16,.9);
            border:1.5px solid rgba(30,42,66,.9);
            border-radius:12px; padding:13px 16px;
            font-size:.975rem; color:#e5e7eb;
            outline:none; transition:all .2s; font-family:inherit;
        }
        .inp:focus {
            border-color:#6366f1; background:rgba(4,8,16,1);
            box-shadow:0 0 0 4px rgba(99,102,241,.1);
        }
        .inp::placeholder { color:#2d3748 }
        .inp.error { border-color:rgba(239,68,68,.6) }

        /* Password strength bar */
        .strength-bar { height:3px; border-radius:2px; transition:all .3s; margin-top:6px }

        /* Button */
        .btn-submit {
            width:100%; padding:14px 24px; border-radius:12px;
            font-size:1rem; font-weight:700; color:#fff; border:none; cursor:pointer;
            background:linear-gradient(135deg,#6366f1,#4f46e5,#7c3aed);
            box-shadow:0 6px 24px rgba(99,102,241,.4), 0 1px 0 rgba(255,255,255,.12) inset;
            transition:all .2s; letter-spacing:.015em; font-family:inherit;
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(99,102,241,.55) }
        .btn-submit:active { transform:translateY(0) }
        .btn-submit:disabled { opacity:.5; cursor:not-allowed; transform:none }

        /* Label */
        .lbl { display:block; font-size:.825rem; font-weight:600; color:#6b7280; margin-bottom:7px; letter-spacing:.02em; text-transform:uppercase }

        /* Error message */
        .err-msg { font-size:.8rem; color:#f87171; margin-top:5px; display:flex; align-items:center; gap:4px }

        /* Animations */
        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
        .fu  { animation:fadeUp .5s ease forwards }
        .d1  { animation-delay:.05s; opacity:0 }
        .d2  { animation-delay:.12s; opacity:0 }
        .d3  { animation-delay:.18s; opacity:0 }
        .d4  { animation-delay:.24s; opacity:0 }
        .d5  { animation-delay:.30s; opacity:0 }
    </style>
</head>
<body>
<div class="bg-layer"></div>
<div class="grid-bg"></div>
<div class="line-accent"></div>

<div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-10">

    {{-- Logo --}}
    <div class="text-center mb-7 fu">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO"
             style="height:100px;width:auto;object-fit:contain;display:block;margin:0 auto;
                    mix-blend-mode:screen;
                    filter:drop-shadow(0 0 30px rgba(99,102,241,.8)) drop-shadow(0 0 10px rgba(167,139,250,.5))">
        <p class="mt-3 text-xs font-medium tracking-widest" style="color:#4b5563;letter-spacing:.12em">
            SISTEMA MULTIEMPRESA &nbsp;·&nbsp; CRM &nbsp;·&nbsp; FACTURACIÓN
        </p>
    </div>

    {{-- Card --}}
    <div class="auth-card w-full fu d1" style="max-width:460px">
        <div class="p-8 md:p-10">

            {{-- Header --}}
            <div class="mb-7 fu d2">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background:linear-gradient(135deg,#6366f1,#7c3aed)">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white" style="letter-spacing:-.02em">Crear cuenta</h1>
                </div>
                <p class="text-sm" style="color:#6b7280;padding-left:44px">Regístrate para acceder a la plataforma</p>
            </div>

            {{-- Global error --}}
            @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password'))
            <div class="flex items-start gap-3 rounded-xl p-4 mb-5"
                 style="background:rgba(127,29,29,.2);border:1px solid rgba(220,38,38,.35);color:#fca5a5;font-size:.875rem">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="regForm">
                @csrf

                {{-- Name --}}
                <div class="fu d2">
                    <label class="lbl">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           required autocomplete="name"
                           placeholder="Juan García"
                           class="inp {{ $errors->has('name') ? 'error' : '' }}">
                    @error('name')
                        <p class="err-msg">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="fu d3">
                    <label class="lbl">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required autocomplete="email"
                           placeholder="usuario@empresa.com"
                           class="inp {{ $errors->has('email') ? 'error' : '' }}">
                    @error('email')
                        <p class="err-msg">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="fu d4">
                    <label class="lbl">Contraseña</label>
                    <input type="password" name="password" id="pw" required
                           autocomplete="new-password"
                           placeholder="Mínimo 8 caracteres"
                           class="inp {{ $errors->has('password') ? 'error' : '' }}"
                           oninput="checkStrength(this.value)">
                    <div id="strengthBar" class="strength-bar" style="background:#1e2a42;width:0%"></div>
                    <p id="strengthTxt" class="text-xs mt-1" style="color:#374151;min-height:16px"></p>
                    @error('password')
                        <p class="err-msg">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm --}}
                <div class="fu d4">
                    <label class="lbl">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="pwc" required
                           autocomplete="new-password"
                           placeholder="Repite tu contraseña"
                           class="inp"
                           oninput="checkMatch()">
                    <p id="matchTxt" class="text-xs mt-1" style="min-height:16px"></p>
                </div>

                {{-- Submit --}}
                <div class="fu d5 pt-1">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        Crear cuenta &nbsp;→
                    </button>
                </div>
            </form>

        </div>

        {{-- Footer --}}
        <div class="px-8 md:px-10 py-5 text-center"
             style="border-top:1px solid rgba(30,42,66,.7)">
            <p class="text-sm" style="color:#6b7280">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}"
                   style="color:#818cf8;font-weight:600;text-decoration:none"
                   onmouseover="this.style.color='#a5b4fc'"
                   onmouseout="this.style.color='#818cf8'">
                    Iniciar sesión →
                </a>
            </p>
        </div>
    </div>

    {{-- Feature pills --}}
    <div class="flex flex-wrap justify-center gap-2 mt-6 fu d5">
        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:50px;background:rgba(12,18,32,.8);border:1px solid rgba(30,42,66,.8);font-size:.8rem;color:#6b7280">
            <span style="width:5px;height:5px;border-radius:50%;background:#25d366;flex-shrink:0"></span>Omnicanal WhatsApp
        </span>
        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:50px;background:rgba(12,18,32,.8);border:1px solid rgba(30,42,66,.8);font-size:.8rem;color:#6b7280">
            <span style="width:5px;height:5px;border-radius:50%;background:#6366f1;flex-shrink:0"></span>Facturación Automática
        </span>
        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:50px;background:rgba(12,18,32,.8);border:1px solid rgba(30,42,66,.8);font-size:.8rem;color:#6b7280">
            <span style="width:5px;height:5px;border-radius:50%;background:#10b981;flex-shrink:0"></span>CRM Multiempresa
        </span>
    </div>

</div>

<script>
function checkStrength(val) {
    const bar = document.getElementById('strengthBar');
    const txt = document.getElementById('strengthTxt');
    if (!val) { bar.style.width='0%'; txt.textContent=''; return; }
    let score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        {w:'20%', c:'#ef4444', t:'Muy débil'},
        {w:'40%', c:'#f97316', t:'Débil'},
        {w:'60%', c:'#eab308', t:'Regular'},
        {w:'80%', c:'#84cc16', t:'Fuerte'},
        {w:'100%',c:'#22c55e', t:'Muy fuerte'},
    ];
    const l = levels[Math.min(score-1, 4)] || levels[0];
    bar.style.width = l.w; bar.style.background = l.c;
    txt.textContent = l.t; txt.style.color = l.c;
    checkMatch();
}
function checkMatch() {
    const pw = document.getElementById('pw').value;
    const pwc = document.getElementById('pwc').value;
    const txt = document.getElementById('matchTxt');
    if (!pwc) { txt.textContent=''; return; }
    if (pw === pwc) {
        txt.textContent = '✓ Las contraseñas coinciden';
        txt.style.color = '#22c55e';
    } else {
        txt.textContent = '✗ Las contraseñas no coinciden';
        txt.style.color = '#ef4444';
    }
}
</script>
</body>
</html>
