<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    @php
        // Pages pass a $seo array (built by App\Support\Seo). Anything that
        // still uses the old @section('meta_*') approach keeps working via
        // the yieldContent fallbacks below.
        $seo = $seo ?? \App\Support\Seo::page('home');

        $seoTitle = trim($__env->yieldContent('meta_title')) ?: $seo['title'];
        $seoDesc  = trim($__env->yieldContent('meta_description')) ?: $seo['description'];
        $seoKeys  = trim($__env->yieldContent('meta_keywords'))
            ?: implode(', ', $seo['keywords'] ?? []);
        $nonce    = \Illuminate\Support\Facades\Vite::cspNonce();
        $jsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG;
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="{{ $seoKeys }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <meta name="author" content="{{ config('seo.brand') }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    <link rel="alternate" hreflang="en-IN" href="{{ $seo['canonical'] }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seo['canonical'] }}">
    <link rel="alternate" type="application/rss+xml" title="{{ config('seo.short_brand') }} blog" href="{{ url('feed.xml') }}">

    {{-- Fastest path to first paint: font + stylesheet, both same-origin --}}
    <link rel="preload" href="{{ asset('assets/fonts/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/leamsoft.css') }}?v={{ @filemtime(public_path('assets/css/leamsoft.css')) }}">
    <script nonce="{{ $nonce }}" src="{{ asset('assets/js/leamsoft.js') }}?v={{ @filemtime(public_path('assets/js/leamsoft.js')) }}" defer></script>
    @stack('styles')
    @stack('head')

    {{-- Local / geo targeting --}}
    <meta name="geo.region" content="{{ config('seo.geo.region') }}">
    <meta name="geo.placename" content="{{ config('seo.geo.placename') }}">
    <meta name="geo.position" content="{{ config('seo.geo.latitude') }};{{ config('seo.geo.longitude') }}">
    <meta name="ICBM" content="{{ config('seo.geo.latitude') }}, {{ config('seo.geo.longitude') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:site_name" content="{{ config('seo.brand') }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    @if(!empty($seo['image_width']))
        <meta property="og:image:width" content="{{ $seo['image_width'] }}">
        <meta property="og:image:height" content="{{ $seo['image_height'] }}">
    @endif
    <meta property="og:image:alt" content="{{ $seo['image_alt'] ?? $seoTitle }}">
    <meta property="og:locale" content="en_IN">
    @if(!empty($seo['published_time']))
        <meta property="article:published_time" content="{{ $seo['published_time'] }}">
        <meta property="article:modified_time" content="{{ $seo['modified_time'] }}">
        <meta property="article:publisher" content="{{ url('/') }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">
    <meta name="twitter:image:alt" content="{{ $seo['image_alt'] ?? $seoTitle }}">
    @if(config('seo.twitter_handle'))
        <meta name="twitter:site" content="{{ config('seo.twitter_handle') }}">
    @endif

    {{-- Structured data --}}
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::organizationSchema($genSetting), $jsonFlags) !!}</script>
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::websiteSchema(), $jsonFlags) !!}</script>
    @if(!empty($seo['breadcrumbs']))
        <script type="application/ld+json">{!! json_encode(\App\Support\Seo::breadcrumbSchema($seo['breadcrumbs']), $jsonFlags) !!}</script>
    @endif
    @stack('schema')

    @yield('meta')
    @if(!empty($genSetting) && !empty($genSetting['favicon']))
        <link rel="icon" type="image/png" href="{{ url('storage/' . $genSetting['favicon']) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
</head>

<body class="no-js">
<script nonce="{{ $nonce }}">document.body.classList.remove('no-js')</script>

@include('layouts.partials.icons')

<a class="skip" href="#main">Skip to content</a>

@include('layouts.frontendHeader')

<main id="main">
    @yield('content')
</main>

@include('layouts.frontendFooter')

@if(!empty($genSetting['phone']))
    <a class="wa" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $genSetting['phone']) }}" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
        <svg aria-hidden="true"><use href="#i-wa"/></svg><span>Chat with us</span>
    </a>
@endif

@stack('scripts')
</body>
</html>
