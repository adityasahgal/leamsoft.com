@extends('layouts.master')

@php
$meta_title = "Leamsoft Pvt Ltd. | AI-Powered Software, Cloud & Blockchain Solutions";
$meta_description = "Leamsoft Pvt Ltd. builds AI-powered software, cloud infrastructure, blockchain platforms, CRM/ERP, and SaaS products for startups and enterprises across Delhi, Noida & Greater Noida.";
$keywords = "Leamsoft, AI software company, blockchain development, cloud DevOps, SaaS development, CRM ERP, custom software Delhi Noida, enterprise web applications";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta_keywords'){{ $keywords }}@stop

@section('content')
<style>
    /* ─── HERO ─── */
    .leam-hero {
        min-height: 88vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 80px 24px;
    }
    .leam-hero-bg {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 70% 50%, rgba(0,180,255,0.08) 0%, transparent 70%),
                    radial-gradient(ellipse 40% 40% at 20% 80%, rgba(168,85,247,0.08) 0%, transparent 70%),
                    radial-gradient(ellipse 50% 50% at 50% 0%, rgba(255,59,92,0.06) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-hero-grid {
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
        pointer-events: none;
    }
    .leam-hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
        width: 100%;
    }
    .leam-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0,180,255,0.1);
        border: 1px solid rgba(0,180,255,0.25);
        border-radius: 100px;
        padding: 5px 14px;
        font-size: 12px;
        color: #00b4ff;
        margin-bottom: 18px;
        animation: fadeUp .6s ease both;
    }
    .leam-hero-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #00b4ff; position: relative; }
    .leam-hero-badge .dot::after { content:''; position:absolute; inset:-4px; border-radius:50%; border:1px solid #00b4ff; animation: pulse-ring 1.5s ease-out infinite; }
    .leam-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(32px, 4.2vw, 54px);
        line-height: 1;
        letter-spacing: 1.5px;
        margin-bottom: 18px;
        animation: fadeUp .6s .1s ease both;
        color: #fff;
    }
    .leam-hero h1 em { font-style: normal; display: block; }
    .leam-hero p {
        font-size: 15px;
        color: var(--muted);
        line-height: 1.65;
        max-width: 500px;
        margin-bottom: 26px;
        animation: fadeUp .6s .2s ease both;
        font-weight: 300;
    }
    .leam-hero-btns { display: flex; gap: 12px; flex-wrap: wrap; animation: fadeUp .6s .3s ease both; }
    .leam-hero-stats {
        display: flex;
        gap: 28px;
        margin-top: 32px;
        animation: fadeUp .6s .4s ease both;
    }
    .leam-stat-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 30px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shift 4s linear infinite;
    }
    .leam-stat-label { font-size: 11px; color: var(--muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; }

    /* Hero Visual / Carousel */
    .leam-hero-visual {
        position: relative;
        animation: fadeUp .6s .2s ease both;
        height: 460px;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .leam-hero-visual::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: 25px;
        background: var(--rainbow);
        background-size: 300%;
        animation: shift 6s linear infinite;
        z-index: 0;
        opacity: 0.35;
        pointer-events: none;
    }
    .leam-hero-visual .carousel,
    .leam-hero-visual .carousel-inner,
    .leam-hero-visual .carousel-item { height: 100%; border-radius: 23px; overflow: hidden; }
    .leam-hero-visual .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.85) saturate(1.1);
    }
    .leam-hero-visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(0,180,255,0.1) 100%);
        pointer-events: none;
        z-index: 1;
        border-radius: 23px;
    }
    .leam-floating-card {
        position: absolute;
        background: rgba(22,22,22,0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 5;
        color: #fff;
    }
    .leam-fc1 { top: 20px; right: -20px; }
    .leam-fc2 { bottom: 30px; left: -30px; }
    .leam-fc-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }

    /* ─── SERVICES ─── */
    .leam-services-bg { background: var(--dark); }
    .leam-services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2px;
        background: var(--border);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .leam-service-card {
        background: var(--dark);
        padding: 36px 32px;
        transition: background .25s;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .leam-service-card::after {
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
    .leam-service-card:hover { background: var(--card2); text-decoration: none; color: inherit; }
    .leam-service-card:hover::after { opacity: 1; }
    .leam-service-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .leam-service-card h3 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #fff;
    }
    .leam-service-card p { font-size: 14px; color: var(--muted); line-height: 1.6; margin: 0; }
    .leam-service-link {
        margin-top: 18px;
        font-size: 13px;
        color: #00b4ff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        opacity: 0;
        transition: opacity .25s;
    }
    .leam-service-card:hover .leam-service-link { opacity: 1; }

    /* ─── WHY US ─── */
    .leam-why-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
    }
    .leam-why-features { display: flex; flex-direction: column; gap: 20px; }
    .leam-why-feat {
        display: flex;
        gap: 18px;
        align-items: flex-start;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all .25s;
    }
    .leam-why-feat:hover { background: var(--card); border-color: var(--border); }
    .leam-why-feat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .leam-why-feat h4 { font-size: 16px; font-weight: 600; margin-bottom: 6px; color: #fff; }
    .leam-why-feat p { font-size: 14px; color: var(--muted); line-height: 1.6; margin: 0; }
    .leam-why-visual {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .leam-why-chart {
        width: 340px;
        height: 340px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.06);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .leam-why-chart-inner {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--card);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        z-index: 2;
        position: relative;
        border: 1px solid var(--border);
    }
    .leam-why-chart-inner .big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 56px;
        line-height: 1;
    }
    .leam-why-chart-inner .small { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }
    .leam-chart-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 3px solid transparent;
    }
    .leam-ring1 { border-top-color: #00b4ff; border-right-color: #00b4ff; animation: spinSlow 8s linear infinite; }
    .leam-ring2 { inset: 30px; border-bottom-color: #a855f7; animation: spinSlow 12s linear infinite reverse; }
    .leam-ring3 { inset: 60px; border-left-color: #ff3b5c; animation: spinSlow 6s linear infinite; }

    /* ─── PROJECTS ─── */
    .leam-projects-bg { background: var(--dark); }
    .leam-projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    .leam-project-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: all .3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .leam-project-card:hover {
        transform: translateY(-6px);
        border-color: rgba(0,180,255,0.2);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        text-decoration: none;
        color: inherit;
    }
    .leam-project-thumb {
        height: 200px;
        background: linear-gradient(135deg, var(--card2) 0%, #1a1a2e 100%);
        position: relative;
        overflow: hidden;
    }
    .leam-project-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s;
    }
    .leam-project-card:hover .leam-project-thumb img { transform: scale(1.05); }
    .leam-project-thumb::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--rainbow2);
        opacity: 0;
        transition: opacity .3s;
        z-index: 1;
    }
    .leam-project-card:hover .leam-project-thumb::before { opacity: 0.1; }
    .leam-project-body { padding: 20px 22px; }
    .leam-project-tag {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 100px;
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        display: inline-block;
        margin-bottom: 10px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .leam-project-card h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #fff; }
    .leam-project-card p { font-size: 13px; color: var(--muted); line-height: 1.6; margin: 0; }

    /* ─── CTA ─── */
    .leam-cta-section { background: var(--dark); padding: 90px 24px; }
    .leam-cta-box {
        max-width: 900px;
        margin: 0 auto;
        background: var(--card);
        border-radius: 28px;
        padding: 70px 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .leam-cta-box::before {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 30px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        z-index: -1;
        opacity: 0.25;
    }
    .leam-cta-box h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(40px, 6vw, 70px);
        letter-spacing: 2px;
        margin-bottom: 20px;
        line-height: 1;
        color: #fff;
    }
    .leam-cta-box p {
        font-size: 17px;
        color: var(--muted);
        margin-bottom: 36px;
        max-width: 520px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 300;
    }
    .leam-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    /* ─── INDUSTRIES ─── */
    .leam-industries-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 14px;
    }
    .leam-industry-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-industry-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        opacity: 0;
        transition: opacity .25s;
    }
    .leam-industry-card:hover {
        transform: translateY(-3px);
        border-color: rgba(0,180,255,0.25);
        background: var(--card2);
    }
    .leam-industry-card:hover::after { opacity: 1; }
    .leam-industry-icon {
        font-size: 24px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255,255,255,0.04);
        flex-shrink: 0;
    }
    .leam-industry-name {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #fff;
    }

    /* ─── PARTNERS ─── */
    .leam-partners {
        padding: 48px 24px;
        background: var(--dark);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }
    .leam-partners-inner { max-width: 1280px; margin: 0 auto; }
    .leam-partners-label {
        text-align: center;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.3);
        margin-bottom: 32px;
    }
    .leam-partners-logos {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 48px;
        flex-wrap: wrap;
    }
    .leam-partner-logo {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 2px;
        color: rgba(255,255,255,0.2);
        text-transform: uppercase;
        transition: color .25s;
    }
    .leam-partner-logo:hover { color: rgba(255,255,255,0.6); }

    @media (max-width: 900px) {
        .leam-hero-inner { grid-template-columns: 1fr; }
        .leam-hero-visual { display: none; }
        .leam-why-grid { grid-template-columns: 1fr; }
        .leam-why-visual { display: none; }
        .leam-cta-box { padding: 48px 28px; }
    }
    @media (max-width: 600px) {
        .leam-hero-stats { gap: 20px; flex-wrap: wrap; }
    }
