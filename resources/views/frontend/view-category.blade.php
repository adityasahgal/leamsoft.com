@extends('layouts.master')

@section('meta_title'){{ $categories->meta_title ?? $categories->name }}@stop
@section('meta_description'){{ $categories->meta_description ?? $categories->short_description }}@stop
@section('meta_keywords'){{ $categories->keywords }}@stop

@section('content')
<style>
    .leam-cat-hero {
        padding: 90px 24px 70px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-cat-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 30% 0%, {{ $categories->color ?? '#00b4ff' }}22 0%, transparent 70%),
                    radial-gradient(ellipse 40% 40% at 80% 100%, rgba(168,85,247,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-cat-hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 40px;
        align-items: center;
    }
    .leam-cat-hero-meta {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 14px;
    }
    .leam-cat-hero-meta a { color: var(--muted); text-decoration: none; }
    .leam-cat-hero-meta a:hover { color: #fff; }
    .leam-cat-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(44px, 7vw, 78px);
        letter-spacing: 2px;
        line-height: 1;
        margin: 0 0 18px;
        color: #fff;
    }
    .leam-cat-hero p {
        font-size: 17px;
        color: var(--muted);
        line-height: 1.7;
        max-width: 600px;
        font-weight: 300;
        margin: 0 0 28px;
    }
    .leam-cat-hero-stats { display: flex; gap: 28px; }
    .leam-cat-hero-stat .num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shift 4s linear infinite;
    }
    .leam-cat-hero-stat .lab { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--muted); margin-top: 4px; }

    .leam-cat-big-icon {
        width: 180px;
        height: 180px;
        border-radius: 32px;
        background: var(--card);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 92px;
        position: relative;
    }
    .leam-cat-big-icon::before {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 34px;
        background: var(--rainbow);
        background-size: 300%;
        animation: shift 5s linear infinite;
        z-index: -1;
        opacity: 0.5;
    }

    .leam-subcat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 18px;
    }
    .leam-subcat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-subcat-card:hover {
        border-color: rgba(0,180,255,0.3);
        background: var(--card2);
        transform: translateY(-4px);
        text-decoration: none;
        color: inherit;
    }
    .leam-subcat-card::after {
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
    .leam-subcat-card:hover::after { opacity: 1; }
    .leam-subcat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: rgba(0,180,255,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 18px;
    }
    .leam-subcat-card h3 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        text-transform: uppercase;
        color: #fff;
    }
    .leam-subcat-card p {
        font-size: 14px;
        color: var(--muted);
        line-height: 1.6;
        margin: 0 0 14px;
    }
    .leam-subcat-link {
        font-size: 12px;
        color: #00b4ff;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .leam-cat-desc-block {
        background: var(--dark);
        padding: 80px 24px;
        border-top: 1px solid var(--border);
    }
    .leam-cat-desc-content {
        font-size: 16px;
        color: var(--muted);
        line-height: 1.8;
        font-weight: 300;
    }
    .leam-cat-desc-content h2, .leam-cat-desc-content h3 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 1px;
        margin-top: 32px;
        margin-bottom: 14px;
    }
    .leam-cat-desc-content h2 { font-size: 32px; }
    .leam-cat-desc-content h3 { font-size: 24px; }
    .leam-cat-desc-content ul { padding-left: 22px; margin: 14px 0; }
    .leam-cat-desc-content li { margin-bottom: 8px; }

    @media (max-width: 800px) {
        .leam-cat-hero-inner { grid-template-columns: 1fr; }
        .leam-cat-big-icon { width: 120px; height: 120px; font-size: 64px; border-radius: 24px; }
    }
</style>

<!-- CATEGORY HERO -->
<section class="leam-cat-hero">
    <div class="leam-cat-hero-inner">
        <div>
            <div class="leam-cat-hero-meta">
                <a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp;
                <a href="{{ url('services') }}">Services</a> &nbsp;›&nbsp;
                <span style="color:#00b4ff;">{{ $categories->name }}</span>
            </div>
            <h1>{{ $categories->name }}</h1>
            <p>{{ $categories->short_description }}</p>
            <div class="leam-cat-hero-stats">
                <div class="leam-cat-hero-stat">
                    <div class="num">{{ $subcategories->count() }}</div>
                    <div class="lab">Subcategories</div>
                </div>
                <div class="leam-cat-hero-stat">
                    <div class="num">{{ $services->count() }}+</div>
                    <div class="lab">Services</div>
                </div>
                <div class="leam-cat-hero-stat">
                    <div class="num">100%</div>
                    <div class="lab">Quality Promise</div>
                </div>
            </div>
        </div>
        <div class="leam-cat-big-icon">{{ $categories->icon ?? '🔧' }}</div>
    </div>
</section>

<!-- SUBCATEGORIES -->
@if($subcategories->count() > 0)
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">What we offer</div>
            <h2 class="leam-section-title">{{ $categories->name }} <span class="rainbow-text">Capabilities</span></h2>
        </div>
        <div class="leam-subcat-grid">
            @foreach($subcategories as $sub)
                <a href="{{ url($sub->slug) }}" class="leam-subcat-card">
                    <div class="leam-subcat-icon">{{ $sub->icon ?? '•' }}</div>
                    <h3>{{ $sub->name }}</h3>
                    <p>{{ $sub->short_description }}</p>
                    <span class="leam-subcat-link">Learn more →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ALL SERVICES IN CATEGORY -->
@if($services->count() > 0)
<section class="leam-section" style="background: var(--dark); border-top: 1px solid var(--border);">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">Browse services</div>
            <h2 class="leam-section-title">All <span class="rainbow-text">{{ $categories->name }}</span> Services</h2>
        </div>
        <div class="leam-subcat-grid">
            @foreach($services as $service)
                <a href="{{ url($service->slug) }}" class="leam-subcat-card">
                    <div class="leam-subcat-icon" style="background: rgba(168,85,247,0.08);">{{ $service->icon ?? '🔧' }}</div>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?? ''), 110) }}</p>
                    <span class="leam-subcat-link">View service →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- LONG DESCRIPTION -->
@if(!empty($categories->description))
<section class="leam-cat-desc-block">
    <div class="leam-container" style="max-width:900px; margin:0 auto;">
        <div class="leam-section-label">About this category</div>
        <h2 class="leam-section-title" style="margin-bottom:24px;">Why <span class="rainbow-text">LEAMSOFT</span> for {{ $categories->name }}?</h2>
        <div class="leam-cat-desc-content">{!! $categories->description !!}</div>
    </div>
</section>
@endif

<!-- CTA -->
<section style="padding: 80px 24px;">
    <div style="max-width:900px; margin:0 auto; background: var(--card); border-radius:24px; padding: 56px 44px; text-align:center; position:relative; border: 1px solid rgba(255,255,255,0.06); overflow:hidden;">
        <div style="position:absolute; inset:-2px; border-radius:26px; background: var(--rainbow); background-size:200%; animation: shift 4s linear infinite; z-index:-1; opacity:0.22;"></div>
        <h2 style="font-family:'Bebas Neue'; font-size: clamp(32px, 5vw, 52px); letter-spacing:2px; margin-bottom:14px; color:#fff;">Have a {{ $categories->name }} <span class="rainbow-text">project</span>?</h2>
        <p style="color:var(--muted); margin-bottom:28px; font-weight:300; font-size:16px;">Tell us about it — we'll get back to you within one business day.</p>
        <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Start a Project ↗</a>
    </div>
</section>

@endsection
