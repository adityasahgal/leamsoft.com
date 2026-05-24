@extends('layouts.master')
@php
$meta_title = "Our Services | LEAMSOFT — Smart Technology Solutions";
$meta_description = "Explore LEAMSOFT's full range of IT services — software development, AI, cloud, cyber security, digital marketing, and consulting.";
$keywords = "leamsoft services, IT services, software development, AI, cloud, cyber security";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta_keywords'){{ $keywords }}@stop
@section('content')
<style>
    .leam-page-banner {
        padding: 90px 24px 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-page-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0,180,255,0.12) 0%, transparent 70%),
                    radial-gradient(ellipse 40% 40% at 30% 100%, rgba(168,85,247,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-page-banner h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(48px, 7vw, 84px);
        letter-spacing: 2px;
        line-height: 1;
        margin: 0;
        position: relative;
        z-index: 1;
        color: #fff;
    }
    .leam-page-banner p {
        position: relative;
        z-index: 1;
        max-width: 580px;
        margin: 18px auto 0;
        color: var(--muted);
        font-size: 16px;
        font-weight: 300;
    }
    .leam-page-banner .crumbs {
        position: relative;
        z-index: 1;
        margin-top: 14px;
        font-size: 13px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .leam-page-banner .crumbs a { color: var(--muted); text-decoration: none; }
    .leam-page-banner .crumbs a:hover { color: #fff; }

    /* Category block */
    .leam-cat-block {
        margin-bottom: 70px;
        scroll-margin-top: 90px;
    }
    .leam-cat-block:last-child { margin-bottom: 0; }
    .leam-cat-head {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 22px;
        border-bottom: 1px solid var(--border);
    }
    .leam-cat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: var(--card);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        flex-shrink: 0;
        position: relative;
    }
    .leam-cat-icon::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: 17px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        z-index: -1;
        opacity: 0.5;
    }
    .leam-cat-head-text { flex: 1; }
    .leam-cat-head h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(28px, 4vw, 40px);
        letter-spacing: 1.5px;
        line-height: 1;
        margin-bottom: 8px;
        color: #fff;
    }
    .leam-cat-head p { font-size: 14px; color: var(--muted); margin: 0; max-width: 600px; }
    .leam-cat-head-cta {
        flex-shrink: 0;
    }

    .leam-sub-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .leam-sub-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
        text-decoration: none;
        color: inherit;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-sub-card:hover {
        border-color: rgba(0,180,255,0.3);
        background: var(--card2);
        transform: translateY(-3px);
        text-decoration: none;
        color: inherit;
    }
    .leam-sub-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        opacity: 0;
        transition: opacity .25s;
    }
    .leam-sub-card:hover::after { opacity: 1; }
    .leam-sub-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .leam-sub-body { flex: 1; min-width: 0; }
    .leam-sub-body h4 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        text-transform: uppercase;
        color: #fff;
    }
    .leam-sub-body p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.55;
        margin: 0;
    }
    .leam-sub-link {
        font-size: 11.5px;
        color: #00b4ff;
        margin-top: 10px;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    /* Sticky category nav */
    .leam-cat-nav {
        position: sticky;
        top: 71px;
        z-index: 100;
        background: rgba(10,10,10,0.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border);
        padding: 14px 24px;
        overflow-x: auto;
    }
    .leam-cat-nav-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }
    .leam-cat-nav a {
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 8px 14px;
        border-radius: 8px;
        color: var(--muted);
        text-decoration: none;
        transition: all .2s;
        font-family: 'Barlow Condensed', sans-serif;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .leam-cat-nav a:hover { background: rgba(255,255,255,0.05); color: #fff; text-decoration: none; }

    .leam-empty {
        text-align: center;
        padding: 80px 20px;
        color: var(--muted);
    }
    .leam-empty h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        letter-spacing: 1px;
        color: #fff;
        margin-bottom: 10px;
    }

    @media (max-width: 700px) {
        .leam-cat-head { flex-direction: column; align-items: flex-start; gap: 14px; }
        .leam-cat-icon { width: 52px; height: 52px; font-size: 24px; }
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>Our <span class="rainbow-text">Services</span></h1>
    <p>Smart technology solutions across software, AI, cloud, security, and growth — built by senior teams for results.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Services</div>
</section>

@if($categories->count() > 0)
<!-- CATEGORY QUICK NAV -->
<div class="leam-cat-nav">
    <div class="leam-cat-nav-inner">
        @foreach($categories as $cat)
            <a href="#cat-{{ $cat->slug }}">{{ $cat->icon }} {{ $cat->name }}</a>
        @endforeach
    </div>
</div>

<!-- CATEGORIES -->
<section class="leam-section">
    <div class="leam-container">
        @foreach($categories as $cat)
            <div class="leam-cat-block" id="cat-{{ $cat->slug }}">
                <div class="leam-cat-head">
                    <div class="leam-cat-icon">{{ $cat->icon ?? '🔧' }}</div>
                    <div class="leam-cat-head-text">
                        <h2>{{ $cat->name }}</h2>
                        <p>{{ $cat->short_description }}</p>
                    </div>
                    <div class="leam-cat-head-cta">
                        <a href="{{ url($cat->slug) }}" class="leam-btn leam-btn-ghost" style="padding:10px 20px; font-size:13px;">View Category →</a>
                    </div>
                </div>

                @if($cat->subcategories->count() > 0)
                    <div class="leam-sub-grid">
                        @foreach($cat->subcategories as $sub)
                            <a href="{{ url($sub->slug) }}" class="leam-sub-card">
                                <div class="leam-sub-icon">{{ $sub->icon ?? '•' }}</div>
                                <div class="leam-sub-body">
                                    <h4>{{ $sub->name }}</h4>
                                    <p>{{ \Illuminate\Support\Str::limit($sub->short_description, 90) }}</p>
                                    <span class="leam-sub-link">EXPLORE →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @elseif($cat->services->count() > 0)
                    <div class="leam-sub-grid">
                        @foreach($cat->services->take(6) as $service)
                            <a href="{{ url($service->slug) }}" class="leam-sub-card">
                                <div class="leam-sub-icon">{{ $service->icon ?? '•' }}</div>
                                <div class="leam-sub-body">
                                    <h4>{{ $service->name }}</h4>
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?? ''), 90) }}</p>
                                    <span class="leam-sub-link">VIEW SERVICE →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>
@else
<section class="leam-section">
    <div class="leam-container leam-empty">
        <h3>No services published yet</h3>
        <p>Categories are being prepared. Check back soon, or get in touch.</p>
        <div style="margin-top:24px;">
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-primary">Contact Us</a>
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section style="background: var(--dark); padding: 80px 24px;">
    <div style="max-width:900px; margin:0 auto; background: var(--card); border-radius:24px; padding: 56px 44px; text-align:center; position:relative; border: 1px solid rgba(255,255,255,0.06); overflow:hidden;">
        <div style="position:absolute; inset:-2px; border-radius:26px; background: var(--rainbow); background-size:200%; animation: shift 4s linear infinite; z-index:-1; opacity:0.22;"></div>
        <h2 style="font-family:'Bebas Neue'; font-size: clamp(32px, 5vw, 52px); letter-spacing:2px; margin-bottom:14px; color:#fff;">Don't see what you need?</h2>
        <p style="color:var(--muted); margin-bottom:28px; font-weight:300; font-size:16px;">We build custom solutions across the technology spectrum. Tell us about your challenge.</p>
        <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Talk to Our Team ↗</a>
    </div>
</section>

@endsection
