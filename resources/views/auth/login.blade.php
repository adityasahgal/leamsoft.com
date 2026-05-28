@extends('layouts.app')

@php
    $genSetting = \App\Models\Setting::first();
    $brandName = $genSetting->site_name ?? $genSetting->name ?? config('app.name', 'LEAMSOFT');
    $brandInitials = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($brandName, 0, 2));
    $hasLogo = ! empty($genSetting->logo) && file_exists('storage/' . $genSetting->logo);
@endphp

@section('content')
<style>
    :root {
        --ls-black: #0a0a0a;
        --ls-dark: #111;
        --ls-card: #161616;
        --ls-card2: #1c1c1c;
        --ls-border: rgba(255,255,255,0.08);
        --ls-muted: rgba(255,255,255,0.55);
        --ls-rainbow: linear-gradient(90deg, #ff3b5c, #ff8c00, #ffd700, #39d353, #00b4ff, #a855f7, #ff3b5c);
    }
    @keyframes ls-shift  { 0% { background-position: 0% } 100% { background-position: 200% } }
    @keyframes ls-fadeUp { from { opacity:0; transform: translateY(20px) } to { opacity:1; transform: translateY(0) } }
    @keyframes ls-pulse  { 0%,100% { opacity: 0.4 } 50% { opacity: 0.9 } }
    @keyframes ls-float  { 0%,100% { transform: translateY(0) } 50% { transform: translateY(-12px) } }

    body { margin: 0; }
    #app { background: var(--ls-black) !important; height: auto !important; min-height: 100vh; padding: 0 !important; justify-content: stretch !important; align-items: stretch !important; }
    #app main { padding: 0 !important; width: 100%; }

    .ls-login {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        font-family: 'Barlow', 'Nunito', sans-serif;
        color: #fff;
        background:
            radial-gradient(ellipse 50% 60% at 80% 20%, rgba(0,180,255,0.08), transparent 70%),
            radial-gradient(ellipse 50% 60% at 20% 90%, rgba(168,85,247,0.08), transparent 70%),
            var(--ls-black);
    }

    /* ─── LEFT BRAND PANEL ─── */
    .ls-brand-panel {
        position: relative;
        padding: 56px 64px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
        border-right: 1px solid var(--ls-border);
    }
    .ls-brand-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 50px 50px;
        -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black, transparent);
                mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black, transparent);
        pointer-events: none;
    }
    .ls-brand-panel > * { position: relative; z-index: 1; }

    .ls-brand-logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        animation: ls-fadeUp .6s ease both;
    }
    .ls-brand-logo-img { max-height: 48px; width: auto; display: block; }
    .ls-brand-logo-box {
        width: 44px; height: 44px;
        border-radius: 10px;
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .ls-brand-logo-box::before {
        content: '';
        position: absolute;
        inset: -2px;
        background: var(--ls-rainbow);
        background-size: 200%;
        animation: ls-shift 3s linear infinite;
        border-radius: 12px;
        z-index: 0;
    }
    .ls-brand-logo-box > span {
        position: relative;
        z-index: 1;
        width: 40px; height: 40px;
        border-radius: 7px;
        background: var(--ls-black);
        font-family: 'Bebas Neue', sans-serif;
        font-size: 18px;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .ls-brand-logo-text {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: 3px;
        background: var(--ls-rainbow);
        background-size: 200%;
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: ls-shift 4s linear infinite;
    }

    .ls-brand-headline {
        animation: ls-fadeUp .6s .15s ease both;
    }
    .ls-brand-eyebrow {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #00b4ff;
        margin-bottom: 16px;
    }
    .ls-brand-headline h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 4vw, 56px);
        line-height: 1;
        letter-spacing: 2px;
        margin: 0 0 18px;
        color: #fff;
    }
    .ls-brand-headline h1 .ls-rainbow {
        background: var(--ls-rainbow);
        background-size: 200%;
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: ls-shift 4s linear infinite;
    }
    .ls-brand-headline p {
        font-size: 15px;
        color: var(--ls-muted);
        line-height: 1.65;
        max-width: 460px;
        font-weight: 300;
        margin: 0;
    }

    .ls-brand-features {
        display: flex;
        flex-direction: column;
        gap: 14px;
        animation: ls-fadeUp .6s .3s ease both;
    }
    .ls-brand-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13.5px;
        color: rgba(255,255,255,0.75);
    }
    .ls-brand-feature i {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .ls-brand-foot {
        font-size: 12px;
        color: rgba(255,255,255,0.3);
        letter-spacing: 0.5px;
    }

    /* ─── RIGHT FORM PANEL ─── */
    .ls-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 56px 48px;
    }
    .ls-form-card {
        width: 100%;
        max-width: 440px;
        animation: ls-fadeUp .6s .2s ease both;
    }
    .ls-form-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 38px;
        letter-spacing: 2px;
        line-height: 1;
        margin: 0 0 8px;
        color: #fff;
    }
    .ls-form-sub {
        font-size: 14px;
        color: var(--ls-muted);
        margin: 0 0 28px;
        font-weight: 300;
    }

    .ls-field { margin-bottom: 18px; }
    .ls-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255,255,255,0.6);
        margin-bottom: 8px;
    }
    .ls-input-wrap { position: relative; }
    .ls-input-wrap > i.ls-ic {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.35);
        pointer-events: none;
        font-size: 14px;
    }
    .ls-input {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        padding: 14px 16px 14px 42px;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .ls-input:focus {
        border-color: #00b4ff;
        background: rgba(0,180,255,0.04);
        box-shadow: 0 0 0 3px rgba(0,180,255,0.12);
    }
    .ls-input.is-invalid {
        border-color: #ff3b5c;
        box-shadow: 0 0 0 3px rgba(255,59,92,0.12);
    }
    .ls-input::placeholder { color: rgba(255,255,255,0.3); }
    .ls-error {
        color: #ff6b85;
        font-size: 12px;
        margin-top: 6px;
        display: block;
    }

    .ls-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        font-size: 13px;
    }
    .ls-check {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--ls-muted);
        cursor: pointer;
        user-select: none;
    }
    .ls-check input {
        width: 16px; height: 16px;
        accent-color: #00b4ff;
        cursor: pointer;
    }
    .ls-link {
        color: #00b4ff;
        text-decoration: none;
        font-weight: 500;
    }
    .ls-link:hover { color: #fff; text-decoration: none; }

    .ls-btn {
        width: 100%;
        padding: 14px;
        border-radius: 10px;
        background: var(--ls-rainbow);
        background-size: 200%;
        animation: ls-shift 4s linear infinite;
        border: none;
        color: #000;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-family: inherit;
        cursor: pointer;
        transition: opacity .2s, transform .1s;
    }
    .ls-btn:hover { opacity: 0.92; }
    .ls-btn:active { transform: translateY(1px); }

    .ls-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 26px 0 22px;
        color: rgba(255,255,255,0.3);
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .ls-divider::before, .ls-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.1);
    }

    .ls-back {
        text-align: center;
        font-size: 13px;
        color: var(--ls-muted);
    }
    .ls-back a { color: #00b4ff; text-decoration: none; font-weight: 500; }
    .ls-back a:hover { color: #fff; }

    /* Decorative floating orbs */
    .ls-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.18;
        animation: ls-float 6s ease-in-out infinite;
        pointer-events: none;
    }
    .ls-orb-1 { width: 220px; height: 220px; background: #00b4ff; top: 20%; right: -60px; }
    .ls-orb-2 { width: 260px; height: 260px; background: #a855f7; bottom: 10%; left: -80px; animation-delay: 1.5s; }
    .ls-orb-3 { width: 160px; height: 160px; background: #ff3b5c; top: 60%; right: 30%; animation-delay: 3s; }

    @media (max-width: 900px) {
        .ls-login { grid-template-columns: 1fr; }
        .ls-brand-panel { padding: 40px 28px; border-right: none; border-bottom: 1px solid var(--ls-border); min-height: auto; }
        .ls-brand-headline h1 { font-size: 36px; }
        .ls-brand-features { display: none; }
        .ls-form-panel { padding: 40px 24px; }
    }
</style>

<div class="ls-login">
    {{-- LEFT BRAND PANEL --}}
    <div class="ls-brand-panel">
        <div class="ls-orb ls-orb-1"></div>
        <div class="ls-orb ls-orb-2"></div>
        <div class="ls-orb ls-orb-3"></div>

        <a href="{{ url('/') }}" class="ls-brand-logo">
            @if($hasLogo)
                <img src="{{ url('storage/' . $genSetting->logo) }}" alt="{{ $brandName }}" class="ls-brand-logo-img">
            @else
                <span class="ls-brand-logo-box"><span>{{ $brandInitials }}</span></span>
                <span class="ls-brand-logo-text">{{ $brandName }}</span>
            @endif
        </a>

        <div class="ls-brand-headline">
            <div class="ls-brand-eyebrow">Admin Console</div>
            <h1>
                Welcome <span class="ls-rainbow">Back</span><br>
                To Your Workspace
            </h1>
            <p>Sign in to manage your site — categories, services, blogs, gallery, banners, enquiries, and settings — all in one place.</p>
        </div>

        <div class="ls-brand-features">
            <div class="ls-brand-feature"><i class="fas fa-shield-alt"></i> Secure role-based access &amp; permissions</div>
            <div class="ls-brand-feature"><i class="fas fa-bolt"></i> Manage AI, Blockchain &amp; Cloud services</div>
            <div class="ls-brand-feature"><i class="fas fa-chart-line"></i> Real-time enquiry dashboard</div>
        </div>

        <div class="ls-brand-foot">© {{ date('Y') }} {{ $brandName }}. All rights reserved.</div>
    </div>

    {{-- RIGHT FORM PANEL --}}
    <div class="ls-form-panel">
        <div class="ls-form-card">
            <h2 class="ls-form-title">Sign In</h2>
            <p class="ls-form-sub">Enter your credentials to access the admin panel.</p>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="ls-field">
                    <label for="email" class="ls-label">{{ __('Email Address') }}</label>
                    <div class="ls-input-wrap">
                        <i class="ls-ic fas fa-envelope"></i>
                        <input id="email"
                               type="email"
                               class="ls-input @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus
                               placeholder="you@company.com">
                    </div>
                    @error('email')
                        <span class="ls-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ls-field">
                    <label for="password" class="ls-label">{{ __('Password') }}</label>
                    <div class="ls-input-wrap">
                        <i class="ls-ic fas fa-lock"></i>
                        <input id="password"
                               type="password"
                               class="ls-input @error('password') is-invalid @enderror"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="ls-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ls-row">
                    <label class="ls-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('Remember me') }}</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a class="ls-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="ls-btn">
                    {{ __('Sign In') }} <span style="margin-left:6px;">↗</span>
                </button>
            </form>

            <div class="ls-divider"><span>or</span></div>

            <div class="ls-back">
                <a href="{{ url('/') }}">← Back to website</a>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&display=swap">
@endsection
