<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden;font-family:'Sora',sans-serif;color:#e2e8f0}

/* ════ BACKGROUND — pure CSS aurora ════ */
body{ background:#060412; }

/* Left aurora — purple column */
body::before{
  content:'';position:fixed;inset:0;z-index:1;pointer-events:none;
  background:
    radial-gradient(ellipse 22% 72% at 13% 14%, rgba(168,40,255,.82) 0%, rgba(130,18,230,.48) 36%, transparent 65%),
    radial-gradient(ellipse 16% 78% at  8% 40%, rgba(148,25,245,.60) 0%, rgba(110,10,205,.28) 55%, transparent 74%),
    radial-gradient(ellipse 12% 42% at  6% 72%, rgba(130,20,238,.44) 0%, transparent 62%),
    radial-gradient(ellipse 30% 55% at 20% 26%, rgba(100,16,195,.22) 0%, transparent 60%);
  mix-blend-mode:screen;
  filter:blur(22px);
  animation:al 16s ease-in-out infinite alternate;
}
/* Right aurora — teal column */
body::after{
  content:'';position:fixed;inset:0;z-index:1;pointer-events:none;
  background:
    radial-gradient(ellipse 18% 65% at 88% 10%, rgba(0,228,212,.78) 0%, rgba(0,192,195,.44) 38%, transparent 64%),
    radial-gradient(ellipse 13% 72% at 94% 34%, rgba(0,210,202,.56) 0%, rgba(0,168,182,.26) 54%, transparent 73%),
    radial-gradient(ellipse 10% 40% at 96% 66%, rgba(0,198,200,.38) 0%, transparent 60%),
    radial-gradient(ellipse 25% 50% at 81% 20%, rgba(0,160,185,.20) 0%, transparent 60%);
  mix-blend-mode:screen;
  filter:blur(26px);
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
    radial-gradient(1.5px 1.5px at 61%  4%,rgba(255,255,255,.68) 0%,transparent 100%),
    radial-gradient(2.4px 2.4px at 51% 17%,rgba(200,138,255,.98) 0%,transparent 100%),
    radial-gradient(2.4px 2.4px at 83% 55%,rgba(118,138,255,.98) 0%,transparent 100%),
    radial-gradient(2.1px 2.1px at 17% 25%,rgba(0,232,212,.92)   0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 43% 11%,rgba(255,255,255,.54) 0%,transparent 100%),
    radial-gradient(1.2px 1.2px at 27% 44%,rgba(255,255,255,.38) 0%,transparent 100%),
    radial-gradient(1.6px 1.6px at 69% 20%,rgba(255,255,255,.70) 0%,transparent 100%),
    radial-gradient(1.3px 1.3px at 88% 37%,rgba(212,164,255,.80) 0%,transparent 100%),
    radial-gradient(1.2px 1.2px at 56% 31%,rgba(255,255,255,.42) 0%,transparent 100%),
    radial-gradient(1.5px 1.5px at  6% 70%,rgba(255,255,255,.32) 0%,transparent 100%),
    radial-gradient(1.2px 1.2px at 38% 78%,rgba(255,255,255,.26) 0%,transparent 100%),
    radial-gradient(1.5px 1.5px at 74% 62%,rgba(255,255,255,.34) 0%,transparent 100%);
  animation:twinkle 10s ease-in-out infinite alternate;
}
@keyframes twinkle{0%,100%{opacity:1}50%{opacity:.35}}

/* Perspective neon grid floor */
.grid-floor{
  position:fixed;bottom:0;left:-20%;right:-20%;height:50%;z-index:2;pointer-events:none;
  background-image:
    linear-gradient(rgba(145,55,255,.36) 1px,transparent 1px),
    linear-gradient(90deg,rgba(145,55,255,.36) 1px,transparent 1px);
  background-size:50px 50px;
  transform:perspective(320px) rotateX(76deg);
  transform-origin:bottom center;
  filter:drop-shadow(0 0 6px rgba(145,55,255,.70));
  mask-image:linear-gradient(to top,rgba(0,0,0,.80) 0%,rgba(0,0,0,.22) 52%,transparent 78%);
  -webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.80) 0%,rgba(0,0,0,.22) 52%,transparent 78%);
}

/* Top accent line */
.topline{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:100;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 18%,#a855f7 50%,#06b6d4 82%,transparent 100%);
  box-shadow:0 0 22px rgba(124,58,237,.9),0 0 55px rgba(168,85,247,.45);
}

/* ════ PAGE ════ */
.page{
  position:relative;z-index:10;
  min-height:100vh;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:22px 16px 26px;
  isolation:isolate;
}