</style>

<!-- HERO -->
<section class="leam-hero">
    <div class="leam-hero-bg"></div>
    <div class="leam-hero-grid"></div>
    <div class="leam-hero-inner">
        <div>
            <div class="leam-hero-badge">
                <span class="dot"></span> AI · Cloud · Blockchain · SaaS · Delhi NCR
            </div>
            <h1>
                <em>We Build</em>
                <em>AI-Powered</em>
                <em class="rainbow-text">Digital Systems</em>
                <em>For Modern Businesses</em>
            </h1>
            <p>Leamsoft Pvt Ltd. helps startups, enterprises, and growing businesses automate operations using AI-powered software, cloud infrastructure, blockchain systems, and scalable digital solutions across Delhi, Noida, and Greater Noida.</p>
            <div class="leam-hero-btns">
                <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Book Free Consultation ↗</a>
                <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-ghost">Start Your Project</a>
                <a href="#leam-services" class="leam-btn leam-btn-lg leam-btn-ghost">Talk To Our Team</a>
            </div>
            <div class="leam-hero-stats">
                <div>
                    <div class="leam-stat-num">100+</div>
                    <div class="leam-stat-label">Projects Delivered</div>
                </div>
                <div>
                    <div class="leam-stat-num">04+</div>
                    <div class="leam-stat-label">Years Experience</div>
                </div>
                <div>
                    <div class="leam-stat-num">97%</div>
                    <div class="leam-stat-label">Client Satisfaction</div>
                </div>
                <div>
                    <div class="leam-stat-num">24/7</div>
                    <div class="leam-stat-label">Tech Support</div>
                </div>
            </div>
        </div>

        <div class="leam-hero-visual">
            @php $heroBanners = \App\Models\Banner::where('position', 1)->where('status', 1)->get(); @endphp
            @if($heroBanners->count() > 0)
                <div id="carouselHome" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @foreach ($heroBanners as $key => $banner)
                        <div class="carousel-item @if ($key == 0) active @endif">
                            <img @if ($key==0) rel="preload" @else loading="lazy" @endif
                                src="{{ url('storage/' . $banner->banner) }}" alt="{{ $banner->image_alt }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="height:100%; display:flex; align-items:center; justify-content:center; background: radial-gradient(circle, rgba(0,180,255,0.15), rgba(168,85,247,0.1), transparent); position:relative; z-index:1;">
                    <div style="text-align:center;">
                        <div style="font-size:80px;">⚡</div>
                        <div class="rainbow-text" style="font-family:'Bebas Neue'; font-size:36px; letter-spacing:4px;">LEAMSOFT</div>
                    </div>
                </div>
            @endif
            <div class="leam-floating-card leam-fc1">
                <span class="leam-fc-dot" style="background:#39d353"></span>
                <strong>AI Workflows</strong> Live
            </div>
            <div class="leam-floating-card leam-fc2">
                <span class="leam-fc-dot" style="background:#00b4ff"></span>
                Blockchain · Cloud · SaaS
            </div>
        </div>
    </div>
