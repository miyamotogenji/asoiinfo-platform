<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden;font-family:'Inter',sans-serif;color:#e2e8f0}

/* ═══════════════════════════════════════════
   CANVAS — full-screen animated background
═══════════════════════════════════════════ */
#bg{position:fixed;inset:0;z-index:0;display:block;width:100%;height:100%}

.topline{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:100;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 18%,#a855f7 50%,#06b6d4 82%,transparent 100%);
  box-shadow:0 0 28px rgba(124,58,237,.95),0 0 64px rgba(168,85,247,.50);
}

/* ═══════════════════════════════════════════
   PAGE
═══════════════════════════════════════════ */
.page{
  position:relative;z-index:10;isolation:isolate;
  min-height:100vh;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:20px 16px 24px;
}

/* ═══ LOGO PILL (HTML — not an image) ═══ */
.logo-pill{
  display:inline-flex;align-items:center;gap:14px;
  padding:11px 30px 11px 13px;
  border-radius:60px;
  background:rgba(6,4,22,.90);
  border:1.5px solid rgba(160,90,255,.78);
  box-shadow:
    0 0  18px rgba(160,90,255,.72),
    0 0  56px rgba(160,90,255,.32),
    0 0 110px rgba(160,90,255,.14),
    inset 0 1px 0 rgba(255,255,255,.08);
  margin-bottom:28px;
  animation:up .5s ease both;
  backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);
}
/* chain-link SVG icon */
.logo-icon{
  width:38px;height:38px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
}
.logo-icon svg{width:38px;height:38px}
.logo-name{
  font-size:1.28rem;font-weight:800;color:#fff;
  letter-spacing:.10em;
  text-shadow:0 0 18px rgba(180,100,255,.65);
}

/* ═══ CARD ═══ */
.card{
  width:100%;max-width:452px;
  background:rgba(8,5,24,.85);
  border:1px solid rgba(75,58,155,.42);
  border-radius:26px;
  backdrop-filter:blur(68px);-webkit-backdrop-filter:blur(68px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.046),
    inset 0 1px 0 rgba(255,255,255,.09),
    0 56px 110px rgba(0,0,0,.82),
    0 0 96px rgba(58,36,182,.13);
  overflow:hidden;
  animation:up .55s .08s ease both;
}
.cbody{padding:36px 42px 26px;text-align:center}
.cfoot{padding:16px 42px 20px;border-top:1px solid rgba(72,54,150,.22);text-align:center}

