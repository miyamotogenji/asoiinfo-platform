<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ── Reset ── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'Sora',system-ui,sans-serif;background:#07061a;color:#e2e8f0;overflow:hidden}

/* ══════════════════════════════════════════
   BACKGROUND LAYERS
══════════════════════════════════════════ */

/* Layer 1 — deep-space base */
.bg-space{
  position:fixed;inset:0;z-index:0;
  background:radial-gradient(ellipse 140% 80% at 50% -8%, #160d38 0%, #07061a 55%);
}

/* Layer 2 — left aurora column (purple/violet) */
.aurora-l{
  position:fixed;z-index:1;
  left:-4%;top:-12%;width:38%;height:100%;
  background:
    radial-gradient(ellipse 70% 85% at 28% 28%, rgba(130,40,240,.72) 0%, rgba(90,20,190,.28) 52%, transparent 74%),
    radial-gradient(ellipse 40% 60% at 14% 55%, rgba(168,40,220,.38) 0%, transparent 65%);
  filter:blur(52px);
  animation:auroraL 15s ease-in-out infinite alternate;
}
@keyframes auroraL{
  0%  {transform:translateX(-18px) skewY(-1deg);opacity:.78}
  50% {transform:translateX(14px)  skewY(.5deg); opacity:1}
  100%{transform:translateX(-8px)  skewY(-1.2deg);opacity:.85}
}

/* Layer 3 — right aurora column (teal/cyan) */
.aurora-r{
  position:fixed;z-index:1;
  right:-6%;top:-8%;width:34%;height:88%;
  background:
    radial-gradient(ellipse 70% 80% at 72% 22%, rgba(0,220,210,.45) 0%, rgba(0,170,190,.18) 52%, transparent 74%),
    radial-gradient(ellipse 35% 52% at 88% 60%, rgba(0,180,200,.28) 0%, transparent 62%);
  filter:blur(56px);
  animation:auroraR 18s ease-in-out infinite alternate;
}
@keyframes auroraR{
  0%  {transform:translateX(20px)  skewY(.8deg);opacity:.82}
  50% {transform:translateX(-16px) skewY(-.4deg);opacity:.65}
  100%{transform:translateX(10px)  skewY(1.1deg);opacity:.92}
}

/* Layer 4 — ambient center glow */
.aurora-c{
  position:fixed;z-index:1;
  left:18%;top:18%;width:64%;height:64%;
  background:radial-gradient(ellipse 65% 55% at 50% 42%, rgba(60,30,150,.14) 0%, transparent 65%);
  filter:blur(90px);
}

/* Layer 5 — star field */
.stars{
  position:fixed;inset:0;z-index:2;pointer-events:none;
  background-image:
    radial-gradient(1.6px 1.6px at 11% 8%,  rgba(255,255,255,.95) 0%,transparent 100%),
    radial-gradient(1px   1px   at 79% 14%,  rgba(255,255,255,.7)  0%,transparent 100%),
    radial-gradient(1.6px 1.6px at 36% 5%,   rgba(255,255,255,.85) 0%,transparent 100%),
    radial-gradient(1px   1px   at 93% 29%,  rgba(255,255,255,.5)  0%,transparent 100%),
    radial-gradient(1px   1px   at 5%  43%,  rgba(255,255,255,.6)  0%,transparent 100%),
    radial-gradient(1.4px 1.4px at 63% 4%,   rgba(255,255,255,.65) 0%,transparent 100%),
    radial-gradient(1px   1px   at 98% 53%,  rgba(255,255,255,.45) 0%,transparent 100%),
    radial-gradient(2px   2px   at 53% 17%,  rgba(190,130,255,.95) 0%,transparent 100%),
    radial-gradient(2px   2px   at 84% 57%,  rgba(100,130,255,.95) 0%,transparent 100%),
    radial-gradient(1.8px 1.8px at 19% 27%,  rgba(0,220,200,.85)   0%,transparent 100%),
    radial-gradient(1px   1px   at 45% 11%,  rgba(255,255,255,.5)  0%,transparent 100%),
    radial-gradient(1px   1px   at 29% 46%,  rgba(255,255,255,.35) 0%,transparent 100%),
    radial-gradient(1.4px 1.4px at 71% 21%,  rgba(255,255,255,.65) 0%,transparent 100%),
    radial-gradient(1px   1px   at 89% 39%,  rgba(210,160,255,.75) 0%,transparent 100%),
    radial-gradient(1px   1px   at 57% 33%,  rgba(255,255,255,.4)  0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 7%  72%,  rgba(255,255,255,.3)  0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 48% 62%,  rgba(255,255,255,.25) 0%,transparent 100%);
  animation:twinkle 9s ease-in-out infinite alternate;
}
@keyframes twinkle{0%,100%{opacity:1}48%{opacity:.42}}

/* Layer 6 — perspective grid floor */
.grid-floor{
  position:fixed;bottom:0;left:-10%;right:-10%;height:50%;z-index:2;
  background-image:
    linear-gradient(rgba(120,60,255,.22) 1px,transparent 1px),
    linear-gradient(90deg,rgba(120,60,255,.22) 1px,transparent 1px);
  background-size:52px 52px;
  transform:perspective(380px) rotateX(72deg);
  transform-origin:bottom center;
  mask-image:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 68%);
  -webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 68%);
}

