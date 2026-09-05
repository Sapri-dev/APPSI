<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator — APPSI</title>
    <link rel="icon" type="image/png" href="{{ $appsiEmblem ?? asset('images/Logo-appsi-emblem.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(160deg, #030d28 0%, #071640 60%, #0c2256 100%);
        }

        /* ── Card ── */
        .card {
            display: flex;
            width: 100%;
            max-width: 860px;
            min-height: 520px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,.5);
            background: rgba(7,22,64,.78);
            border: 1px solid rgba(255,255,255,.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* ── Left panel ── */
        .panel-left {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 42%;
            padding: 48px 40px;
            background:
                radial-gradient(ellipse at 15% 15%, rgba(245,158,11,.16) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 85%, rgba(29,53,117,.45) 0%, transparent 55%),
                linear-gradient(160deg, #030d28 0%, #0c2256 50%, #030d28 100%);
            background-image:
                radial-gradient(circle, rgba(255,255,255,.055) 1px, transparent 1px),
                radial-gradient(ellipse at 15% 15%, rgba(245,158,11,.16) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 85%, rgba(29,53,117,.45) 0%, transparent 55%),
                linear-gradient(160deg, #030d28 0%, #0c2256 50%, #030d28 100%);
            background-size: 28px 28px, auto, auto, auto;
            border-right: 1px solid rgba(255,255,255,.06);
            position: relative;
        }
        @media (min-width: 640px) {
            .panel-left { display: flex; }
        }

        .panel-logo {
            display: flex;
            align-items: center;
        }
        .emblem-wrap {
            width: 84px;
            height: 84px;
            border-radius: 20px;
            background: #ffffff;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0,0,0,.35);
        }
        .emblem-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .panel-body { }
        .panel-accent {
            width: 36px;
            height: 3px;
            border-radius: 2px;
            background: linear-gradient(90deg, #f59e0b, transparent);
            margin-bottom: 20px;
        }
        .panel-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 10px;
        }
        .panel-title span {
            background: linear-gradient(135deg, #f59e0b, #fbbf24, #fcd34d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .panel-sub {
            font-size: .8125rem;
            color: #6b85c4;
            line-height: 1.6;
        }

        .panel-footer {
            font-size: .6875rem;
            color: rgba(107,133,196,.5);
        }

        /* ── Right panel ── */
        .panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
        }

        /* mobile logo */
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        /* Mobile emblem */
        .mobile-emblem-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #fff;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
            flex-shrink: 0;
        }
        .mobile-emblem-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        .mobile-logo-name { font-size: .875rem; font-weight: 700; color: #fff; }
        .mobile-logo-sub  { font-size: .6875rem; color: #6b85c4; }
        @media (min-width: 640px) { .mobile-logo { display: none; } }

        /* heading */
        .form-heading { margin-bottom: 28px; }
        .form-heading h1 { font-size: 1.375rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .form-heading p  { font-size: .8125rem; color: #6b85c4; }

        /* alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(244,63,94,.08);
            border: 1px solid rgba(244,63,94,.25);
            color: #fda4af;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: .8125rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .alert svg { flex-shrink: 0; width: 15px; height: 15px; margin-top: 2px; }

        /* form */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: .6875rem;
            font-weight: 700;
            color: #8b9cbf;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 7px;
        }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            font-size: .875rem;
            font-family: inherit;
            background: rgba(3,13,40,.7);
            border: 1.5px solid rgba(255,255,255,.1);
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input::placeholder { color: #3d5080; }
        .form-input:focus {
            border-color: rgba(245,158,11,.5);
            box-shadow: 0 0 0 3px rgba(245,158,11,.08);
        }
        .pw-wrap { position: relative; }
        .pw-wrap .form-input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #4a5f87;
            display: flex;
            align-items: center;
            padding: 0;
            transition: color .2s;
        }
        .pw-toggle:hover { color: #f59e0b; }

        /* remember */
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }
        .remember input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: #f59e0b;
            cursor: pointer;
            flex-shrink: 0;
        }
        .remember-label {
            font-size: .8125rem;
            color: #6b85c4;
            cursor: pointer;
            user-select: none;
        }

        /* button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            font-size: .875rem;
            font-weight: 700;
            font-family: inherit;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #030d28;
            letter-spacing: .02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(245,158,11,.25);
            transition: transform .2s, box-shadow .2s, filter .2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(245,158,11,.38);
            filter: brightness(1.05);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* back link */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 22px;
            font-size: .75rem;
            color: #4a5f87;
            text-decoration: none;
            transition: color .2s;
        }
        .back-link:hover { color: #d9e3f9; }
    </style>
</head>
<body>

<div class="card">

    <!-- Left panel -->
    <div class="panel-left">
        <div class="panel-logo">
            <div class="emblem-wrap">
                <img src="{{ $appsiEmblem ?? asset('images/Logo-appsi-emblem.png') }}" alt="Logo APPSI">
            </div>
        </div>

        <div class="panel-body">
            <div class="panel-accent"></div>
            <h2 class="panel-title">
                Portal<br>
                <span>Administrator</span>
            </h2>
            <p class="panel-sub">
                Asosiasi Pemerintah Provinsi<br>Seluruh Indonesia
            </p>
        </div>

        <div></div>
    </div>

    <!-- Right panel -->
    <div class="panel-right">

        <!-- Mobile logo -->
        <div class="mobile-logo">
            <div class="mobile-emblem-wrap">
                <img src="{{ $appsiEmblem ?? asset('images/Logo-appsi-emblem.png') }}" alt="Logo APPSI">
            </div>
            <div>
                <div class="mobile-logo-name">APPSI</div>
                <div class="mobile-logo-sub">Portal Administrator</div>
            </div>
        </div>

        <!-- Heading -->
        <div class="form-heading">
            <h1>Masuk</h1>
            <p>Silakan login dengan akun administrator Anda</p>
        </div>

        <!-- Alerts -->
        @if(session('error'))
        <div class="alert">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                       class="form-input"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email"
                       required autofocus autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="pw-wrap">
                    <input type="password" id="password" name="password"
                           class="form-input"
                           placeholder="Masukkan password"
                           required autocomplete="current-password">
                    <button type="button" class="pw-toggle" id="pwToggle" aria-label="Tampilkan password">
                        <svg id="eyeShow" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeHide" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" class="remember-label">Ingat saya</label>
            </div>

            <button type="submit" class="btn-submit">
                <span>Masuk</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </form>

        <a href="{{ url('/') }}" class="back-link">← Kembali ke halaman utama</a>
    </div>
</div>

<script>
    const pwToggle = document.getElementById('pwToggle');
    const pwInput  = document.getElementById('password');
    const eyeShow  = document.getElementById('eyeShow');
    const eyeHide  = document.getElementById('eyeHide');

    pwToggle.addEventListener('click', () => {
        const hidden = pwInput.type === 'password';
        pwInput.type = hidden ? 'text' : 'password';
        eyeShow.style.display = hidden ? 'none' : '';
        eyeHide.style.display = hidden ? ''     : 'none';
    });
</script>
</body>
</html>