/* "A" icon */
.a-icon{
  width:66px;height:66px;border-radius:20px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(148deg,#4d92f9 0%,#5a5ddc 42%,#7c3bef 100%);
  box-shadow:0 12px 38px rgba(99,102,241,.65),inset 0 2px 0 rgba(255,255,255,.24);
  margin-bottom:20px;
  font-family:'Inter',sans-serif;font-size:1.85rem;font-weight:900;color:#fff;
  text-shadow:0 2px 10px rgba(0,0,0,.38);letter-spacing:-.04em;
}

.ctitle{font-size:2rem;font-weight:800;color:#f8fafc;letter-spacing:-.055em;line-height:1.1}
.csub{font-size:.93rem;color:#374151;margin-top:9px;line-height:1.7;font-weight:400}

/* Alerts */
.alert{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;border-radius:14px;margin-top:14px;font-size:.88rem;line-height:1.45;text-align:left}
.alert svg{width:18px;height:18px;flex-shrink:0;margin-top:1px}
.aerr{background:rgba(127,29,29,.18);border:1px solid rgba(239,68,68,.25);color:#fca5a5}
.aok {background:rgba(6,78,59,.18); border:1px solid rgba(16,185,129,.25);color:#6ee7b7}

/* Input fields */
.field{margin-top:16px;position:relative;text-align:left}
.fi{
  position:absolute;left:17px;top:50%;transform:translateY(-50%);
  width:20px;height:20px;color:#22263a;pointer-events:none;
}
.inp{
  width:100%;
  background:rgba(2,1,14,.96);
  border:1.5px solid rgba(32,26,76,.98);
  border-radius:14px;
  padding:16px 16px 16px 50px;
  font-size:1rem;color:#d1d5db;
  font-family:'Inter',sans-serif;font-weight:400;
  outline:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
.inp::placeholder{color:#17202e;font-weight:300}
.inp:focus{border-color:rgba(99,102,241,.58);background:rgba(2,1,16,1);box-shadow:0 0 0 4px rgba(99,102,241,.12)}

.eye{
  position:absolute;right:15px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:22px;height:22px;color:#22263a;
  display:flex;align-items:center;justify-content:center;transition:color .18s;
}
.eye:hover{color:#6366f1}
.eye svg{width:20px;height:20px}

/* Checkbox row */
.chk-row{display:flex;align-items:center;justify-content:space-between;margin-top:16px;text-align:left}
.chk-lbl{display:flex;align-items:center;gap:8px;font-size:.86rem;color:#252a3e;cursor:pointer;user-select:none;font-weight:500}
.chk-lbl input{width:15px;height:15px;cursor:pointer;accent-color:#6366f1}
.forgot{font-size:.85rem;color:#252a3e;text-decoration:none;font-weight:600;transition:color .18s}
.forgot:hover{color:#818cf8}

/* ═══ BUTTON — large, modern, animated ═══ */
.btn{
  width:100%;margin-top:24px;
  padding:20px 28px;
  border-radius:16px;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;
  font-size:1.12rem;font-weight:700;color:#fff;letter-spacing:.025em;
  background:linear-gradient(105deg,#4338ca 0%,#6366f1 38%,#8b5cf6 70%,#a855f7 100%);
  box-shadow:
    0 10px 40px rgba(99,102,241,.60),
    0  2px  0 rgba(255,255,255,.14) inset,
    0 -2px  0 rgba(0,0,0,.22) inset;
  position:relative;overflow:hidden;
  transition:transform .22s cubic-bezier(.34,1.56,.64,1),box-shadow .22s;
  display:flex;align-items:center;justify-content:center;gap:12px;
}
/* Moving shimmer */
.btn::before{
  content:'';position:absolute;top:0;left:-80%;width:50%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);
  transform:skewX(-18deg);
  animation:shimmer 3s ease-in-out infinite;
}
@keyframes shimmer{0%{left:-80%}55%,100%{left:130%}}
/* Bottom edge glow */
.btn::after{
  content:'';position:absolute;bottom:0;left:20%;right:20%;height:1px;
  background:rgba(255,255,255,.28);border-radius:1px;
}
.btn:hover{transform:translateY(-3px) scale(1.01);box-shadow:0 20px 52px rgba(99,102,241,.74),0 2px 0 rgba(255,255,255,.14) inset}
.btn:active{transform:translateY(-1px) scale(1)}
.btn-label{position:relative;z-index:1}
.btn-arrow{
  position:relative;z-index:1;
  display:inline-flex;align-items:center;justify-content:center;
  width:32px;height:32px;border-radius:10px;
  background:rgba(255,255,255,.18);
  transition:transform .22s cubic-bezier(.34,1.56,.64,1),background .18s;
  flex-shrink:0;
}
.btn:hover .btn-arrow{transform:translateX(4px);background:rgba(255,255,255,.26)}
.btn-arrow svg{width:16px;height:16px}

.ftxt{font-size:.88rem;color:#252a3e;font-weight:500}
.flnk{color:#818cf8;font-weight:700;text-decoration:none;transition:color .18s}
.flnk:hover{color:#c4b5fd}

/* ═══ FEATURE PILLS — bigger icons ═══ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:12px;
  margin-top:26px;animation:up .6s .27s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:11px;
  padding:11px 22px;border-radius:60px;
  background:rgba(6,4,22,.92);
  border:1.5px solid rgba(36,28,76,.96);
  backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
  font-size:.84rem;font-weight:600;color:#3d4460;
  position:relative;transition:all .22s;cursor:default;white-space:nowrap;
}
.pill:hover{border-color:rgba(99,102,241,.38);color:#64748b;transform:translateY(-2px)}
/* Glow dot */
.pill::after{content:'';position:absolute;top:-4px;right:-4px;width:11px;height:11px;border-radius:50%;border:2px solid rgba(5,3,16,.95)}
.pwa::after {background:#22c55e;box-shadow:0 0 9px #22c55e,0 0 22px rgba(34,197,94,.55)}
.pfac::after{background:#60a5fa;box-shadow:0 0 9px #60a5fa,0 0 22px rgba(96,165,250,.55)}
.prep::after{background:#60a5fa;box-shadow:0 0 9px #60a5fa,0 0 22px rgba(96,165,250,.55)}
.pcrm::after{background:#a78bfa;box-shadow:0 0 9px #a78bfa,0 0 22px rgba(167,139,250,.55)}

/* BIGGER icon containers */
.pico{
  width:38px;height:38px;border-radius:12px;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.pico svg{width:22px;height:22px}

/* Copyright */
.copy{margin-top:18px;text-align:center;animation:up .6s .39s ease both}
.copy p{font-size:.73rem;color:#111827;display:inline-flex;align-items:center;flex-wrap:wrap;justify-content:center;gap:5px}

@keyframes up{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<canvas id="bg"></canvas>
<div class="topline"></div>

<div class="page">

  <!-- ─── LOGO PILL (HTML/SVG — crisp at any size) ─── -->
  <div class="logo-pill">
    <div class="logo-icon">
      <!-- Chain / infinity link icon matching the ASOIINFO brand -->
      <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="lg1" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#60a5fa"/>
            <stop offset="50%" stop-color="#818cf8"/>
            <stop offset="100%" stop-color="#a855f7"/>
          </linearGradient>
          <linearGradient id="lg2" x1="1" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#a855f7"/>
            <stop offset="50%" stop-color="#818cf8"/>
            <stop offset="100%" stop-color="#60a5fa"/>
          </linearGradient>
        </defs>
        <!-- Left link -->
        <path d="M20 16a8 8 0 0 0 0 16h3a1 1 0 0 0 0-2h-3a6 6 0 0 1 0-12h3a1 1 0 0 0 0-2h-3z" fill="url(#lg1)"/>
        <path d="M20 16a8 8 0 0 0 0 16h3a1 1 0 0 0 0-2h-3a6 6 0 0 1 0-12h3a1 1 0 0 0 0-2h-3z" fill="url(#lg1)"/>
        <!-- Right link -->
        <path d="M28 16a8 8 0 0 1 0 16h-3a1 1 0 0 1 0-2h3a6 6 0 0 0 0-12h-3a1 1 0 0 1 0-2h3z" fill="url(#lg2)"/>
        <!-- Center bar -->
        <rect x="18" y="22" width="12" height="4" rx="2" fill="url(#lg1)"/>
      </svg>
    </div>
    <span class="logo-name">ASOIINFO</span>
  </div>

  <!-- ─── CARD ─── -->
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

        <!-- Email -->
        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <input class="inp" type="email" name="email" value="{{ old('email') }}"
                 required autofocus autocomplete="email" placeholder="Correo electrónico">
        </div>

        <!-- Password -->
        <div class="field">
          <svg class="fi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          <input class="inp" id="pwd" type="password" name="password"
                 required autocomplete="current-password" placeholder="Contraseña"
                 style="padding-right:50px">
          <button type="button" class="eye" onclick="togglePwd()">
            <svg id="eyesvg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>

        <!-- Remember / Forgot -->
        <div class="chk-row">
          <label class="chk-lbl"><input type="checkbox" name="remember"> Recordarme</label>
          <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn">
          <span class="btn-label">Ingresar al sistema</span>
          <span class="btn-arrow">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
          </span>
        </button>
      </form>
    </div>

    <div class="cfoot">
      <p class="ftxt">¿No tienes cuenta?&nbsp;<a href="{{ route('register') }}" class="flnk">Crear cuenta →</a></p>
    </div>
  </div>

  <!-- ─── FEATURE PILLS — bigger icons ─── -->
  <div class="pills">

    <span class="pill pwa">
      <span class="pico" style="background:rgba(34,197,94,.14)">
        <svg viewBox="0 0 24 24" fill="#22c55e">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      </span>WhatsApp
    </span>

    <span class="pill pfac">
      <span class="pico" style="background:rgba(96,165,250,.14)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.7">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
        </svg>
      </span>Facturación
    </span>

    <span class="pill prep">
      <span class="pico" style="background:rgba(96,165,250,.14)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.7">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
      </span>Reportes
    </span>

    <span class="pill pcrm">
      <span class="pico" style="background:rgba(167,139,250,.14)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa" stroke-width="1.7">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </span>CRM
    </span>

  </div>

  <!-- COPYRIGHT -->
  <div class="copy">
    <p>
      © {{ date('Y') }} ASOIINFO. Todos los derechos reservados. &nbsp;·&nbsp;
      <svg fill="none" viewBox="0 0 24 24" stroke="#1e2535" stroke-width="2" style="width:13px;height:13px;flex-shrink:0">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      <span style="color:#1e2535">Seguridad y confianza</span>
    </p>
  </div>

</div>

<script>
/* ═══════════════════════════════════════════════
   CANVAS BACKGROUND — aurora + grid + stars
═══════════════════════════════════════════════ */
(function(){
  var c=document.getElementById('bg'),ctx=c.getContext('2d'),W,H,t=0;
  function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight}
  window.addEventListener('resize',resize);resize();

  /* Stars */
  var S=[];for(var i=0;i<200;i++)S.push({
    x:Math.random(),y:Math.random(),
    r:Math.random()*1.5+.3,
    a:Math.random()*.7+.2,
    sp:Math.random()*.025+.006,
    hue:Math.random()<.12?(Math.random()<.5?270:185):0,
    sat:Math.random()<.12?80:0
  });

  /* Aurora blobs — left purple, right teal */
  var B=[
    // Left column (purple/violet)
    {x:.11,y:.15,rx:.20,ry:.56,h:272,s:90,a:.88,d:.9},
    {x:.08,y:.42,rx:.14,ry:.40,h:268,s:86,a:.66,d:1.2},
    {x:.15,y:.70,rx:.11,ry:.30,h:275,s:82,a:.50,d:.7},
    {x:.22,y:.28,rx:.24,ry:.42,h:264,s:72,a:.30,d:1.5},
    // Right column (teal/cyan)
    {x:.89,y:.10,rx:.18,ry:.50,h:186,s:92,a:.82,d:.95},
    {x:.93,y:.36,rx:.13,ry:.36,h:183,s:88,a:.62,d:1.3},
    {x:.96,y:.64,rx:.10,ry:.28,h:188,s:84,a:.46,d:.75},
    {x:.82,y:.20,rx:.20,ry:.38,h:191,s:76,a:.28,d:1.6},
  ];

  function drawGrid(){
    var gy=H*.52,gh=H-gy;
    ctx.save();ctx.globalCompositeOperation='lighter';
    // vertical converging lines
    var vp={x:W/2,y:gy};
    for(var i=0;i<=28;i++){
      var bx=(i/28)*W;
      ctx.beginPath();ctx.moveTo(vp.x,vp.y);ctx.lineTo(bx,H);
      ctx.strokeStyle='rgba(140,50,255,.20)';ctx.lineWidth=.9;ctx.stroke();
    }
    // horizontal rows — exponential spacing
    for(var j=1;j<=18;j++){
      var ratio=Math.pow(j/18,1.7);
      var hy=gy+gh*ratio;
      var spread=.45+ratio*.55;
      var alpha=0.05+ratio*.28;
      ctx.beginPath();
      ctx.moveTo(vp.x-W*.85*spread,hy);ctx.lineTo(vp.x+W*.85*spread,hy);
      ctx.strokeStyle='rgba(140,50,255,'+alpha+')';ctx.lineWidth=.9;ctx.stroke();
    }
    ctx.restore();
  }

  function drawAurora(t){
    ctx.save();ctx.globalCompositeOperation='screen';
    B.forEach(function(b,i){
      var ox=Math.sin(t*.36+i*1.9)*.020*b.d;
      var oy=Math.cos(t*.26+i*2.4)*.013*b.d;
      var cx=(b.x+ox)*W,cy=(b.y+oy)*H;
      var rx=b.rx*W,ry=b.ry*H;
      var pulse=1+Math.sin(t*.52+i*1.2)*.07;
      var a=b.a*(0.86+Math.sin(t*.44+i*.95)*.14);
      var g=ctx.createRadialGradient(cx,cy,0,cx,cy,Math.max(rx,ry)*pulse);
      g.addColorStop(0,'hsla('+b.h+','+b.s+'%,65%,'+a+')');
      g.addColorStop(.36,'hsla('+b.h+','+b.s+'%,52%,'+(a*.50)+')');
      g.addColorStop(.70,'hsla('+b.h+','+b.s+'%,44%,'+(a*.16)+')');
      g.addColorStop(1,'hsla('+b.h+','+b.s+'%,38%,0)');
      ctx.save();
      ctx.translate(cx,cy);ctx.scale(1,ry/rx);ctx.translate(-cx,-cy);
      ctx.beginPath();ctx.arc(cx,cy,rx*pulse,0,Math.PI*2);
      ctx.fillStyle=g;
      ctx.filter='blur(24px)';
      ctx.fill();
      ctx.restore();
    });
    ctx.restore();
  }

  function drawStars(t){
    ctx.save();ctx.globalCompositeOperation='lighter';
    S.forEach(function(s){
      var fl=.5+.5*Math.sin(t*s.sp*62+s.x*88);
      var alpha=s.a*.65*fl+.12;
      ctx.beginPath();
      ctx.arc(s.x*W,s.y*H,s.r,0,Math.PI*2);
      ctx.fillStyle=s.sat>0
        ?'hsla('+s.hue+','+s.sat+'%,80%,'+alpha+')'
        :'rgba(255,255,255,'+alpha+')';
      ctx.fill();
    });
    ctx.restore();
  }

  function frame(ts){
    t=ts*.001;
    ctx.fillStyle='#05030f';ctx.fillRect(0,0,W,H);
    drawAurora(t);drawStars(t);drawGrid(t);
    requestAnimationFrame(frame);
  }
  requestAnimationFrame(frame);
})();

/* Eye toggle */
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
