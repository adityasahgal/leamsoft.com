<?php
$genSetting = \App\Models\Setting::first();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', config('app.name', 'LEAMSOFT'))</title>
    <meta name="description" content="@yield('meta_description', 'LEAMSOFT — Empowering Business with Smart Technology')" />
    <meta name="keywords" content="@yield('meta_keywords', 'LEAMSOFT, software, web development, AI, cloud, cyber security')">

    @yield('meta')
    @if(!empty($genSetting) && !empty($genSetting['favicon']))
        <link rel="icon" type="image/png" href="{{ url('storage/' . $genSetting['favicon']) }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.min.css') }}" />
    <link href="{{ url('assets/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <style>
        /* ────────────────────────────────────────────
           LEAMSOFT GLOBAL THEME
           ──────────────────────────────────────────── */
        :root {
            --black: #0a0a0a;
            --dark: #111111;
            --card: #161616;
            --card2: #1c1c1c;
            --border: rgba(255,255,255,0.08);
            --border-strong: rgba(255,255,255,0.14);
            --white: #ffffff;
            --muted: rgba(255,255,255,0.55);
            --muted2: rgba(255,255,255,0.35);
            --r: #ff3b5c;
            --o: #ff8c00;
            --y: #ffd700;
            --g: #39d353;
            --b: #00b4ff;
            --v: #a855f7;
            --rainbow: linear-gradient(90deg, #ff3b5c, #ff8c00, #ffd700, #39d353, #00b4ff, #a855f7, #ff3b5c);
            --rainbow2: linear-gradient(135deg, #ff3b5c 0%, #ff8c00 20%, #ffd700 40%, #39d353 60%, #00b4ff 80%, #a855f7 100%);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Barlow', sans-serif !important;
            background: var(--black) !important;
            color: var(--white) !important;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        a { color: inherit; }
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: var(--black); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Animations */
        @keyframes shift { 0%{background-position:0%} 100%{background-position:200%} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes pulse-ring { 0%{transform:scale(1);opacity:0.6} 100%{transform:scale(1.6);opacity:0} }
        @keyframes spinSlow { from{transform:rotate(0)} to{transform:rotate(360deg)} }

        /* Rainbow utilities */
        .rainbow-text {
            background: var(--rainbow);
            background-size: 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shift 4s linear infinite;
        }
        .rainbow-divider {
            height: 2px;
            background: var(--rainbow);
            background-size: 200%;
            animation: shift 4s linear infinite;
        }

        /* Generic sections / containers */
        .leam-section { padding: 90px 24px; position: relative; }
        .leam-container { max-width: 1280px; margin: 0 auto; }
        .leam-section-label {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #00b4ff;
            margin-bottom: 14px;
        }
        .leam-section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(36px, 5vw, 58px);
            letter-spacing: 1.5px;
            line-height: 1;
            margin-bottom: 20px;
            color: #fff;
        }
        .leam-section-sub {
            font-size: 16px;
            color: var(--muted);
            max-width: 580px;
            line-height: 1.7;
            font-weight: 300;
        }
        .leam-section-head { text-align: center; margin-bottom: 64px; }
        .leam-section-head .leam-section-sub { margin: 0 auto; }

        /* Buttons */
        .leam-btn {
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Barlow', sans-serif;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }
        .leam-btn-primary {
            background: var(--rainbow);
            background-size: 300%;
            animation: shift 4s linear infinite;
            color: #000;
        }
        .leam-btn-primary:hover { opacity: 0.92; color: #000; text-decoration: none; }
        .leam-btn-ghost {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.2);
            color: #fff;
        }
        .leam-btn-ghost:hover { border-color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.05); color: #fff; text-decoration: none; }
        .leam-btn-lg { padding: 14px 32px; font-size: 15px; }

        /* Override Bootstrap default whites/forms */
        .modal-content { background: var(--card); color: #fff; border: 1px solid var(--border); }
        .modal-header, .modal-footer { border-color: var(--border); }
        input, textarea, select { color-scheme: dark; }
        .form-control, .form-select {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(0,180,255,0.04);
            border-color: #00b4ff;
            box-shadow: 0 0 0 .15rem rgba(0,180,255,0.15);
            color: #fff;
        }
        .form-control::placeholder { color: var(--muted2); }

        /* ─── STICKY SOCIAL ─── */
        .stricky_social {
            position: fixed;
            z-index: 99;
            bottom: 24px;
            right: 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 6px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
        }
        .stricky_social > .icon {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .stricky_social > .icon > a {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: var(--muted);
            transition: all .2s;
            text-decoration: none;
        }
        .stricky_social > .icon > a:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .stricky_social > .icon > .mail:hover { color: #4285F4; }
        .stricky_social > .icon > .youtube:hover { color: #f00000; }
        .stricky_social > .icon > .instagram:hover { color: #e1306c; }
        .stricky_social > .icon > .twitter:hover { color: #fff; }
        .stricky_social > .icon > .whatsapp:hover { color: #25D366; }
        .stricky_social > .icon > .linkedin:hover { color: #0077B5; }
        .stricky_social > .icon > .facebook:hover { color: #1877F2; }

        @media (max-width: 768px) {
            .stricky_social {
                left: 0;
                right: 0;
                bottom: 0;
                border-radius: 12px 12px 0 0;
                border-bottom: none;
                padding: 8px;
            }
            .stricky_social > .icon {
                flex-direction: row;
                justify-content: center;
                gap: 6px;
            }
        }

        /* Hide leftover Bootstrap white backgrounds */
        .bg-white, .bg-light { background: transparent !important; color: inherit !important; }
        .text-dark { color: #fff !important; }
        .text-white-50 { color: var(--muted) !important; }
    </style>
</head>

<body>
    <div class="stricky_social">
        <div class="icon">
            @if(!empty($genSetting['email']))
                <a href="mailto:{{ $genSetting['email'] }}" class="mail" title="Email"><i class="fa fa-envelope"></i></a>
            @endif
            @if(!empty($genSetting['facebook']))
                <a href="{{ $genSetting['facebook'] }}" class="facebook" target="_blank" rel="noopener" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
            @endif
            @if(!empty($genSetting['phone']))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $genSetting['phone']) }}" class="whatsapp" target="_blank" rel="noopener" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
            @endif
            @if(!empty($genSetting['linkedin']))
                <a href="{{ $genSetting['linkedin'] }}" class="linkedin" target="_blank" rel="noopener" title="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
            @endif
            @if(!empty($genSetting['twitter']))
                <a href="{{ $genSetting['twitter'] }}" class="twitter" target="_blank" rel="noopener" title="X"><i class="fa-brands fa-x-twitter"></i></a>
            @endif
            @if(!empty($genSetting['instagram']))
                <a href="{{ $genSetting['instagram'] }}" class="instagram" target="_blank" rel="noopener" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
            @endif
            @if(!empty($genSetting['youtube']))
                <a href="{{ $genSetting['youtube'] }}" class="youtube" target="_blank" rel="noopener" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
            @endif
        </div>
    </div>

    @include('layouts.frontendHeader')

    <main>
        @yield('content')
    </main>

    @include('layouts.frontendFooter')

    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    <span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span>
</body>
</html>
