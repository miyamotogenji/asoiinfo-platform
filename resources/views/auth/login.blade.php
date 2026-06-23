<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden;font-family:'Plus Jakarta Sans',sans-serif;color:#e2e8f0}

/* ══════════════════════════════════════════
   BACKGROUND SYSTEM
══════════════════════════════════════════ */
body{background:#05030f}

/* Left aurora — deep violet column */
body::before{
  content:'';position:fixed;inset:0;z-index:1;pointer-events:none;
  mix-blend-mode:screen;
  background:
    radial-gradient(ellipse 24% 75% at 12% 13%, rgba(175,42,255,.88) 0%,rgba(135,18,235,.52) 34%,transparent 64%),
    radial-gradient(ellipse 17% 80% at  7% 40%, rgba(152,26,248,.64) 0%,rgba(112,10,208,.30) 54%,transparent 74%),
    radial-gradient(ellipse 13% 44% at  5% 74%, rgba(134,20,240,.46) 0%,transparent 62%),
    radial-gradient(ellipse 32% 58% at 19% 28%, rgba(102,16,198,.24) 0%,transparent 62%);
  filter:blur(20px);
  animation:al 16s ease-in-out infinite alternate;
}
/* Right aurora — cyan column */
body::after{
  content:'';position:fixed;inset:0;z-index:1;pointer-events:none;
  mix-blend-mode:screen;
  background:
    radial-gradient(ellipse 19% 68% at 89% 10%, rgba(0,232,215,.82) 0%,rgba(0,195,198,.46) 36%,transparent 64%),
    radial-gradient(ellipse 14% 74% at 95% 34%, rgba(0,214,204,.58) 0%,rgba(0,170,185,.28) 53%,transparent 72%),
    radial-gradient(ellipse 11% 42% at 97% 67%, rgba(0,200,202,.40) 0%,transparent 60%),
    radial-gradient(ellipse 26% 52% at 82% 20%, rgba(0,162,188,.22) 0%,transparent 60%);
  filter:blur(24px);
  animation:ar 19s ease-in-out infinite alternate;
}
@keyframes al{0%{transform:translate(-14px,-6px);opacity:.80}50%{transform:translate(10px,5px);opacity:1}100%{transform:translate(-7px,-3px);opacity:.86}}
@keyframes ar{0%{transform:translate(16px,5px);opacity:.76}50%{transform:translate(-12px,-4px);opacity:.94}100%{transform:translate(9px,3px);opacity:.70}}

/* Stars */
.stars{
  position:fixed;inset:0;z-index:2;pointer-events:none;
  background-image:
    radial-gradient(1.8px 1.8px at  9%  7%,rgba(255,255,255,.96) 0%,transparent 100%),
    radial-gradient(1.3px 1.3px at 76% 13%,rgba(255,255,255,.72) 0%,transparent 100%),
    radial-gradient(1.8px 1.8px at 34%  5%,rgba(255,255,255,.88) 0%,transparent 100%),
    radial-gradient(1.3px 1.3px at 91% 28%,rgba(255,255,255,.52) 0%,transparent 100%),
    radial-gradient(1.3px 1.3px at  4% 42%,rgba(255,255,255,.62) 0%,transparent 100%),
    radial-gradient(2.4px 2.4px at 51% 17%,rgba(200,138,255,.98) 0%,transparent 100%),
    radial-gradient(2.4px 2.4px at 83% 55%,rgba(118,138,255,.98) 0%,transparent 100%),
    radial-gradient(2.1px 2.1px at 17% 25%,rgba(0,232,212,.92)   0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 43% 11%,rgba(255,255,255,.54) 0%,transparent 100%),
    radial-gradient(1.6px 1.6px at 69% 20%,rgba(255,255,255,.70) 0%,transparent 100%),
    radial-gradient(1.3px 1.3px at 88% 37%,rgba(212,164,255,.80) 0%,transparent 100%),
    radial-gradient(1.5px 1.5px at  6% 70%,rgba(255,255,255,.32) 0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 58% 82%,rgba(255,255,255,.28) 0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 74% 62%,rgba(255,255,255,.34) 0%,transparent 100%),
    radial-gradient(1.2px 1.2px at 22% 68%,rgba(180,120,255,.45) 0%,transparent 100%);
  animation:twinkle 10s ease-in-out infinite alternate;
}
@keyframes twinkle{0%,100%{opacity:1}50%{opacity:.32}}

/* Neon grid floor */
.grid-floor{
  position:fixed;bottom:0;left:-20%;right:-20%;height:50%;z-index:2;pointer-events:none;
  background-image:
    linear-gradient(rgba(148,55,255,.38) 1px,transparent 1px),
    linear-gradient(90deg,rgba(148,55,255,.38) 1px,transparent 1px);
  background-size:50px 50px;
  transform:perspective(310px) rotateX(76deg);
  transform-origin:bottom center;
  filter:drop-shadow(0 0 7px rgba(148,55,255,.72));
  mask-image:linear-gradient(to top,rgba(0,0,0,.82) 0%,rgba(0,0,0,.24) 52%,transparent 78%);
  -webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.82) 0%,rgba(0,0,0,.24) 52%,transparent 78%);
}