/* ════ LOGO PILL ════ */
.logo-pill{
  display:inline-flex;align-items:center;gap:13px;
  padding:9px 26px 9px 12px;border-radius:60px;
  background:rgba(5,3,16,.86);
  border:1.5px solid rgba(150,85,255,.72);
  box-shadow:
    0 0 16px rgba(150,85,255,.68),
    0 0 48px rgba(150,85,255,.28),
    0 0 90px rgba(150,85,255,.12),
    inset 0 1px 0 rgba(255,255,255,.07);
  margin-bottom:26px;
  animation:up .5s ease both;
  backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);
}
.logo-pill img{
  height:30px;width:auto;display:block;
  mix-blend-mode:screen;
  filter:drop-shadow(0 0 10px rgba(150,85,255,.98)) brightness(1.12);
}
.logo-text{
  font-size:1.2rem;font-weight:800;color:#fff;letter-spacing:.09em;
  text-shadow:0 0 14px rgba(175,90,255,.65);
}

/* ════ CARD ════ */
.card{
  width:100%;max-width:440px;
  background:rgba(7,5,20,.84);
  border:1px solid rgba(70,56,148,.40);
  border-radius:22px;
  backdrop-filter:blur(64px);-webkit-backdrop-filter:blur(64px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.045),
    inset 0 1px 0 rgba(255,255,255,.08),
    0 48px 96px rgba(0,0,0,.78),
    0 0 80px rgba(55,36,178,.10);
  overflow:hidden;
  animation:up .55s .08s ease both;
}
.cbody{padding:32px 36px 24px;text-align:center}
.cfoot{padding:14px 36px 18px;border-top:1px solid rgba(68,54,148,.22);text-align:center}