/* Layer 7 — top accent line */
.accent-line{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:50;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 22%,#a855f7 50%,#06b6d4 80%,transparent 100%);
  box-shadow:0 0 24px rgba(124,58,237,.85),0 0 52px rgba(168,85,247,.45);
}

/* ══════════════════════════════════════════
   PAGE LAYOUT
══════════════════════════════════════════ */
.page{
  position:relative;z-index:10;
  min-height:100vh;display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  padding:28px 16px;
  gap:0;
}

/* ══════════════════════════════════════════
   LOGO PILL (top badge)
══════════════════════════════════════════ */
.logo-pill{
  display:inline-flex;align-items:center;gap:13px;
  padding:9px 26px 9px 12px;
  border-radius:50px;
  background:rgba(6,4,22,.85);
  border:1.5px solid rgba(140,80,255,.65);
  box-shadow:
    0 0 18px rgba(140,80,255,.55),
    0 0 60px rgba(140,80,255,.22),
    inset 0 1px 0 rgba(255,255,255,.07);
  margin-bottom:26px;
  animation:fadeUp .55s ease both;
  backdrop-filter:blur(22px);
  -webkit-backdrop-filter:blur(22px);
}
.logo-pill img{
  height:32px;width:auto;
  mix-blend-mode:screen;
  filter:drop-shadow(0 0 10px rgba(150,80,255,.9));
}
.logo-pill-name{
  font-size:1.2rem;font-weight:800;color:#fff;
  letter-spacing:.08em;
  text-shadow:0 0 18px rgba(168,85,247,.55);
}

/* ══════════════════════════════════════════
   CARD
══════════════════════════════════════════ */
.card{
  width:100%;max-width:446px;
  background:rgba(6,5,22,.82);
  border:1px solid rgba(70,55,150,.4);
  border-radius:22px;
  backdrop-filter:blur(52px);
  -webkit-backdrop-filter:blur(52px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.04),
    inset 0 1px 0 rgba(255,255,255,.07),
    0 40px 80px rgba(0,0,0,.72),
    0 0 70px rgba(70,50,200,.09);
  animation:fadeUp .6s .1s ease both;
  overflow:hidden;
}
.card-body{padding:32px 36px 24px}
.card-foot{
  padding:16px 36px 20px;
  border-top:1px solid rgba(70,55,150,.22);
  text-align:center;
}

