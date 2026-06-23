<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Cuenta — ASOIINFO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'Sora',system-ui,sans-serif;background:#07061a;color:#e2e8f0;overflow-x:hidden}

.bg-space{position:fixed;inset:0;z-index:0;background:radial-gradient(ellipse 140% 80% at 50% -8%,#160d38 0%,#07061a 55%)}
.aurora-l{position:fixed;z-index:1;left:-4%;top:-12%;width:38%;height:100%;background:radial-gradient(ellipse 70% 85% at 28% 28%,rgba(130,40,240,.72) 0%,rgba(90,20,190,.28) 52%,transparent 74%),radial-gradient(ellipse 40% 60% at 14% 55%,rgba(168,40,220,.38) 0%,transparent 65%);filter:blur(52px);animation:aL 15s ease-in-out infinite alternate}
.aurora-r{position:fixed;z-index:1;right:-6%;top:-8%;width:34%;height:88%;background:radial-gradient(ellipse 70% 80% at 72% 22%,rgba(0,220,210,.45) 0%,rgba(0,170,190,.18) 52%,transparent 74%),radial-gradient(ellipse 35% 52% at 88% 60%,rgba(0,180,200,.28) 0%,transparent 62%);filter:blur(56px);animation:aR 18s ease-in-out infinite alternate}
@keyframes aL{0%{transform:translateX(-18px);opacity:.78}100%{transform:translateX(20px);opacity:1}}
@keyframes aR{0%{transform:translateX(20px);opacity:.82}100%{transform:translateX(-16px);opacity:.65}}
.stars{position:fixed;inset:0;z-index:2;pointer-events:none;background-image:radial-gradient(1.6px 1.6px at 11% 8%,rgba(255,255,255,.95) 0%,transparent 100%),radial-gradient(1px 1px at 79% 14%,rgba(255,255,255,.7) 0%,transparent 100%),radial-gradient(1.6px 1.6px at 36% 5%,rgba(255,255,255,.85) 0%,transparent 100%),radial-gradient(2px 2px at 53% 17%,rgba(190,130,255,.95) 0%,transparent 100%),radial-gradient(2px 2px at 84% 57%,rgba(100,130,255,.95) 0%,transparent 100%),radial-gradient(1.8px 1.8px at 19% 27%,rgba(0,220,200,.85) 0%,transparent 100%),radial-gradient(1.4px 1.4px at 71% 21%,rgba(255,255,255,.65) 0%,transparent 100%);animation:twinkle 9s ease-in-out infinite alternate}
@keyframes twinkle{0%,100%{opacity:1}48%{opacity:.42}}
.grid-floor{position:fixed;bottom:0;left:-10%;right:-10%;height:50%;z-index:2;background-image:linear-gradient(rgba(120,60,255,.22) 1px,transparent 1px),linear-gradient(90deg,rgba(120,60,255,.22) 1px,transparent 1px);background-size:52px 52px;transform:perspective(380px) rotateX(72deg);transform-origin:bottom center;mask-image:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 68%);-webkit-mask-image:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 68%)}
.accent-line{position:fixed;top:0;left:0;right:0;height:2px;z-index:50;background:linear-gradient(90deg,transparent 0%,#7c3aed 22%,#a855f7 50%,#06b6d4 80%,transparent 100%);box-shadow:0 0 24px rgba(124,58,237,.85),0 0 52px rgba(168,85,247,.45)}

.page{position:relative;z-index:10;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:28px 16px}

/* Logo pill */
.logo-pill{display:inline-flex;align-items:center;gap:13px;padding:9px 26px 9px 12px;border-radius:50px;background:rgba(6,4,22,.85);border:1.5px solid rgba(140,80,255,.65);box-shadow:0 0 18px rgba(140,80,255,.55),0 0 60px rgba(140,80,255,.22),inset 0 1px 0 rgba(255,255,255,.07);margin-bottom:26px;animation:fadeUp .55s ease both;backdrop-filter:blur(22px)}
.logo-pill img{height:32px;width:auto;mix-blend-mode:screen;filter:drop-shadow(0 0 10px rgba(150,80,255,.9))}
.logo-pill-name{font-size:1.2rem;font-weight:800;color:#fff;letter-spacing:.08em;text-shadow:0 0 18px rgba(168,85,247,.55)}

/* Card */
.card{width:100%;max-width:446px;background:rgba(6,5,22,.82);border:1px solid rgba(70,55,150,.4);border-radius:22px;backdrop-filter:blur(52px);-webkit-backdrop-filter:blur(52px);box-shadow:inset 0 0 0 1px rgba(255,255,255,.04),inset 0 1px 0 rgba(255,255,255,.07),0 40px 80px rgba(0,0,0,.72);animation:fadeUp .6s .1s ease both;overflow:hidden}
.card-body{padding:32px 36px 24px}
.card-foot{padding:16px 36px 20px;border-top:1px solid rgba(70,55,150,.22);text-align:center}

.app-icon{width:56px;height:56px;border-radius:16px;background:linear-gradient(145deg,#4e8ef7 0%,#5b5bd6 48%,#7c3aed 100%);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 28px rgba(99,102,241,.55),inset 0 2px 0 rgba(255,255,255,.18)}
.app-icon svg{width:28px;height:28px;color:#fff}
.card-title{font-size:1.7rem;font-weight:800;color:#f8fafc;letter-spacing:-.042em;text-align:center;line-height:1.15}
.card-sub{font-size:.875rem;color:#374151;margin-top:7px;text-align:center;line-height:1.55}

.alert{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;border-radius:12px;margin-top:16px;font-size:.88rem;line-height:1.45}
.alert svg{width:18px;height:18px;flex-shrink:0}
.alert-err{background:rgba(127,29,29,.2);border:1px solid rgba(239,68,68,.28);color:#fca5a5}

.field{margin-top:16px;position:relative}
.field-icon{position:absolute;left:15px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#2a3048;pointer-events:none}
.inp{width:100%;background:rgba(2,2,12,.92);border:1.5px solid rgba(35,30,80,.95);border-radius:13px;padding:14px 16px 14px 46px;font-size:.975rem;color:#d1d5db;font-family:'Sora',system-ui,sans-serif;outline:none;transition:all .22s}
.inp::placeholder{color:#1a2030}
.inp:focus{border-color:rgba(99,102,241,.58);background:rgba(2,2,14,1);box-shadow:0 0 0 3px rgba(99,102,241,.11)}

/* Strength bar */
.strength-bar{height:3px;border-radius:3px;margin-top:8px;background:rgba(30,30,60,.8);overflow:hidden;transition:all .3s}
.strength-fill{height:100%;width:0;border-radius:3px;transition:all .4s}
.strength-hint{font-size:.72rem;color:#374151;margin-top:5px}

/* Match indicator */
.match-hint{font-size:.72rem;margin-top:5px}
.match-ok{color:#22c55e}
.match-no{color:#ef4444}

.btn-submit{width:100%;margin-top:20px;padding:15.5px 24px;border-radius:13px;background:linear-gradient(95deg,#3d82f6 0%,#5b5bd6 46%,#6366f1 100%);border:none;cursor:pointer;font-family:'Sora',system-ui,sans-serif;font-size:1.04rem;font-weight:700;color:#fff;letter-spacing:.015em;box-shadow:0 6px 30px rgba(99,102,241,.55),inset 0 1px 0 rgba(255,255,255,.14);transition:all .22s}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 14px 44px rgba(99,102,241,.72)}
.btn-submit:active{transform:translateY(0)}

.f-txt{font-size:.875rem;color:#2d3748}
.f-link{color:#818cf8;font-weight:600;text-decoration:none;transition:color .15s}
.f-link:hover{color:#c4b5fd}

@keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}
</style>
</head>
<body>
<div class="bg-space"></div>
<div class="aurora-l"></div>
<div class="aurora-r"></div>
<div class="stars"></div>
<div class="grid-floor"></div>
<div class="accent-line"></div>

<div class="page">

    <div class="logo-pill">
        <img src="{{ asset('logo.png') }}" alt="ASOIINFO">
        <span class="logo-pill-name">ASOIINFO</span>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="app-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="card-title">Crear cuenta</h1>
            <p class="card-sub">Regístrate para acceder a la plataforma<br>de gestión empresarial.</p>

            @if($errors->any())
            <div class="alert alert-err">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <input class="inp" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nombre completo">
                </div>
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input class="inp" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo electrónico">
                </div>
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input class="inp" type="password" id="pwd1" name="password" required autocomplete="new-password" placeholder="Contraseña" oninput="checkStrength(this.value)">
                    <div class="strength-bar"><div class="strength-fill" id="sfill"></div></div>
                    <div class="strength-hint" id="shint"></div>
                </div>
                <div class="field">
                    <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <input class="inp" type="password" id="pwd2" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar contraseña" oninput="checkMatch()">
                    <div class="match-hint" id="mhint"></div>
                </div>
                <button type="submit" class="btn-submit">Crear cuenta →</button>
            </form>
        </div>
        <div class="card-foot">
            <p class="f-txt">¿Ya tienes cuenta?&nbsp;<a href="{{ route('login') }}" class="f-link">Iniciar sesión →</a></p>
        </div>
    </div>

</div>

<script>
function checkStrength(v){
    var f=document.getElementById('sfill'),h=document.getElementById('shint');
    var s=0;if(v.length>=8)s++;if(/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^A-Za-z0-9]/.test(v))s++;
    var c=['#ef4444','#f59e0b','#10b981','#6366f1'],l=['Muy débil','Débil','Buena','Fuerte'];
    f.style.width=(s/4*100)+'%';f.style.background=c[s-1]||'transparent';
    h.textContent=s>0?l[s-1]:'';h.style.color=c[s-1]||'#374151';
}
function checkMatch(){
    var a=document.getElementById('pwd1').value,b=document.getElementById('pwd2').value,m=document.getElementById('mhint');
    if(!b){m.textContent='';return;}
    if(a===b){m.textContent='✓ Las contraseñas coinciden';m.className='match-hint match-ok';}
    else{m.textContent='✗ Las contraseñas no coinciden';m.className='match-hint match-no';}
}
</script>
</body>
</html>
