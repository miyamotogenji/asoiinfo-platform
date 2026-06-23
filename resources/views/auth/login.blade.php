<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — ASOIINFO Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family:'Plus Jakarta Sans',system-ui,sans-serif; box-sizing:border-box }

        body {
            min-height:100vh;
            background:#05090f;
            overflow:hidden;
        }

        /* Animated star background */
        .stars {
            position:fixed; inset:0; z-index:0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(99,102,241,.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(139,92,246,.06) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(16,185,129,.05) 0%, transparent 40%);
        }

        /* Grid lines */
        .grid-bg {
            position:fixed; inset:0; z-index:0;
            background-image:
                linear-gradient(rgba(99,102,241,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.04) 1px, transparent 1px);
            background-size:60px 60px;
        }

        /* Glow orbs */
        .orb {
            position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none;
        }
        .orb-1 { width:500px; height:500px; top:-150px; left:-100px; background:rgba(99,102,241,.12); z-index:0 }
        .orb-2 { width:400px; height:400px; bottom:-100px; right:-80px; background:rgba(139,92,246,.10); z-index:0 }
        .orb-3 { width:300px; height:300px; top:40%; left:50%; transform:translate(-50%,-50%); background:rgba(16,185,129,.06); z-index:0 }

        .form-wrap { position:relative; z-index:10 }

        /* Card glass */
        .login-card {
            background:rgba(10,16,28,.75);
            border:1px solid rgba(99,102,241,.2);
            border-radius:20px;
            backdrop-filter:blur(28px);
            -webkit-backdrop-filter:blur(28px);
            box-shadow:
                0 30px 60px rgba(0,0,0,.6),
                0 0 0 1px rgba(255,255,255,.04) inset,
                0 1px 0 rgba(255,255,255,.08) inset;
        }

        /* Inputs */
        .inp {
            width:100%;
            background:rgba(6,11,20,.8);
            border:1.5px solid rgba(45,58,90,.8);
            border-radius:12px;
            padding:14px 18px;
            font-size:1rem;
            color:#e5e7eb;
            outline:none;
            transition:all .2s;
            font-family:inherit;
        }
        .inp:focus {
            border-color:#6366f1;
            background:rgba(6,11,20,.95);
            box-shadow:0 0 0 4px rgba(99,102,241,.12), 0 0 20px rgba(99,102,241,.1);
        }
        .inp::placeholder { color:#374151 }

        /* Submit button */
        .btn-login {
            width:100%;
            padding:15px 24px;
            border-radius:12px;
            font-size:1rem;
            font-weight:700;
            color:#fff;
            border:none;
            cursor:pointer;
            background:linear-gradient(135deg,#6366f1 0%,#4f46e5 50%,#7c3aed 100%);
            box-shadow:0 6px 24px rgba(99,102,241,.45), 0 1px 0 rgba(255,255,255,.15) inset;
            transition:all .2s;
            letter-spacing:.01em;
        }
        .btn-login:hover {
            transform:translateY(-1px);
            box-shadow:0 10px 32px rgba(99,102,241,.6), 0 1px 0 rgba(255,255,255,.2) inset;
        }
        .btn-login:active { transform:translateY(0) }

        /* Feature pill */
        .feature-pill {
            display:inline-flex; align-items:center; gap:8px;
            padding:9px 16px; border-radius:50px;
            background:rgba(15,22,35,.8);
            border:1px solid rgba(45,58,90,.7);
            backdrop-filter:blur(12px);
            font-size:.82rem; font-weight:500; color:#9ca3af;
            transition:all .2s;
        }
        .feature-pill:hover { border-color:rgba(99,102,241,.5); color:#c7d2fe }
        .feature-pill .dot { width:6px; height:6px; border-radius:50%; flex-shrink:0 }

        /* Label */
        .inp-label { display:block; font-size:.9rem; font-weight:600; color:#9ca3af; margin-bottom:8px }

        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation:fadeUp .5s ease forwards }
        .delay-1 { animation-delay:.1s; opacity:0 }
        .delay-2 { animation-delay:.2s; opacity:0 }
        .delay-3 { animation-delay:.3s; opacity:0 }
        .delay-4 { animation-delay:.4s; opacity:0 }
    </style>
</head>
<body>

<div class="stars"></div>
<div class="grid-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="form-wrap min-h-screen flex flex-col items-center justify-center px-4 py-10">

    {{-- Logo --}}
    <div class="text-center mb-8 fade-up">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO"
             style="height:90px;width:auto;object-fit:contain;margin:0 auto;filter:drop-shadow(0 0 28px rgba(99,102,241,.7)) drop-shadow(0 0 8px rgba(139,92,246,.4))">
        <p class="mt-3 text-sm font-medium tracking-wide" style="color:#6b7280;letter-spacing:.06em">
            SISTEMA MULTIEMPRESA &nbsp;·&nbsp; CRM &nbsp;·&nbsp; FACTURACIÓN &nbsp;·&nbsp; WHATSAPP
        </p>
    </div>

    {{-- Card --}}
    <div class="login-card w-full fade-up delay-1" style="max-width:440px">
        <div class="p-8 md:p-10">

            <div class="mb-7">
                <h1 class="text-2xl font-bold text-white tracking-tight">Iniciar sesión</h1>
                <p class="text-sm mt-1" style="color:#6b7280">Ingresa tus credenciales para continuar</p>
            </div>

            @if($errors->any())
            <div class="flex items-start gap-3 rounded-xl p-4 mb-6 text-sm"
                 style="background:rgba(127,29,29,.25);border:1px solid rgba(220,38,38,.4);color:#fca5a5">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('status'))
            <div class="rounded-xl p-4 mb-6 text-sm"
                 style="background:rgba(6,78,59,.25);border:1px solid rgba(16,185,129,.4);color:#6ee7b7">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div class="fade-up delay-2">
                    <label class="inp-label">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email"
                           placeholder="usuario@empresa.com" class="inp">
                </div>

                <div class="fade-up delay-3">
                    <div class="flex items-center justify-between mb-2">
                        <label class="inp-label" style="margin-bottom:0">Contraseña</label>
                    </div>
                    <input type="password" name="password" required
                           autocomplete="current-password"
                           placeholder="••••••••••" class="inp">
                </div>

                <div class="fade-up delay-4 pt-1">
                    <button type="submit" class="btn-login">
                        Ingresar al sistema &nbsp;→
                    </button>
                </div>
            </form>

        </div>

        {{-- Bottom divider with hint --}}
        <div class="px-8 md:px-10 pb-7 pt-1 text-center" style="border-top:1px solid rgba(30,42,66,.6);margin-top:4px;padding-top:20px">
            <p class="text-xs" style="color:#374151">
                ¿Problemas para ingresar? Contacte al administrador del sistema.
            </p>
        </div>
    </div>

    {{-- Feature pills --}}
    <div class="flex flex-wrap justify-center gap-3 mt-7 fade-up delay-4">
        <span class="feature-pill">
            <span class="dot" style="background:#25d366"></span>
            Omnicanal WhatsApp
        </span>
        <span class="feature-pill">
            <span class="dot" style="background:#6366f1"></span>
            Facturación automática
        </span>
        <span class="feature-pill">
            <span class="dot" style="background:#f59e0b"></span>
            Reportes en tiempo real
        </span>
        <span class="feature-pill">
            <span class="dot" style="background:#10b981"></span>
            CRM Multiempresa
        </span>
    </div>

    {{-- Demo credentials --}}
    <div class="mt-5 text-center space-y-1 fade-up delay-4">
        <p class="text-xs" style="color:#1f2937">
            <span style="color:#374151;font-weight:600">Admin:</span>
            <span style="color:#4b5563"> admin@asoiinfo.com &nbsp;/&nbsp; Admin2026!</span>
        </p>
        <p class="text-xs" style="color:#1f2937">
            <span style="color:#374151;font-weight:600">Asesor:</span>
            <span style="color:#4b5563"> asesor@asoiinfo.com &nbsp;/&nbsp; Agent2026!</span>
        </p>
    </div>

</div>

</body>
</html>