/* "A" icon — blue→purple gradient square */
.a-icon{
  width:58px;height:58px;border-radius:16px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(148deg,#4e90f8 0%,#5b5cdb 44%,#7b3aed 100%);
  box-shadow:0 8px 30px rgba(99,102,241,.60),inset 0 2px 0 rgba(255,255,255,.22);
  margin-bottom:18px;
  font-family:'Sora',sans-serif;font-size:1.72rem;font-weight:900;color:#fff;
  text-shadow:0 2px 8px rgba(0,0,0,.32);letter-spacing:-.04em;
}

.ctitle{font-size:1.8rem;font-weight:800;color:#f8fafc;letter-spacing:-.045em;line-height:1.12}
.csub{font-size:.875rem;color:#374151;margin-top:8px;line-height:1.6}

/* Alerts */
.alert{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border-radius:12px;margin-top:14px;font-size:.875rem;line-height:1.45;text-align:left}
.alert svg{width:17px;height:17px;flex-shrink:0;margin-top:1px}
.aerr{background:rgba(127,29,29,.18);border:1px solid rgba(239,68,68,.25);color:#fca5a5}
.aok {background:rgba(6,78,59,.18); border:1px solid rgba(16,185,129,.25);color:#6ee7b7}

/* Inputs */
.field{margin-top:15px;position:relative;text-align:left}
.fi{position:absolute;left:15px;top:50%;transform:translateY(-50%);width:17px;height:17px;color:#22263a;pointer-events:none}
.inp{
  width:100%;
  background:rgba(2,1,12,.94);
  border:1.5px solid rgba(30,25,72,.98);
  border-radius:13px;
  padding:14.5px 15px 14.5px 45px;
  font-size:.96rem;color:#d1d5db;
  font-family:'Sora',sans-serif;outline:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
.inp::placeholder{color:#17202e}
.inp:focus{border-color:rgba(99,102,241,.55);background:rgba(2,1,14,1);box-shadow:0 0 0 3px rgba(99,102,241,.10)}
.eye{
  position:absolute;right:13px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:20px;height:20px;color:#22263a;
  display:flex;align-items:center;justify-content:center;transition:color .18s;
}
.eye:hover{color:#6366f1}
.eye svg{width:17px;height:17px}

/* Checkbox row */
.chk-row{display:flex;align-items:center;justify-content:space-between;margin-top:14px;text-align:left}
.chk-lbl{display:flex;align-items:center;gap:7px;font-size:.83rem;color:#252a3e;cursor:pointer;user-select:none}
.chk-lbl input{width:14px;height:14px;cursor:pointer;accent-color:#6366f1}
.forgot{font-size:.82rem;color:#252a3e;text-decoration:none;font-weight:500;transition:color .18s}
.forgot:hover{color:#818cf8}

/* Submit */
.btn{
  width:100%;margin-top:18px;
  padding:15px 20px;border-radius:13px;border:none;cursor:pointer;
  font-family:'Sora',sans-serif;font-size:1.04rem;font-weight:700;color:#fff;letter-spacing:.016em;
  background:linear-gradient(93deg,#3b82f6 0%,#5a5be0 46%,#6264f0 100%);
  box-shadow:0 6px 28px rgba(99,102,241,.56),inset 0 1px 0 rgba(255,255,255,.16);
  position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;
}
.btn::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(93deg,transparent,rgba(255,255,255,.09) 50%,transparent);
  transform:translateX(-100%);transition:transform .55s;
}
.btn:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(99,102,241,.72)}
.btn:hover::after{transform:translateX(100%)}
.btn:active{transform:translateY(0)}

.ftxt{font-size:.87rem;color:#252a3e}
.flnk{color:#818cf8;font-weight:600;text-decoration:none;transition:color .18s}
.flnk:hover{color:#c4b5fd}

/* ════ FEATURE PILLS ════ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:11px;
  margin-top:22px;animation:up .6s .27s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:10px;
  padding:10px 21px;border-radius:60px;
  background:rgba(6,4,18,.90);
  border:1.5px solid rgba(34,28,74,.96);
  backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
  font-size:.82rem;font-weight:600;color:#3d4460;
  position:relative;transition:all .22s;cursor:default;white-space:nowrap;
}
.pill:hover{border-color:rgba(99,102,241,.36);color:#64748b;transform:translateY(-2px)}
/* Glow dot */
.pill::after{
  content:'';position:absolute;top:-4px;right:-4px;
  width:10px;height:10px;border-radius:50%;
  border:2px solid rgba(5,3,14,.95);
}
.pwa::after {background:#22c55e;box-shadow:0 0 8px #22c55e,0 0 18px rgba(34,197,94,.55)}
.pfac::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 18px rgba(96,165,250,.55)}
.prep::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 18px rgba(96,165,250,.55)}
.pcrm::after{background:#a78bfa;box-shadow:0 0 8px #a78bfa,0 0 18px rgba(167,139,250,.55)}

.pico{
  width:32px;height:32px;border-radius:10px;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.pico svg{width:17px;height:17px}

/* ════ COPYRIGHT ════ */
.copy{margin-top:18px;text-align:center;animation:up .6s .39s ease both}
.copy p{
  font-size:.73rem;color:#141c2c;
  display:inline-flex;align-items:center;flex-wrap:wrap;justify-content:center;gap:5px;
}

@keyframes up{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<div class="stars"></div>
<div class="grid-floor"></div>
<div class="topline"></div>

<div class="page">

  <!-- ── LOGO PILL ── -->
  <div class="logo-pill">
    <img src="{{ asset('logo.png') }}" alt="ASOIINFO">
    <span class="logo-text">ASOIINFO</span>
  </div>

  <!-- ── CARD ── -->
  <div class="card">
    <div class="cbody">

      <!-- Blue "A" icon -->
      <div class="a-icon">A</div>

      <h1 class="ctitle">Iniciar sesión</h1>
      <p class="csub">Accede a tu cuenta para continuar<br>gestionando tu empresa.</p>

      @if($errors->any())
      <div class="alert aerr">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $errors->first() }}
      </div>
      @endif
      @if(session('status'))
      <div class="alert aok">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('status') }}
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" style="margin-top:20px">
        @csrf

        <!-- Email field -->
        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <input class="inp" type="email" name="email"
                 value="{{ old('email') }}"
                 required autofocus autocomplete="email"
                 placeholder="Correo electrónico">
        </div>

        <!-- Password field -->
        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <input class="inp" id="pwd" type="password" name="password"
                 required autocomplete="current-password"
                 placeholder="Contraseña"
                 style="padding-right:46px">
          <button type="button" class="eye" onclick="togglePwd()">
            <svg id="eyesvg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>

        <!-- Checkbox / forgot row -->
        <div class="chk-row">
          <label class="chk-lbl">
            <input type="checkbox" name="remember"> Recordarme
          </label>
          <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn">Ingresar al sistema &nbsp;→</button>
      </form>
    </div>

    <div class="cfoot">
      <p class="ftxt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="flnk">Crear cuenta →</a></p>
    </div>
  </div>

  <!-- ── FEATURE PILLS ── -->
  <div class="pills">

    <!-- WhatsApp -->
    <span class="pill pwa">
      <span class="pico" style="background:rgba(34,197,94,.12)">
        <svg viewBox="0 0 24 24" fill="#22c55e">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      </span>
      WhatsApp
    </span>

    <!-- Facturación -->
    <span class="pill pfac">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
        </svg>
      </span>
      Facturación
    </span>

    <!-- Reportes -->
    <span class="pill prep">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
      </span>
      Reportes
    </span>

    <!-- CRM -->
    <span class="pill pcrm">
      <span class="pico" style="background:rgba(167,139,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </span>
      CRM
    </span>

  </div>

  <!-- ── COPYRIGHT ── -->
  <div class="copy">
    <p>
      © {{ date('Y') }} ASOIINFO. Todos los derechos reservados.
      &nbsp;·&nbsp;
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