/* App icon */
.app-icon{
  width:56px;height:56px;border-radius:16px;
  background:linear-gradient(145deg,#4e8ef7 0%,#5b5bd6 48%,#7c3aed 100%);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 16px;
  box-shadow:0 8px 28px rgba(99,102,241,.55),inset 0 2px 0 rgba(255,255,255,.18);
}
.app-icon svg{width:28px;height:28px;color:#fff}

.card-title{
  font-size:1.7rem;font-weight:800;color:#f8fafc;
  letter-spacing:-.042em;text-align:center;line-height:1.15;
}
.card-sub{
  font-size:.875rem;color:#374151;margin-top:7px;
  text-align:center;line-height:1.55;
}

/* Alerts */
.alert{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;border-radius:12px;margin-top:16px;font-size:.88rem;line-height:1.45}
.alert svg{width:18px;height:18px;flex-shrink:0;margin-top:1px}
.alert-err{background:rgba(127,29,29,.2);border:1px solid rgba(239,68,68,.28);color:#fca5a5}
.alert-ok {background:rgba(6,78,59,.2); border:1px solid rgba(16,185,129,.28);color:#6ee7b7}

/* Input group */
.field{margin-top:18px;position:relative}
.field-icon{
  position:absolute;left:15px;top:50%;transform:translateY(-50%);
  width:18px;height:18px;color:#2a3048;pointer-events:none;
  flex-shrink:0;
}
.inp{
  width:100%;
  background:rgba(2,2,12,.92);
  border:1.5px solid rgba(35,30,80,.95);
  border-radius:13px;
  padding:14px 16px 14px 46px;
  font-size:.975rem;color:#d1d5db;
  font-family:'Sora',system-ui,sans-serif;
  outline:none;transition:all .22s;
}
.inp::placeholder{color:#1a2030}
.inp:focus{
  border-color:rgba(99,102,241,.58);
  background:rgba(2,2,14,1);
  box-shadow:0 0 0 3px rgba(99,102,241,.11);
}
/* Eye toggle */
.eye-btn{
  position:absolute;right:14px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:20px;height:20px;color:#2a3048;transition:color .15s;
  display:flex;align-items:center;justify-content:center;
}
.eye-btn:hover{color:#6366f1}
.eye-btn svg{width:18px;height:18px}

/* Checkbox row */
.check-row{
  display:flex;align-items:center;justify-content:space-between;
  margin-top:16px;
}
.check-label{
  display:flex;align-items:center;gap:8px;
  font-size:.845rem;color:#2d3748;cursor:pointer;user-select:none;
}
.check-label input{
  width:15px;height:15px;cursor:pointer;
  accent-color:#6366f1;border-radius:4px;
}
.forgot-link{
  font-size:.83rem;color:#2d3748;text-decoration:none;
  font-weight:500;transition:color .15s;
}
.forgot-link:hover{color:#818cf8}

/* Submit button */
.btn-submit{
  width:100%;margin-top:20px;
  padding:15.5px 24px;border-radius:13px;
  background:linear-gradient(95deg,#3d82f6 0%,#5b5bd6 46%,#6366f1 100%);
  border:none;cursor:pointer;
  font-family:'Sora',system-ui,sans-serif;
  font-size:1.04rem;font-weight:700;color:#fff;
  letter-spacing:.015em;
  box-shadow:0 6px 30px rgba(99,102,241,.55),inset 0 1px 0 rgba(255,255,255,.14);
  transition:all .22s;position:relative;overflow:hidden;
}
.btn-submit::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(95deg,transparent 0%,rgba(255,255,255,.09) 50%,transparent 100%);
  transform:translateX(-100%);transition:transform .55s;
}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 14px 44px rgba(99,102,241,.72)}
.btn-submit:hover::after{transform:translateX(100%)}
.btn-submit:active{transform:translateY(0)}

/* Footer link */
.f-txt{font-size:.875rem;color:#2d3748}
.f-link{color:#818cf8;font-weight:600;text-decoration:none;transition:color .15s}
.f-link:hover{color:#c4b5fd}

/* ══════════════════════════════════════════
   FEATURE PILLS
══════════════════════════════════════════ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:11px;
  margin-top:22px;
  animation:fadeUp .65s .3s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:9px;
  padding:9px 20px;border-radius:50px;
  background:rgba(6,5,22,.88);
  border:1.5px solid rgba(38,32,82,.92);
  backdrop-filter:blur(18px);
  font-size:.82rem;font-weight:600;color:#4b5563;
  transition:all .22s;cursor:default;
  position:relative;
}
.pill:hover{border-color:rgba(99,102,241,.38);color:#94a3b8;transform:translateY(-2px)}
/* Green live-dot indicator */
.pill::after{
  content:'';
  position:absolute;top:-4px;right:-4px;
  width:9px;height:9px;border-radius:50%;
  background:#22c55e;
  box-shadow:0 0 8px rgba(34,197,94,.9),0 0 16px rgba(34,197,94,.4);
  border:2px solid rgba(6,5,22,.95);
}
.pill-icon{
  width:28px;height:28px;border-radius:9px;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}

/* ══════════════════════════════════════════
   COPYRIGHT
══════════════════════════════════════════ */
.copyright{
  margin-top:18px;text-align:center;
  animation:fadeUp .65s .42s ease both;
}
.copyright p{font-size:.73rem;color:#141c2e;display:flex;align-items:center;justify-content:center;gap:5px}

/* Keyframe */
@keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<!-- Background layers -->
<div class="bg-space"></div>
<div class="aurora-l"></div>
<div class="aurora-r"></div>
<div class="aurora-c"></div>
<div class="stars"></div>
<div class="grid-floor"></div>
<div class="accent-line"></div>

<div class="page">

    <!-- ── Logo pill ── -->
    <div class="logo-pill">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO">
        <span class="logo-pill-name">ASOIINFO</span>
    </div>

    <!-- ── Login card ── -->
    <div class="card">
        <div class="card-body">

            <!-- App icon (A) -->
            <div class="app-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>

            <h1 class="card-title">Iniciar sesión</h1>
            <p class="card-sub">Accede a tu cuenta para continuar<br>gestionando tu empresa.</p>

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

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input class="inp" type="email" name="email"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="email"
                           placeholder="Correo electrónico">
                </div>

                <!-- Password -->
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input class="inp" type="password" id="password" name="password"
                           required autocomplete="current-password"
                           placeholder="Contraseña"
                           style="padding-right:46px">
                    <button type="button" class="eye-btn" onclick="togglePwd()">
                        <svg id="eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                <!-- Remember / Forgot -->
                <div class="check-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-submit">Ingresar al sistema →</button>
            </form>
        </div>

        <div class="card-foot">
            <p class="f-txt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="f-link">Crear cuenta →</a></p>
        </div>
    </div>

    <!-- ── Feature pills ── -->
    <div class="pills">
        <!-- WhatsApp -->
        <span class="pill">
            <span class="pill-icon" style="background:rgba(37,211,102,.12)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="#25d366">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </span>
            WhatsApp
        </span>
        <!-- Facturación -->
        <span class="pill">
            <span class="pill-icon" style="background:rgba(99,102,241,.14)">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#818cf8" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </span>
            Facturación
        </span>
        <!-- Reportes -->
        <span class="pill">
            <span class="pill-icon" style="background:rgba(16,185,129,.12)">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#34d399" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </span>
            Reportes
        </span>
        <!-- CRM -->
        <span class="pill">
            <span class="pill-icon" style="background:rgba(168,85,247,.13)">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#d8b4fe" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            CRM
        </span>
    </div>

    <!-- ── Copyright ── -->
    <div class="copyright">
        <p>
            © {{ date('Y') }} ASOIINFO. Todos los derechos reservados.
            <span style="margin-left:6px;display:inline-flex;align-items:center;gap:4px">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="#141c2e" stroke-width="2" style="flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Seguridad y confianza
            </span>
        </p>
    </div>

</div>

<script>
function togglePwd(){
    var f=document.getElementById('password');
    var i=document.getElementById('eye-icon');
    if(f.type==='password'){
        f.type='text';
        i.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        f.type='password';
        i.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
</body>
</html>