</section>

<!-- TRUST / QUICK HIGHLIGHTS -->
<div class="leam-partners">
    <div class="leam-partners-inner">
        <div class="leam-partners-label">Trusted Technology Partner For Modern Businesses</div>
        <div class="leam-partners-logos">
            <div class="leam-partner-logo">AI Software</div>
            <div class="leam-partner-logo">Blockchain</div>
            <div class="leam-partner-logo">Cloud · DevOps</div>
            <div class="leam-partner-logo">Enterprise Web</div>
            <div class="leam-partner-logo">CRM &amp; ERP</div>
            <div class="leam-partner-logo">SaaS Products</div>
            <div class="leam-partner-logo">UI / UX</div>
        </div>
    </div>
</div>

<!-- SERVICES -->
<section id="leam-services" class="leam-section leam-services-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">What We Do</div>
            <h2 class="leam-section-title">Our <span class="rainbow-text">Core Services</span></h2>
            <p class="leam-section-sub">From AI automation and blockchain to scalable cloud platforms and enterprise software — we build the systems that run modern businesses.</p>
        </div>
        <div class="leam-services-grid">
            @php
                $homeCats = isset($categories) && $categories->count() ? $categories : \App\Models\Category::where('status', 1)->orderBy('sort_order')->take(9)->get();
                $serviceColors = [
                    'rgba(0,180,255,0.1)','rgba(168,85,247,0.1)','rgba(57,211,83,0.1)',
                    'rgba(255,215,0,0.1)','rgba(255,59,92,0.1)','rgba(255,140,0,0.1)',
                    'rgba(0,180,255,0.1)','rgba(168,85,247,0.1)','rgba(57,211,83,0.1)'
                ];
                $defaultCats = [
                    ['name'=>'AI-Powered Software','slug'=>'services','icon'=>'🤖','desc'=>'Intelligent software systems with automation, ML integrations, and workflow optimization.'],
                    ['name'=>'Custom Web Development','slug'=>'services','icon'=>'💻','desc'=>'Secure, scalable, modern web applications — from startup sites to enterprise platforms.'],
                    ['name'=>'Blockchain Development','slug'=>'services','icon'=>'⛓️','desc'=>'Smart contracts, Web3 apps, NFT platforms, crypto-enabled and decentralized ecosystems.'],
                    ['name'=>'Cloud &amp; DevOps','slug'=>'services','icon'=>'☁️','desc'=>'Scalable cloud infrastructure, CI/CD, deployment automation, monitoring, and server optimization.'],
                    ['name'=>'CRM &amp; ERP Systems','slug'=>'services','icon'=>'🗂️','desc'=>'Custom business management systems built around your workflow and operations.'],
                    ['name'=>'SaaS Product Development','slug'=>'services','icon'=>'🚀','desc'=>'End-to-end SaaS architecture, subscription systems, dashboards, APIs and scalable engineering.'],
                ];
            @endphp

            @if($homeCats->count() > 0)
                @foreach($homeCats as $key => $cat)
                    <a href="{{ url($cat->slug) }}" class="leam-service-card">
                        <div class="leam-service-icon" style="background:{{ $serviceColors[$key % 9] }};">
                            {{ $cat->icon ?? '🔧' }}
                        </div>
                        <h3>{{ $cat->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($cat->short_description ?? ''), 130) }}</p>
                        <span class="leam-service-link">Explore category →</span>
                    </a>
                @endforeach
            @else
                @foreach($defaultCats as $key => $s)
                    <a href="{{ url($s['slug']) }}" class="leam-service-card">
                        <div class="leam-service-icon" style="background:{{ $serviceColors[$key] }};">{{ $s['icon'] }}</div>
                        <h3>{{ $s['name'] }}</h3>
                        <p>{{ $s['desc'] }}</p>
                        <span class="leam-service-link">Learn more →</span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- ABOUT INTRO -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">About Leamsoft</div>
            <h2 class="leam-section-title">A Technology Company <span class="rainbow-text">Built For Modern Business</span></h2>
            <p class="leam-section-sub">Leamsoft Pvt Ltd. is a technology-driven IT company focused on building scalable, secure, and intelligent software systems for startups, enterprises, and modern businesses. We specialize in AI automation, cloud infrastructure, blockchain applications, enterprise web development, and business process optimization — helping companies in Delhi, Noida, Greater Noida, and across India simplify operations, improve efficiency, and accelerate growth.</p>
            <div style="margin-top:28px;">
                <a href="{{ url('about-us') }}" class="leam-btn leam-btn-ghost">Learn More About Us →</a>
            </div>
        </div>
    </div>
