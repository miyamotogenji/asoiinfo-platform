<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden;font-family:'Sora',sans-serif;color:#e2e8f0}

/* ══ BACKGROUND — exact reference image ══ */
body{
  background-image: url('{{ asset('bg-login.png') }}');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

/* Very subtle dark overlay to improve text contrast without hiding the BG */
body::before{
  content:'';
  position:fixed;inset:0;z-index:0;
  background:rgba(4,2,18,.18);
  pointer-events:none;
}

/* TOP ACCENT LINE */
.topline{
  position:fixed;top:0;left:0;right:0;height:2px;z-index:100;
  background:linear-gradient(90deg,transparent 0%,#7c3aed 18%,#a855f7 50%,#06b6d4 82%,transparent 100%);
  box-shadow:0 0 22px rgba(124,58,237,.9),0 0 55px rgba(168,85,247,.48);
}

/* ══ PAGE SHELL ══ */
.page{
  position:relative;z-index:10;
  min-height:100vh;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  padding:22px 16px 26px;
}

/* ══ LOGO PILL ══ */
.logo-pill{
  display:inline-flex;align-items:center;gap:12px;
  padding:9px 28px 9px 11px;
  border-radius:60px;
  background:rgba(5,3,18,.88);
  border:1.5px solid rgba(155,88,255,.75);
  box-shadow:
    0 0  15px rgba(155,88,255,.70),
    0 0  48px rgba(155,88,255,.32),
    0 0 100px rgba(155,88,255,.14),
    inset 0 1px 0 rgba(255,255,255,.07);
  margin-bottom:24px;
  animation:fadeUp .5s ease both;
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
}
/* The logo image uses mix-blend-mode:screen so the black bg becomes transparent */
.logo-pill img{
  height:30px;width:auto;display:block;
  mix-blend-mode:screen;
  filter:drop-shadow(0 0 10px rgba(155,88,255,.98)) brightness(1.15);
}
.logo-text{
  font-size:1.18rem;font-weight:800;color:#fff;
  letter-spacing:.09em;
  text-shadow:0 0 14px rgba(175,92,255,.65);
}

/* ══ CARD ══ */
.card{
  width:100%;max-width:436px;
  background:rgba(7,5,22,.82);
  border:1px solid rgba(72,58,148,.38);
  border-radius:22px;
  backdrop-filter:blur(60px);
  -webkit-backdrop-filter:blur(60px);
  box-shadow:
    inset 0 0 0 1px rgba(255,255,255,.04),
    inset 0 1px 0 rgba(255,255,255,.08),
    0 48px 96px rgba(0,0,0,.76),
    0 0 80px rgba(58,38,180,.10);
  overflow:hidden;
  animation:fadeUp .55s .08s ease both;
}
.cbody{padding:32px 36px 24px;text-align:center}
.cfoot{
  padding:14px 36px 18px;
  border-top:1px solid rgba(72,58,148,.22);
  text-align:center;
}

/* "A" gradient icon */
.a-icon{
  width:58px;height:58px;border-radius:17px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(148deg,#4d8ef8 0%,#5a5bdb 42%,#7b3aed 100%);
  box-shadow:0 8px 30px rgba(99,102,241,.60),inset 0 2px 0 rgba(255,255,255,.22);
  margin-bottom:16px;
  font-family:'Sora',sans-serif;font-size:1.72rem;font-weight:900;color:#fff;
  text-shadow:0 2px 8px rgba(0,0,0,.35);letter-spacing:-.04em;
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
  border:1.5px solid rgba(30,26,72,.98);
  border-radius:13px;
  padding:14.5px 15px 14.5px 45px;
  font-size:.965rem;color:#d1d5db;
  font-family:'Sora',sans-serif;
  outline:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
.inp::placeholder{color:#17202e}
.inp:focus{
  border-color:rgba(99,102,241,.55);
  background:rgba(2,1,14,1);
  box-shadow:0 0 0 3px rgba(99,102,241,.10);
}
.eye{
  position:absolute;right:13px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;padding:0;
  width:20px;height:20px;color:#22263a;
  display:flex;align-items:center;justify-content:center;
  transition:color .18s;
}
.eye:hover{color:#6366f1}
.eye svg{width:17px;height:17px}

/* Remember/Forgot */
.chk-row{display:flex;align-items:center;justify-content:space-between;margin-top:14px;text-align:left}
.chk-lbl{display:flex;align-items:center;gap:7px;font-size:.83rem;color:#22263a;cursor:pointer;user-select:none}
.chk-lbl input{width:14px;height:14px;cursor:pointer;accent-color:#6366f1}
.forgot{font-size:.82rem;color:#22263a;text-decoration:none;font-weight:500;transition:color .18s}
.forgot:hover{color:#818cf8}

/* Submit button */
.btn{
  width:100%;margin-top:18px;
  padding:15px 20px;border-radius:13px;border:none;cursor:pointer;
  font-family:'Sora',sans-serif;font-size:1.04rem;font-weight:700;color:#fff;
  letter-spacing:.016em;
  background:linear-gradient(93deg,#3b82f6 0%,#5a5be0 46%,#6264f0 100%);
  box-shadow:0 6px 28px rgba(99,102,241,.56),inset 0 1px 0 rgba(255,255,255,.16);
  position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;
}
.btn::after{content:'';position:absolute;inset:0;background:linear-gradient(93deg,transparent,rgba(255,255,255,.09) 50%,transparent);transform:translateX(-100%);transition:transform .55s}
.btn:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(99,102,241,.72)}
.btn:hover::after{transform:translateX(100%)}
.btn:active{transform:translateY(0)}

.ftxt{font-size:.87rem;color:#22263a}
.flnk{color:#818cf8;font-weight:600;text-decoration:none;transition:color .18s}
.flnk:hover{color:#c4b5fd}

/* ══ FEATURE PILLS ══ */
.pills{
  display:flex;flex-wrap:wrap;justify-content:center;gap:10px;
  margin-top:20px;
  animation:fadeUp .6s .27s ease both;
}
.pill{
  display:inline-flex;align-items:center;gap:9px;
  padding:9px 20px;border-radius:60px;
  background:rgba(6,4,20,.90);
  border:1.5px solid rgba(34,28,76,.96);
  backdrop-filter:blur(18px);
  -webkit-backdrop-filter:blur(18px);
  font-size:.81rem;font-weight:600;color:#374151;
  position:relative;transition:all .22s;cursor:default;white-space:nowrap;
}
.pill:hover{border-color:rgba(99,102,241,.35);color:#64748b;transform:translateY(-2px)}
.pill::after{content:'';position:absolute;top:-4px;right:-4px;width:10px;height:10px;border-radius:50%;border:2px solid rgba(5,3,16,.95)}
.pwa::after {background:#22c55e;box-shadow:0 0 8px #22c55e,0 0 18px rgba(34,197,94,.5)}
.pfac::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 18px rgba(96,165,250,.5)}
.prep::after{background:#60a5fa;box-shadow:0 0 8px #60a5fa,0 0 18px rgba(96,165,250,.5)}
.pcrm::after{background:#a78bfa;box-shadow:0 0 8px #a78bfa,0 0 18px rgba(167,139,250,.5)}
.pico{width:30px;height:30px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.pico svg{width:16px;height:16px}

/* ══ COPYRIGHT ══ */
.copy{margin-top:16px;text-align:center;animation:fadeUp .6s .39s ease both}
.copy p{font-size:.73rem;color:#111827;display:inline-flex;align-items:center;flex-wrap:wrap;justify-content:center;gap:5px}
.copy svg{width:12px;height:12px}

@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>

<div class="topline"></div>

<div class="page">

  <!-- LOGO PILL -->
  <div class="logo-pill">
    <img src="{{ asset('logo.png') }}" alt="ASOIINFO">
    <span class="logo-text">ASOIINFO</span>
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

      <form method="POST" action="{{ route('login.post') }}" style="margin-top:20px">
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
                 style="padding-right:46px">
          <button type="button" class="eye" onclick="togglePwd()">
            <svg id="eyesvg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>

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

  <!-- FEATURE PILLS -->
  <div class="pills">
    <span class="pill pwa">
      <span class="pico" style="background:rgba(34,197,94,.12)">
        <svg viewBox="0 0 24 24" fill="#22c55e"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      </span>
      WhatsApp
    </span>
    <span class="pill pfac">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
      </span>
      Facturación
    </span>
    <span class="pill prep">
      <span class="pico" style="background:rgba(96,165,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
      </span>
      Reportes
    </span>
    <span class="pill pcrm">
      <span class="pico" style="background:rgba(167,139,250,.12)">
        <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
      </span>
      CRM
    </span>
  </div>

  <!-- COPYRIGHT -->
  <div class="copy">
    <p>
      © {{ date('Y') }} ASOIINFO. Todos los derechos reservados.
      &nbsp;·&nbsp;
      <svg fill="none" viewBox="0 0 24 24" stroke="#1f2937" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      <span style="color:#1f2937">Seguridad y confianza</span>
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