/* Top accent line */
.topline{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:100;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 18%,#a855f7 50%,#06b6d4 82%,transparent 100%);
  box-shadow:0 0 24px rgba(124,58,237,.95),0 0 60px rgba(168,85,247,.48);
}

/* ══════════════════════════════════════════
   PAGE
══════════════════════════════════════════ */
.page{
  position:relative;z-index:10;isolation:isolate;
  min-height:100vh;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:24px 16px 28px;
}

/* ══ LOGO BADGE — use the provided image directly ══ */
.logo-wrap{
  margin-bottom:28px;
  animation:up .5s ease both;
}
.logo-wrap img{
  height:64px;width:auto;display:block;
  filter:drop-shadow(0 0 18px rgba(148,80,255,.80)) drop-shadow(0 0 40px rgba(148,80,255,.35));
  transition:filter .3s;
}
.logo-wrap img:hover{
  filter:drop-shadow(0 0 24px rgba(148,80,255,1)) drop-shadow(0 0 55px rgba(148,80,255,.55));
}

/* ══ CARD ══ */
.card{
  width:100%;max-width:448px;
  background:rgba(8,5,24,.84);
  border:1px solid rgba(72,55,150,.40);
  border-radius:24px;
  backdrop-filter:blur(64px);-webkit-backdrop-filter:blur(64px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.045),
    inset 0 1px 0 rgba(255,255,255,.08),
    0 52px 100px rgba(0,0,0,.80),
    0 0 88px rgba(55,34,178,.12);
  overflow:hidden;
  animation:up .55s .08s ease both;
}
.cbody{padding:36px 40px 26px;text-align:center}
.cfoot{padding:15px 40px 20px;border-top:1px solid rgba(68,52,148,.22);text-align:center}

