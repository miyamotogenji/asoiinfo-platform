<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ASOIINFO — Iniciar sesión</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden;font-family:'Space Grotesk',sans-serif;color:#e2e8f0;-webkit-font-smoothing:antialiased}

/* ─── CANVAS BG ─── */
#bg{position:fixed;inset:0;z-index:0;display:block;width:100%;height:100%}

/* ─── TOP LINE ─── */
.tl{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:200;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 15%,#a78bfa 40%,#818cf8 60%,#06b6d4 85%,transparent 100%);
  box-shadow:0 0 30px rgba(124,58,237,1),0 0 70px rgba(168,85,247,.55);
}

/* ─── PAGE ─── */
.page{
  position:relative;z-index:10;isolation:isolate;
  min-height:100vh;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:20px 16px 22px;
}

/* ═══════════════════════════════════
   LOGO — animated gradient wordmark
═══════════════════════════════════ */
.logo-wrap{margin-bottom:30px;animation:fadeUp .5s ease both;text-align:center}

.logo-badge{
  display:inline-flex;align-items:center;gap:14px;
  padding:12px 30px 12px 14px;
  border-radius:100px;
  background:rgba(8,5,28,.92);
  position:relative;
  backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);
}
/* Animated gradient border */
.logo-badge::before{
  content:'';
  position:absolute;inset:-1.5px;border-radius:100px;
  background:linear-gradient(120deg,#7c3aed,#818cf8,#06b6d4,#7c3aed);
  background-size:300% 300%;
  animation:borderFlow 4s linear infinite;
  z-index:-1;
  filter:blur(0);
  opacity:.9;
}
.logo-badge::after{
  content:'';
  position:absolute;inset:-1.5px;border-radius:100px;
  background:linear-gradient(120deg,#7c3aed,#818cf8,#06b6d4,#7c3aed);
  background-size:300% 300%;
  animation:borderFlow 4s linear infinite;
  z-index:-2;
  filter:blur(12px);
  opacity:.55;
}
@keyframes borderFlow{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}

/* Logo mark — gradient infinity */
.logo-mark{
  width:40px;height:40px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
}
.logo-mark svg{width:40px;height:40px}

.logo-name{
  font-family:'Space Grotesk',sans-serif;
  font-size:1.3rem;font-weight:700;letter-spacing:.12em;
  background:linear-gradient(90deg,#c4b5fd,#a5b4fc,#67e8f9);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
}

/* ═══════════════════════════════════
   CARD
═══════════════════════════════════ */
.card{
  width:100%;max-width:456px;
  background:rgba(8,5,26,.86);
  border:1px solid rgba(80,60,160,.38);
  border-radius:28px;
  backdrop-filter:blur(72px);-webkit-backdrop-filter:blur(72px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.046),
    inset 0 1.5px 0 rgba(255,255,255,.09),
    0 60px 120px rgba(0,0,0,.85),
    0 0 100px rgba(80,50,200,.14);
  overflow:hidden;
  animation:fadeUp .55s .1s ease both;
}
.cbody{padding:38px 44px 28px;text-align:center}
.cfoot{padding:16px 44px 20px;border-top:1px solid rgba(80,60,160,.18);text-align:center}

/* App icon */
.app-icon{
  width:68px;height:68px;border-radius:22px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(145deg,#4f46e5 0%,#7c3aed 55%,#a855f7 100%);
  box-shadow:0 12px 44px rgba(124,58,237,.65),inset 0 2px 0 rgba(255,255,255,.25);
  margin-bottom:20px;
  font-family:'Space Grotesk',sans-serif;
  font-size:2rem;font-weight:700;color:#fff;
  text-shadow:0 2px 12px rgba(0,0,0,.4);letter-spacing:-.03em;
}

.ctitle{
  font-size:2.05rem;font-weight:700;color:#f1f5f9;
  letter-spacing:-.055em;line-height:1.1;
}
.csub{font-size:.92rem;color:#374151;margin-top:10px;line-height:1.7;font-weight:400}

/* Alerts */
.alert{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;border-radius:14px;margin-top:16px;font-size:.875rem;line-height:1.5;text-align:left}
.alert svg{width:18px;height:18px;flex-shrink:0;margin-top:1px}
.aerr{background:rgba(127,29,29,.18);border:1px solid rgba(239,68,68,.25);color:#fca5a5}
.aok {background:rgba(6,78,59,.18); border:1px solid rgba(16,185,129,.25);color:#6ee7b7}

/* Inputs */
.field{margin-top:16px;position:relative;text-align:left}
.fi{position:absolute;left:17px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:#1e2538;pointer-events:none}
.inp{
  width:100%;
  background:rgba(3,1,16,.96);
  border:1.5px solid rgba(32,24,76,.98);
  border-radius:15px;
  padding:16.5px 16px 16.5px 50px;
  font-size:1rem;color:#cbd5e1;
  font-family:'Space Grotesk',sans-serif;font-weight:400;
  outline:none;
  transition:border-color .22s,box-shadow .22s,background .22s;
  letter-spacing:.01em;
}
.inp::placeholder{color:#17202e;font-weight:300}
.inp:focus{
  border-color:rgba(124,58,237,.58);
  background:rgba(3,1,18,1);
  box-shadow:0 0 0 4px rgba(124,58,237,.12);
}
.eye{
  position:absolute;right:16px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:22px;height:22px;color:#1e2538;
  display:flex;align-items:center;justify-content:center;transition:color .18s;
}
.eye:hover{color:#7c3aed}
.eye svg{width:20px;height:20px}

/* Checkbox row */
.chk-row{display:flex;align-items:center;justify-content:space-between;margin-top:16px;text-align:left}
.chk-lbl{display:flex;align-items:center;gap:8px;font-size:.86rem;color:#1e2538;cursor:pointer;user-select:none;font-weight:500}
.chk-lbl input{width:15px;height:15px;cursor:pointer;accent-color:#7c3aed}
.forgot{font-size:.86rem;color:#1e2538;text-decoration:none;font-weight:600;transition:color .18s}
.forgot:hover{color:#a78bfa}

/* ═══ BUTTON ═══ */
.btn-wrap{margin-top:26px;position:relative}
.btn{
  width:100%;padding:20px 28px;
  border-radius:18px;border:none;cursor:pointer;
  font-family:'Space Grotesk',sans-serif;
  font-size:1.14rem;font-weight:700;color:#fff;letter-spacing:.03em;
  background:linear-gradient(105deg,#4f46e5 0%,#7c3aed 45%,#a855f7 80%,#c084fc 100%);
  box-shadow:
    0 0 0 1px rgba(124,58,237,.5),
    0 12px 48px rgba(124,58,237,.65),
    0 2px 0 rgba(255,255,255,.16) inset;
  position:relative;overflow:hidden;
  transition:transform .24s cubic-bezier(.34,1.56,.64,1),box-shadow .24s;
  display:flex;align-items:center;justify-content:center;gap:14px;
}
/* sweep shimmer */
.btn::before{
  content:'';position:absolute;top:0;left:-80%;width:44%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.20),transparent);
  transform:skewX(-16deg);
  animation:shim 3.2s ease-in-out infinite;
}
@keyframes shim{0%{left:-80%}55%,100%{left:130%}}
.btn:hover{
  transform:translateY(-4px) scale(1.015);
  box-shadow:0 0 0 1px rgba(124,58,237,.6),0 22px 60px rgba(124,58,237,.80),0 2px 0 rgba(255,255,255,.16) inset;
}
.btn:active{transform:translateY(-1px) scale(1)}
.btn-txt{position:relative;z-index:1}
.btn-ico{
  position:relative;z-index:1;
  width:34px;height:34px;border-radius:10px;
  background:rgba(255,255,255,.18);
  display:flex;align-items:center;justify-content:center;
  transition:transform .24s cubic-bezier(.34,1.56,.64,1),background .18s;
  flex-shrink:0;
}
.btn:hover .btn-ico{transform:translateX(5px);background:rgba(255,255,255,.28)}
.btn-ico svg{width:18px;height:18px}

.ftxt{font-size:.88rem;color:#1e2538;font-weight:500}
.flnk{color:#a78bfa;font-weight:700;text-decoration:none;transition:color .18s}
.flnk:hover{color:#c4b5fd}

/* ═══ PILLS — bigger icons ═══ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:12px;
  margin-top:28px;animation:fadeUp .6s .28s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:11px;
  padding:11px 24px 11px 10px;border-radius:100px;
  background:rgba(7,4,24,.92);
  border:1.5px solid rgba(38,30,80,.95);
  backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);
  font-size:.84rem;font-weight:600;color:#2e3554;letter-spacing:.01em;
  position:relative;transition:all .24s;cursor:default;white-space:nowrap;
}
.pill:hover{border-color:rgba(124,58,237,.38);color:#64748b;transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,0,0,.3)}
/* glow dot */
.pill::after{content:'';position:absolute;top:-5px;right:-5px;width:12px;height:12px;border-radius:50%;border:2.5px solid rgba(6,3,18,.95)}
.pwa::after {background:#22c55e;box-shadow:0 0 10px #22c55e,0 0 24px rgba(34,197,94,.6)}
.pfac::after{background:#60a5fa;box-shadow:0 0 10px #60a5fa,0 0 24px rgba(96,165,250,.6)}
.prep::after{background:#60a5fa;box-shadow:0 0 10px #60a5fa,0 0 24px rgba(96,165,250,.6)}
.pcrm::after{background:#c084fc;box-shadow:0 0 10px #c084fc,0 0 24px rgba(192,132,252,.6)}

/* Icon container — big, rounded square */
.pico{
  width:42px;height:42px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.pico svg{width:24px;height:24px}

/* Copyright */
.copy{margin-top:20px;text-align:center;animation:fadeUp .6s .4s ease both}
.copy p{font-size:.72rem;color:#0f172a;display:inline-flex;align-items:center;flex-wrap:wrap;justify-content:center;gap:5px;font-weight:500}

@keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<canvas id="bg"></canvas>
<div class="tl"></div>

<div class="page">

  <!-- ══ LOGO ══ -->
  <div class="logo-wrap">
    <div class="logo-badge">
      <div class="logo-mark">
        <svg viewBox="0 0 48 48" fill="none">
          <defs>
            <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#60a5fa"/>
              <stop offset="50%" stop-color="#818cf8"/>
              <stop offset="100%" stop-color="#a855f7"/>
            </linearGradient>
            <linearGradient id="g2" x1="100%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%" stop-color="#a855f7"/>
              <stop offset="50%" stop-color="#818cf8"/>
              <stop offset="100%" stop-color="#22d3ee"/>
            </linearGradient>
          </defs>
          <!-- Left chain link -->
          <path d="M22 14C17.582 14 14 17.582 14 22C14 26.418 17.582 30 22 30L26 30C26.552 30 27 29.552 27 29C27 28.448 26.552 28 26 28L22 28C18.686 28 16 25.314 16 22C16 18.686 18.686 16 22 16L26 16C26.552 16 27 15.552 27 15C27 14.448 26.552 14 26 14L22 14Z" fill="url(#g1)"/>
          <!-- Right chain link -->
          <path d="M26 18C30.418 18 34 21.582 34 26C34 30.418 30.418 34 26 34L22 34C21.448 34 21 33.552 21 33C21 32.448 21.448 32 22 32L26 32C29.314 32 32 29.314 32 26C32 22.686 29.314 20 26 20L22 20C21.448 20 21 19.552 21 19C21 18.448 21.448 18 22 18L26 18Z" fill="url(#g2)"/>
          <!-- Center connector -->
          <rect x="20" y="21" width="8" height="6" rx="3" fill="url(#g1)"/>
        </svg>
      </div>
      <span class="logo-name">ASOIINFO</span>
    </div>
  </div>

  <!-- ══ CARD ══ -->
  <div class="card">
    <div class="cbody">

      <div class="app-icon">A</div>
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

      <form method="POST" action="{{ route('login.post') }}" style="margin-top:24px">
        @csrf

        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
          </svg>
          <input class="inp" type="email" name="email" value="{{ old('email') }}"
                 required autofocus autocomplete="email" placeholder="Correo electrónico">
        </div>

        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
          </svg>
          <input class="inp" id="pwd" type="password" name="password"
                 required autocomplete="current-password" placeholder="Contraseña"
                 style="padding-right:52px">
          <button type="button" class="eye" onclick="togglePwd()">
            <svg id="eyesvg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </button>
        </div>

        <div class="chk-row">
          <label class="chk-lbl"><input type="checkbox" name="remember"> Recordarme</label>
          <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="btn-wrap">
          <button type="submit" class="btn">
            <span class="btn-txt">Ingresar al sistema</span>
            <span class="btn-ico">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
              </svg>
            </span>
          </button>
        </div>
      </form>
    </div>

    <div class="cfoot">
      <p class="ftxt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="flnk">Crear cuenta →</a></p>
    </div>
  </div>

  <!-- ══ PILLS ══ -->
  <div class="pills">

    <span class="pill pwa">
      <span class="pico" style="background:rgba(34,197,94,.13)">
        <svg viewBox="0 0 24 24" fill="#22c55e">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      </span>WhatsApp
    </span>

    <span class="pill pfac">
      <span class="pico" style="background:rgba(96,165,250,.13)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
        </svg>
      </span>Facturación
    </span>

    <span class="pill prep">
      <span class="pico" style="background:rgba(96,165,250,.13)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
        </svg>
      </span>Reportes
    </span>

    <span class="pill pcrm">
      <span class="pico" style="background:rgba(192,132,252,.13)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#c084fc" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
        </svg>
      </span>CRM
    </span>

  </div>

  <!-- COPYRIGHT -->
  <div class="copy">
    <p>
      © {{ date('Y') }} ASOIINFO · Todos los derechos reservados &nbsp;·&nbsp;
      <svg fill="none" viewBox="0 0 24 24" stroke="#0f172a" stroke-width="2" style="width:13px;height:13px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
      </svg>
      <span style="color:#0f172a">Seguridad y confianza</span>
    </p>
  </div>

</div>

<script>
/* ══════════════════════════════════════════════
   CANVAS — aurora nebula + stars + grid
══════════════════════════════════════════════ */
(function(){
  var c=document.getElementById('bg'),ctx=c.getContext('2d'),W,H,T=0;
  function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight}
  window.addEventListener('resize',resize);resize();

  /* 220 stars */
  var S=[];
  for(var i=0;i<220;i++) S.push({
    x:Math.random(),y:Math.random(),
    r:Math.random()*1.6+.25,
    a:Math.random()*.75+.18,
    sp:Math.random()*.03+.005,
    h:Math.random()<.14?(Math.random()<.5?265:188):0,
    sat:Math.random()<.14?85:0
  });

  /* 10 aurora blobs */
  var B=[
    /* Left — violet/indigo column */
    {x:.10,y:.12,rx:.22,ry:.60,h:268,s:92,a:.92,d:.85},
    {x:.07,y:.40,rx:.15,ry:.44,h:272,s:88,a:.70,d:1.20},
    {x:.13,y:.68,rx:.12,ry:.34,h:265,s:84,a:.52,d:.70},
    {x:.21,y:.26,rx:.26,ry:.46,h:260,s:74,a:.32,d:1.50},
    {x:.05,y:.82,rx:.10,ry:.24,h:276,s:80,a:.38,d:.90},
    /* Right — cyan/teal column */
    {x:.90,y:.09,rx:.19,ry:.52,h:186,s:94,a:.86,d:.90},
    {x:.94,y:.35,rx:.14,ry:.38,h:183,s:90,a:.66,d:1.30},
    {x:.97,y:.62,rx:.11,ry:.30,h:189,s:86,a:.48,d:.72},
    {x:.84,y:.19,rx:.22,ry:.40,h:192,s:78,a:.30,d:1.55},
    {x:.96,y:.80,rx:.09,ry:.22,h:185,s:82,a:.36,d:.88},
  ];

  function grid(){
    var gy=H*.53,gh=H-gy;
    ctx.save();ctx.globalCompositeOperation='lighter';
    var vx=W*.5,vy=gy;
    for(var i=0;i<=32;i++){
      var bx=(i/32)*W;
      ctx.beginPath();ctx.moveTo(vx,vy);ctx.lineTo(bx,H);
      ctx.strokeStyle='rgba(135,50,255,.22)';ctx.lineWidth=.85;ctx.stroke();
    }
    for(var j=1;j<=20;j++){
      var r=Math.pow(j/20,1.65),hy=gy+gh*r;
      var sp=.42+r*.58,al=.045+r*.30;
      ctx.beginPath();ctx.moveTo(vx-W*.9*sp,hy);ctx.lineTo(vx+W*.9*sp,hy);
      ctx.strokeStyle='rgba(135,50,255,'+al+')';ctx.lineWidth=.85;ctx.stroke();
    }
    ctx.restore();
  }

  function aurora(t){
    ctx.save();ctx.globalCompositeOperation='screen';
    B.forEach(function(b,i){
      var ox=Math.sin(t*.35+i*1.85)*.022*b.d;
      var oy=Math.cos(t*.25+i*2.45)*.014*b.d;
      var cx=(b.x+ox)*W,cy=(b.y+oy)*H;
      var rx=b.rx*W,ry=b.ry*H;
      var pulse=1+Math.sin(t*.50+i*1.25)*.08;
      var a=b.a*(0.85+Math.sin(t*.42+i*.92)*.15);
      var g=ctx.createRadialGradient(cx,cy,0,cx,cy,Math.max(rx,ry)*pulse);
      g.addColorStop(0,'hsla('+b.h+','+b.s+'%,68%,'+a+')');
      g.addColorStop(.34,'hsla('+b.h+','+b.s+'%,54%,'+(a*.48)+')');
      g.addColorStop(.68,'hsla('+b.h+','+b.s+'%,45%,'+(a*.14)+')');
      g.addColorStop(1,'transparent');
      ctx.save();
      ctx.translate(cx,cy);ctx.scale(1,ry/rx);ctx.translate(-cx,-cy);
      ctx.beginPath();ctx.arc(cx,cy,rx*pulse,0,Math.PI*2);
      ctx.fillStyle=g;ctx.filter='blur(22px)';ctx.fill();
      ctx.restore();
    });
    ctx.restore();
  }

  function stars(t){
    ctx.save();ctx.globalCompositeOperation='lighter';
    S.forEach(function(s){
      var f=.5+.5*Math.sin(t*s.sp*60+s.x*90+s.y*40);
      var a=s.a*.68*f+.10;
      ctx.beginPath();ctx.arc(s.x*W,s.y*H,s.r,0,Math.PI*2);
      ctx.fillStyle=s.sat>0?'hsla('+s.h+','+s.sat+'%,82%,'+a+')':'rgba(255,255,255,'+a+')';
      ctx.fill();
    });
    ctx.restore();
  }

  function frame(ts){
    T=ts*.001;
    ctx.fillStyle='#04020e';ctx.fillRect(0,0,W,H);
    aurora(T);stars(T);grid();
    requestAnimationFrame(frame);
  }
  requestAnimationFrame(frame);
})();

/* Eye toggle */
function togglePwd(){
  var p=document.getElementById('pwd'),s=document.getElementById('eyesvg');
  if(p.type==='password'){
    p.type='text';
    s.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>';
  }else{
    p.type='password';
    s.innerHTML='<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
  }
}
</script>
</body>
</html>
