{{--
    Sign-in / password pages, in the public site's theme.
    Sections: title, heading (HTML), lead, form
--}}
@php
    $nonce     = \Illuminate\Support\Facades\Vite::cspNonce();
    $brandName = $genSetting['site_name'] ?? $genSetting['name'] ?? 'Leamsoft';
    $logoUrl   = \App\Support\Ui::logoUrl($genSetting);
@endphp
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') | {{ config('seo.short_brand', 'Leamsoft') }}</title>

    <link rel="preload" href="{{ asset('assets/fonts/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/leamsoft.css') }}?v={{ @filemtime(public_path('assets/css/leamsoft.css')) }}">
    <script nonce="{{ $nonce }}" src="{{ asset('assets/js/leamsoft.js') }}?v={{ @filemtime(public_path('assets/js/leamsoft.js')) }}" defer></script>
    @if(!empty($genSetting['favicon']))
        <link rel="icon" type="image/png" href="{{ url('storage/' . $genSetting['favicon']) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
</head>
<body class="no-js">
<script nonce="{{ $nonce }}">document.body.classList.remove('no-js')</script>
@include('layouts.partials.icons')

<div class="auth">
    {{-- Brand side --}}
    <aside class="auth__side">
        <div class="hero__guides" aria-hidden="true"><div></div></div>

        <div class="auth__top">
            <a href="{{ url('/') }}" class="logo" aria-label="{{ $brandName }} home">
                @if($logoUrl)
                    <img class="logo__img" src="{{ $logoUrl }}" alt="{{ $brandName }}" height="36">
                @else
                    <span class="logo__mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16h11"/></svg></span>Leamsoft
                @endif
            </a>
        </div>

        <div class="auth__copy">
            <span class="label">Leamsoft portal</span>
            <h1>
                @hasSection('heading')
                    @yield('heading')
                @else
                    Welcome back. <span class="dim">Let’s get to work.</span>
                @endif
            </h1>
            <p class="lead">@yield('lead', 'Manage services, blogs, enquiries and site settings — everything that powers leamsoft.com, in one place.')</p>
        </div>

        {{-- Decorative preview, same language as the home page product shot --}}
        <div class="auth__preview" aria-hidden="true">
            <div class="frame__bar">
                <div class="frame__dots"><i></i><i></i><i></i></div>
                <div class="frame__url"><svg class="icon"><use href="#i-lock"/></svg>Client portal</div>
            </div>
            <div class="body">
                <div class="kpis">
                    <div><small>New enquiries</small><strong>12</strong><div class="bar"><i style="width:60%"></i></div></div>
                    <div><small>Published posts</small><strong>24</strong><div class="bar"><i style="width:80%"></i></div></div>
                    <div><small>Services</small><strong>36</strong><div class="bar"><i style="width:70%"></i></div></div>
                    <div><small>Uptime</small><strong>99.9%</strong><div class="bar"><i style="width:99%;background:var(--green)"></i></div></div>
                </div>
                <ul class="ms">
                    <li><span class="ck done"><svg><use href="#i-tick"/></svg></span>Enquiry from website form<span>2m</span></li>
                    <li><span class="ck done"><svg><use href="#i-tick"/></svg></span>Blog post published<span>1h</span></li>
                    <li><span class="ck now"></span>Service page draft<span>today</span></li>
                </ul>
            </div>
        </div>

        <div class="auth__foot">
            <span>© {{ date('Y') }} Leamsoft Pvt Ltd.</span>
            <span><a href="{{ url('privacy-policy') }}">Privacy</a> · <a href="{{ url('terms-condition') }}">Terms</a></span>
        </div>
    </aside>

    {{-- Form side --}}
    <main class="auth__main" id="main">
        <div class="auth__top">
            <a href="{{ url('/') }}" class="tlink" style="color:var(--muted);font-size:14px"><svg class="icon"><use href="#i-arrow-l"/></svg>Back to website</a>
        </div>
        <div class="auth__card">
            @yield('form')
            <p class="auth__secure"><svg class="icon"><use href="#i-shield"/></svg>Encrypted connection · Authorised staff only</p>
        </div>
    </main>
</div>
</body>
</html>