</section>

<!-- WHY US -->
<section class="leam-section leam-services-bg">
    <div class="leam-container">
        <div class="leam-why-grid">
            <div>
                <div class="leam-section-label">Why Leamsoft</div>
                <h2 class="leam-section-title">Why Businesses <span class="rainbow-text">Choose Us</span></h2>
                <p class="leam-section-sub" style="margin-bottom:40px">We don't just write code — we build systems that solve real operational challenges with long-term scalability, security, and performance in mind.</p>
                <div class="leam-why-features">
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(0,180,255,0.1);">🎯</div>
                        <div>
                            <h4>Business-Focused Development</h4>
                            <p>We build systems that solve real operational challenges — not just deliverables. Every feature is tied to a business outcome.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(168,85,247,0.1);">📈</div>
                        <div>
                            <h4>Scalable Architecture</h4>
                            <p>Our solutions are built for long-term growth, high performance, and enterprise-grade scalability from day one.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(57,211,83,0.1);">⚙️</div>
                        <div>
                            <h4>Modern Technology Stack</h4>
                            <p>Modern frontend frameworks, robust backend architectures, cloud-native systems, and AI-ready automation tools.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(255,215,0,0.1);">🤝</div>
                        <div>
                            <h4>Dedicated Technical Support</h4>
                            <p>From deployment to scaling, our technical team stays with you — supporting your digital infrastructure long after launch.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(255,59,92,0.1);">🛡️</div>
                        <div>
                            <h4>Security &amp; Performance</h4>
                            <p>Optimized performance, server hardening, data protection, and reliable deployments built into every project.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="leam-why-visual">
                <div class="leam-why-chart">
                    <div class="leam-chart-ring leam-ring1"></div>
                    <div class="leam-chart-ring leam-ring2"></div>
                    <div class="leam-chart-ring leam-ring3"></div>
                    <div class="leam-why-chart-inner">
                        <span class="big rainbow-text">97%</span>
                        <span class="small">Client Satisfaction</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INDUSTRIES WE SERVE -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Industries We Serve</div>
            <h2 class="leam-section-title">Industries We <span class="rainbow-text">Work With</span></h2>
            <p class="leam-section-sub">From real estate to fintech, we build technology that powers diverse industries across India and beyond.</p>
        </div>
        <div class="leam-industries-grid">
            @php
                $industries = [
                    ['name'=>'Real Estate','icon'=>'🏢'],
                    ['name'=>'Healthcare','icon'=>'⚕️'],
                    ['name'=>'Construction','icon'=>'🏗️'],
                    ['name'=>'E-Commerce','icon'=>'🛒'],
                    ['name'=>'Education','icon'=>'🎓'],
                    ['name'=>'Finance','icon'=>'💰'],
                    ['name'=>'Logistics','icon'=>'🚚'],
                    ['name'=>'Startups','icon'=>'🚀'],
                    ['name'=>'Manufacturing','icon'=>'🏭'],
                    ['name'=>'Hospitality','icon'=>'🏨'],
                    ['name'=>'SaaS Businesses','icon'=>'☁️'],
                    ['name'=>'Agencies','icon'=>'🎯'],
                ];
            @endphp
            @foreach($industries as $ind)
                <div class="leam-industry-card">
                    <span class="leam-industry-icon">{{ $ind['icon'] }}</span>
                    <span class="leam-industry-name">{{ $ind['name'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURED SERVICES -->
@php
    $projects = isset($featuredServices) && $featuredServices->count() ? $featuredServices : \App\Models\Service::where('status', 1)->where('featured', 1)->take(6)->get();
@endphp
@if($projects->count() > 0)
<section class="leam-section leam-projects-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Featured Work</div>
            <h2 class="leam-section-title">Selected <span class="rainbow-text">Services</span></h2>
            <p class="leam-section-sub">A handful of our most-requested capabilities — from web platforms to AI deployments.</p>
        </div>
        <div class="leam-projects-grid">
            @foreach($projects as $key => $project)
            <a class="leam-project-card" href="{{ url($project->slug) }}">
                <div class="leam-project-thumb">
                    @if(!empty($project->thumbnail_img))
                        <img src="{{ url('storage/'.$project->thumbnail_img) }}" alt="{{ $project->image_alt ?? $project->name }}">
                    @else
                        <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:42px; letter-spacing:2px;">{{ $project->icon ?? 'SVC' }}</span>
                    @endif
                </div>
                <div class="leam-project-body">
                    <span class="leam-project-tag">{{ optional($project->category)->name ?? 'Service' }}</span>
                    <h3>{{ $project->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->short_description ?? $project->description ?? 'Successfully delivered service showcasing our technical capabilities.'), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center; margin-top: 40px;">
            <a href="{{ url('services') }}" class="leam-btn leam-btn-ghost">View All Services →</a>
        </div>
    </div>
</section>
@endif

<!-- LATEST BLOG POSTS -->
@php
    $homeBlogs = isset($latestBlogs) && $latestBlogs->count() ? $latestBlogs : \App\Models\Blog::where('status', 1)->latest()->take(3)->get();
@endphp
@if($homeBlogs->count() > 0)
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">From the blog</div>
            <h2 class="leam-section-title">Latest <span class="rainbow-text">Insights</span></h2>
            <p class="leam-section-sub">Engineering deep-dives, AI articles, and growth notes from our team.</p>
        </div>
        <div class="leam-projects-grid">
            @foreach($homeBlogs as $blog)
                <a href="{{ url('blog/'.$blog->slug) }}" class="leam-project-card">
                    <div class="leam-project-thumb">
                        @if(!empty($blog->thumbnail_img))
                            <img src="{{ url('storage/'.$blog->thumbnail_img) }}" alt="{{ $blog->image_alt ?? $blog->title }}">
                        @else
                            <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:32px; letter-spacing:2px;">LEAMSOFT</span>
                        @endif
                    </div>
                    <div class="leam-project-body">
                        <span class="leam-project-tag">{{ $blog->created_at?->format('M d, Y') }}</span>
                        <h3>{{ $blog->title ?? $blog->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->short_description ?? $blog->description ?? ''), 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="text-align:center; margin-top: 40px;">
            <a href="{{ url('blog') }}" class="leam-btn leam-btn-ghost">Read More Articles →</a>
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="leam-cta-section">
    <div class="leam-cta-box">
        <h2>Transform Your Business <span class="rainbow-text">With Smart Technology</span></h2>
        <p>Whether you need AI automation, enterprise software, blockchain systems, or scalable cloud infrastructure — Leamsoft is ready to build your next digital solution.</p>
        <div class="leam-cta-btns">
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Schedule A Meeting ↗</a>
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-ghost">Get Custom Quote</a>
        </div>
    </div>
</section>

@endsection
