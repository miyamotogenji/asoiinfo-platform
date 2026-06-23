<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — ASOIINFO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200;300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0 }
        html, body { height: 100%; font-family: 'Sora', system-ui, sans-serif; background: #020509; color: #e2e8f0; overflow-x: hidden }

        /* ════════════════════════════════════════
           CINEMATIC BACKGROUND — 9 LAYERS
        ════════════════════════════════════════ */

        .bg-cosmos {
            position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse 180% 90% at 50% -5%, #0d0a2e 0%, #020509 62%);
        }
        .aurora-mesh {
            position: fixed; inset: 0; z-index: 1;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(99,102,241,.35) 0%, transparent 58%),
                radial-gradient(ellipse 70% 55% at 90% 78%, rgba(124,58,237,.30) 0%, transparent 58%),
                radial-gradient(ellipse 55% 45% at 82% 10%, rgba(20,184,166,.18) 0%, transparent 52%),
                radial-gradient(ellipse 55% 48% at 18% 88%, rgba(168,85,247,.22) 0%, transparent 55%),
                radial-gradient(ellipse 38% 32% at 52% 46%, rgba(59,130,246,.10) 0%, transparent 50%);
            animation: auroraPulse 11s ease-in-out infinite alternate;
        }
        @keyframes auroraPulse {
            0%   { opacity:.78; transform:scale(1)    rotate(0deg)   }
            33%  { opacity:1;   transform:scale(1.04) rotate(.4deg)  }
            66%  { opacity:.83; transform:scale(.97)  rotate(-.3deg) }
            100% { opacity:1;   transform:scale(1.03) rotate(.2deg)  }
        }
        .conic-light {
            position: fixed; inset: 0; z-index: 2; pointer-events: none;
            background: conic-gradient(from 0deg at 25% 35%,
                transparent 0deg, rgba(99,102,241,.08) 25deg,
                rgba(168,85,247,.05) 50deg, transparent 78deg);
            animation: conicSpin 24s linear infinite;
        }
        @keyframes conicSpin { to { transform: rotate(360deg) scale(1.55) } }

        .grid-floor {
            position: fixed; bottom: 0; left: 0; right: 0; height: 58%; z-index: 1;
            background-image:
                linear-gradient(rgba(99,102,241,.10) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.10) 1px, transparent 1px);
            background-size: 54px 54px;
            transform: perspective(520px) rotateX(64deg);
            transform-origin: bottom center;
            mask-image: linear-gradient(to top, rgba(0,0,0,.55) 0%, transparent 72%);
            -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,.55) 0%, transparent 72%);
        }
        .starfield {
            position: fixed; inset: 0; z-index: 1; pointer-events: none;
            background-image:
                radial-gradient(1.5px 1.5px at 8%  7%,  rgba(255,255,255,.9)  0%,transparent 100%),
                radial-gradient(1px   1px   at 73% 12%, rgba(255,255,255,.65) 0%,transparent 100%),
                radial-gradient(1.5px 1.5px at 40% 5%,  rgba(255,255,255,.8)  0%,transparent 100%),
                radial-gradient(1px   1px   at 91% 26%, rgba(255,255,255,.5)  0%,transparent 100%),
                radial-gradient(1px   1px   at 4%  40%, rgba(255,255,255,.6)  0%,transparent 100%),
                radial-gradient(1.5px 1.5px at 60% 3%,  rgba(255,255,255,.55) 0%,transparent 100%),
                radial-gradient(1px   1px   at 97% 50%, rgba(255,255,255,.4)  0%,transparent 100%),
                radial-gradient(1px   1px   at 25% 65%, rgba(255,255,255,.45) 0%,transparent 100%),
                radial-gradient(2px   2px   at 50% 17%, rgba(168,85,247,1)    0%,transparent 100%),
                radial-gradient(2px   2px   at 81% 55%, rgba(99,102,241,1)    0%,transparent 100%),
                radial-gradient(2px   2px   at 14% 24%, rgba(20,184,166,.85)  0%,transparent 100%),
                radial-gradient(1px   1px   at 67% 75%, rgba(255,255,255,.3)  0%,transparent 100%);
            animation: twinkle 8s ease-in-out infinite alternate;
        }
        @keyframes twinkle { 0%,100%{opacity:1} 50%{opacity:.45} }

        .orb { position:fixed; border-radius:50%; filter:blur(115px); pointer-events:none; animation:orbDrift ease-in-out infinite alternate }
        .orb-1 { width:700px; height:700px; top:-240px; left:-180px;    background:rgba(99,102,241,.18); animation-duration:16s }
        .orb-2 { width:560px; height:560px; bottom:-170px; right:-150px; background:rgba(124,58,237,.16); animation-duration:20s }
        .orb-3 { width:340px; height:340px; top:32%; right:3%;           background:rgba(20,184,166,.11); animation-duration:25s }
        .orb-4 { width:240px; height:240px; top:5%;  left:52%;            background:rgba(168,85,247,.14); animation-duration:12s }
        @keyframes orbDrift { from{transform:translate(0,0) scale(1)} to{transform:translate(35px,28px) scale(1.08)} }

        .noise {
            position:fixed;inset:0;z-index:3;pointer-events:none;opacity:.03;
            background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size:180px 180px;
        }
        .accent-line {
            position:fixed;top:0;left:0;right:0;height:1.5px;z-index:50;
            background:linear-gradient(90deg,transparent 0%,#6366f1 18%,#a855f7 50%,#14b8a6 82%,transparent 100%);
            box-shadow:0 0 28px rgba(99,102,241,.75),0 0 56px rgba(168,85,247,.4);
        }

        /* ════════════════════════════════════════
           CONTENT
        ════════════════════════════════════════ */
        .page {
            position:relative; z-index:10;
            min-height:100vh; display:flex; flex-direction:column;
            align-items:center; justify-content:center; padding:40px 16px;
        }

        /* Logo */
        .logo-wrap { text-align:center; margin-bottom:30px; animation:fadeUp .7s ease both }
        .logo-wrap img {
            height:136px; width:auto; display:block; margin:0 auto;
            mix-blend-mode:screen;
            filter:
                drop-shadow(0 0 44px rgba(99,102,241,1))
                drop-shadow(0 0 18px rgba(168,85,247,.85))
                drop-shadow(0 0 90px rgba(99,102,241,.38));
            transition:filter .3s;
        }
        .logo-wrap img:hover {
            filter:
                drop-shadow(0 0 56px rgba(99,102,241,1))
                drop-shadow(0 0 24px rgba(168,85,247,1))
                drop-shadow(0 0 120px rgba(99,102,241,.55));
        }
        .logo-sub {
            margin-top:12px; font-size:.7rem; font-weight:500;
            letter-spacing:.22em; text-transform:uppercase; color:#2d3748;
        }

        /* Card */
        .card {
            width:100%; max-width:456px;
            background:rgba(5,9,20,.74);
            border:1px solid rgba(99,102,241,.22);
            border-radius:28px;
            backdrop-filter:blur(42px); -webkit-backdrop-filter:blur(42px);
            box-shadow:
                0 0 0 1px rgba(255,255,255,.04) inset,
                0 1px 0  rgba(255,255,255,.08) inset,
                0 42px 88px rgba(0,0,0,.72),
                0 0 64px rgba(99,102,241,.07);
            animation:fadeUp .7s .1s ease both; overflow:hidden;
        }
        .card-body { padding:38px 42px 28px }
        .card-foot { padding:18px 42px 22px; border-top:1px solid rgba(99,102,241,.1); text-align:center }

        /* Card icon */
        .c-icon {
            width:46px; height:46px; border-radius:16px;
            display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,#6366f1,#7c3aed);
            box-shadow:0 6px 26px rgba(99,102,241,.48); margin-bottom:18px;
        }
        .c-icon svg { width:22px; height:22px; color:#fff }
        .c-title { font-size:1.6rem; font-weight:700; color:#f1f5f9; letter-spacing:-.04em; line-height:1.2 }
        .c-sub   { font-size:.9rem; color:#64748b; margin-top:5px }

        /* Fields */
        .field { margin-bottom:20px }
        .lbl { display:block; font-size:.75rem; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.1em; margin-bottom:9px }
        .inp {
            width:100%; background:rgba(2,4,14,.92);
            border:1.5px solid rgba(30,42,66,.9);
            border-radius:14px; padding:15px 19px;
            font-size:1rem; color:#e2e8f0;
            font-family:'Sora',system-ui,sans-serif; outline:none; transition:all .2s;
        }
        .inp:focus {
            border-color:#6366f1; background:rgba(2,4,14,1);
            box-shadow:0 0 0 4px rgba(99,102,241,.13),0 0 22px rgba(99,102,241,.1);
        }
        .inp::placeholder { color:#1a2535 }

        /* Alerts */
        .alert { display:flex; align-items:flex-start; gap:10px; padding:14px 16px; border-radius:14px; margin:18px 0; font-size:.9rem; line-height:1.45 }
        .alert-err { background:rgba(127,29,29,.22); border:1px solid rgba(239,68,68,.3); color:#fca5a5 }
        .alert-ok  { background:rgba(6,78,59,.22);   border:1px solid rgba(16,185,129,.3); color:#6ee7b7 }
        .alert svg { width:18px; height:18px; flex-shrink:0; margin-top:1px }

        /* Button */
        .btn-primary {
            width:100%; padding:16px 24px; border-radius:14px;
            font-size:1.04rem; font-weight:700; color:#fff; border:none; cursor:pointer;
            font-family:'Sora',system-ui,sans-serif; letter-spacing:.02em;
            background:linear-gradient(135deg,#6366f1 0%,#4f46e5 44%,#7c3aed 100%);
            box-shadow:0 6px 32px rgba(99,102,241,.52),0 1px 0 rgba(255,255,255,.15) inset;
            transition:all .22s; margin-top:6px; position:relative; overflow:hidden;
        }
        .btn-primary::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.1),transparent); opacity:0; transition:opacity .2s }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 14px 44px rgba(99,102,241,.68) }
        .btn-primary:hover::after { opacity:1 }
        .btn-primary:active { transform:translateY(0) }

        /* Footer link */
        .f-txt  { font-size:.9rem; color:#475569 }
        .f-link { color:#818cf8; font-weight:600; text-decoration:none; transition:color .15s }
        .f-link:hover { color:#c4b5fd }

        /* Pills */
        .pills { display:flex; flex-wrap:wrap; justify-content:center; gap:8px; margin-top:24px; animation:fadeUp .7s .36s ease both }
        .pill {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 16px; border-radius:50px;
            background:rgba(5,9,20,.85); border:1px solid rgba(30,42,66,.88);
            font-size:.78rem; font-weight:500; color:#475569;
            backdrop-filter:blur(12px); transition:all .2s;
        }
        .pill:hover { border-color:rgba(99,102,241,.38); color:#94a3b8; transform:translateY(-1px) }
        .pill-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0 }

        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .fu1 { animation:fadeUp .6s .18s ease both }
        .fu2 { animation:fadeUp .6s .26s ease both }
        .fu3 { animation:fadeUp .6s .34s ease both }
    </style>
</head>
<body>

<div class="bg-cosmos"></div>
<div class="aurora-mesh"></div>
<div class="conic-light"></div>
<div class="grid-floor"></div>
<div class="starfield"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>
<div class="orb orb-4"></div>
<div class="noise"></div>
<div class="accent-line"></div>

<div class="page">

    <div class="logo-wrap">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO">
        <p class="logo-sub">Sistema Multiempresa &nbsp;·&nbsp; CRM &nbsp;·&nbsp; Facturación &nbsp;·&nbsp; WhatsApp</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="c-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="c-title">Iniciar sesión</h1>
            <p class="c-sub">Ingresa tus credenciales para continuar</p>

            @if($errors->any())
            <div class="alert alert-err">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $errors->first() }}
            </div>
            @endif
            @if(session('status'))
            <div class="alert alert-ok">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" style="margin-top:26px">
                @csrf
                <div class="field fu1">
                    <label class="lbl">Correo electrónico</label>
                    <input class="inp" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email" placeholder="usuario@empresa.com">
                </div>
                <div class="field fu2">
                    <label class="lbl">Contraseña</label>
                    <input class="inp" type="password" name="password"
                           required autocomplete="current-password" placeholder="••••••••••">
                </div>
                <div class="fu3">
                    <button type="submit" class="btn-primary">Ingresar al sistema &nbsp;→</button>
                </div>
            </form>
        </div>
        <div class="card-foot">
            <p class="f-txt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="f-link">Crear cuenta →</a></p>
        </div>
    </div>

    <div class="pills">
        <span class="pill"><span class="pill-dot" style="background:#25d366"></span>Omnicanal WhatsApp</span>
        <span class="pill"><span class="pill-dot" style="background:#6366f1"></span>Facturación Automática</span>
        <span class="pill"><span class="pill-dot" style="background:#f59e0b"></span>Reportes en Tiempo Real</span>
        <span class="pill"><span class="pill-dot" style="background:#10b981"></span>CRM Multiempresa</span>
    </div>

    <div style="text-align:center;margin-top:14px;animation:fadeUp .7s .46s ease both">
        <p style="font-size:.72rem;color:#1e293b;margin-bottom:3px">
            <span style="color:#334155;font-weight:600">Admin:</span>
            <span style="color:#374151"> admin@asoiinfo.com &nbsp;/&nbsp; Admin2026!</span>
        </p>
        <p style="font-size:.72rem;color:#1e293b">
            <span style="color:#334155;font-weight:600">Asesor:</span>
            <span style="color:#374151"> asesor@asoiinfo.com &nbsp;/&nbsp; Agent2026!</span>
        </p>
    </div>
</div>
</body>
</html>