/* "A" icon */
.a-icon{
  width:62px;height:62px;border-radius:18px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(148deg,#4d90f8 0%,#5a5cdb 44%,#7b3aed 100%);
  box-shadow:0 10px 34px rgba(99,102,241,.62),inset 0 2px 0 rgba(255,255,255,.22);
  margin-bottom:18px;
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:1.8rem;font-weight:900;color:#fff;
  text-shadow:0 2px 10px rgba(0,0,0,.35);letter-spacing:-.04em;
}
.ctitle{
  font-size:1.9rem;font-weight:800;color:#f8fafc;
  letter-spacing:-.05em;line-height:1.1;
}
.csub{
  font-size:.9rem;color:#374151;margin-top:9px;line-height:1.65;
  font-weight:400;
}

/* Alerts */
.alert{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;border-radius:14px;margin-top:14px;font-size:.875rem;line-height:1.45;text-align:left}
.alert svg{width:17px;height:17px;flex-shrink:0;margin-top:1px}
.aerr{background:rgba(127,29,29,.18);border:1px solid rgba(239,68,68,.25);color:#fca5a5}
.aok {background:rgba(6,78,59,.18); border:1px solid rgba(16,185,129,.25);color:#6ee7b7}

/* Inputs */
.field{margin-top:16px;position:relative;text-align:left}
.fi{position:absolute;left:16px;top:50%;transform:translateY(-50%);width:17px;height:17px;color:#22263a;pointer-events:none}
.inp{
  width:100%;
  background:rgba(2,1,14,.95);
  border:1.5px solid rgba(30,24,74,.98);
  border-radius:14px;
  padding:15px 16px 15px 47px;
  font-size:1rem;color:#d1d5db;
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:500;
  outline:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
.inp::placeholder{color:#17202e;font-weight:400}
.inp:focus{border-color:rgba(99,102,241,.58);background:rgba(2,1,16,1);box-shadow:0 0 0 4px rgba(99,102,241,.11)}
.eye{
  position:absolute;right:14px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:20px;height:20px;color:#22263a;
  display:flex;align-items:center;justify-content:center;transition:color .18s;
}
.eye:hover{color:#6366f1}
.eye svg{width:18px;height:18px}

/* Remember / Forgot */
.chk-row{display:flex;align-items:center;justify-content:space-between;margin-top:15px;text-align:left}
.chk-lbl{display:flex;align-items:center;gap:8px;font-size:.85rem;color:#252a3e;cursor:pointer;user-select:none;font-weight:500}
.chk-lbl input{width:15px;height:15px;cursor:pointer;accent-color:#6366f1}
.forgot{font-size:.84rem;color:#252a3e;text-decoration:none;font-weight:600;transition:color .18s}
.forgot:hover{color:#818cf8}

/* ══ BIG MODERN BUTTON ══ */
.btn{
  width:100%;margin-top:22px;
  padding:18px 24px;
  border-radius:16px;border:none;cursor:pointer;
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:1.12rem;font-weight:800;color:#fff;letter-spacing:.02em;
  background:linear-gradient(100deg,#4f46e5 0%,#6366f1 40%,#8b5cf6 80%,#a855f7 100%);
  box-shadow:
    0 8px 36px rgba(99,102,241,.58),
    0 2px 0 rgba(255,255,255,.12) inset,
    0 -1px 0 rgba(0,0,0,.20) inset;
  position:relative;overflow:hidden;transition:transform .22s,box-shadow .22s;
}
/* Shimmer sweep */
.btn::before{
  content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.16),transparent);
  transform:skewX(-20deg);
  animation:shimmer 3.5s ease-in-out infinite;
}
/* Bottom glow bar */
.btn::after{
  content:'';position:absolute;bottom:0;left:15%;right:15%;height:1px;
  background:rgba(255,255,255,.25);border-radius:1px;
}
@keyframes shimmer{0%{left:-100%}60%,100%{left:140%}}
.btn:hover{transform:translateY(-3px);box-shadow:0 18px 48px rgba(99,102,241,.72),0 2px 0 rgba(255,255,255,.12) inset}
.btn:active{transform:translateY(-1px)}
.btn-inner{display:flex;align-items:center;justify-content:center;gap:10px}
.btn-arrow{
  display:inline-flex;align-items:center;justify-content:center;
  width:28px;height:28px;border-radius:8px;
  background:rgba(255,255,255,.15);
  transition:transform .22s,background .22s;
  flex-shrink:0;
}
.btn:hover .btn-arrow{transform:translateX(3px);background:rgba(255,255,255,.22)}

.ftxt{font-size:.88rem;color:#252a3e;font-weight:500}
.flnk{color:#818cf8;font-weight:700;text-decoration:none;transition:color .18s}
.flnk:hover{color:#c4b5fd}

/* ══ FEATURE PILLS ══ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:11px;
  margin-top:24px;animation:up .6s .27s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:10px;
  padding:10px 22px;border-radius:60px;
  background:rgba(6,4,20,.92);
  border:1.5px solid rgba(34,28,74,.96);
  backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
  font-size:.82rem;font-weight:700;color:#3d4460;
  position:relative;transition:all .22s;cursor:default;white-space:nowrap;
}
.pill:hover{border-color:rgba(99,102,241,.36);color:#64748b;transform:translateY(-2px)}
.pill::after{content:'';position:absolute;top:-4px;right:-4px;width:10px;height:10px;border-radius:50%;border:2px solid rgba(5,3,14,.95)}
.pwa::after {background:#22c55e;box-shadow:0 0 8px #22c55e,0 0 20px rgba(34,197,94,.55)}
.pfac::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 20px rgba(96,165,250,.55)}
.prep::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 20px rgba(96,165,250,.55)}
.pcrm::after{background:#a78bfa;box-shadow:0 0 8px #a78bfa,0 0 20px rgba(167,139,250,.55)}
.pico{width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.pico svg{width:17px;height:17px}

/* Copyright */
.copy{margin-top:18px;text-align:center;animation:up .6s .39s ease both}
.copy p{font-size:.73rem;color:#111827;display:inline-flex;align-items:center;flex-wrap:wrap;justify-content:center;gap:5px}

@keyframes up{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<div class="stars"></div>
<div class="grid-floor"></div>
<div class="topline"></div>

<div class="page">

  <!-- LOGO — use the provided badge image directly -->
  <div class="logo-wrap">
    <img src="{{ asset('logo-badge.png') }}" alt="ASOIINFO">
  </div>

  <!-- CARD -->
  <div class="card">
    <div class="cbody">

      <div class="a-icon">A</div>
      <h1 class="ctitle">Iniciar sesión</h1>
      <p class="csub">Accede a tu cuenta para continuar<br>gestionando tu empresa.</p>

      @if($errors->any())
      <div class="alert aerr">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $errors->first() }}
      </div>
      @endif
      @if(session('status'))
      <div class="alert aok">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('status') }}
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" style="margin-top:22px">
        @csrf

        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <input class="inp" type="email" name="email" value="{{ old('email') }}"
                 required autofocus autocomplete="email" placeholder="Correo electrónico">
        </div>

        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <input class="inp" id="pwd" type="password" name="password"
                 required autocomplete="current-password" placeholder="Contraseña"
                 style="padding-right:48px">
          <button type="button" class="eye" onclick="togglePwd()">
            <svg id="eyesvg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>

        <div class="chk-row">
          <label class="chk-lbl"><input type="checkbox" name="remember"> Recordarme</label>
          <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn">
          <span class="btn-inner">
            Ingresar al sistema
            <span class="btn-arrow">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
              </svg>
            </span>
          </span>
        </button>
      </form>
    </div>

    <div class="cfoot">
      <p class="ftxt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="flnk">Crear cuenta →</a></p>
    </div>
  </div>

  <!-- FEATURE PILLS -->
  <div class="pills">
    <span class="pill pwa">
      <span class="pico" style="background:rgba(34,197,94,.12)">
        <svg viewBox="0 0 24 24" fill="#22c55e"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      </span>WhatsApp
    </span>
    <span class="pill pfac">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
      </span>Facturación
    </span>
    <span class="pill prep">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
      </span>Reportes
    </span>
    <span class="pill pcrm">
      <span class="pico" style="background:rgba(167,139,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      </span>CRM
    </span>
  </div>

  <!-- COPYRIGHT -->
  <div class="copy">
    <p>
      © {{ date('Y') }} ASOIINFO. Todos los derechos reservados. &nbsp;·&nbsp;
      <svg fill="none" viewBox="0 0 24 24" stroke="#1e2535" stroke-width="2" style="width:12px;height:12px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      <span style="color:#1e2535">Seguridad y confianza</span>
    </p>
  </div>

</div>

<script>
function togglePwd(){
  var p=document.getElementById('pwd'),s=document.getElementById('eyesvg');
  if(p.type==='password'){
    p.type='text';
    s.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
  }else{
    p.type='password';
    s.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
  }
}
</script>
</body>
</html>
