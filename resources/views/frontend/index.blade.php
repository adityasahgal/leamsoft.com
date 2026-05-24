@extends('layouts.master')

@php
$meta_title = "LEAMSOFT | Empowering Business with Smart Technology";
$meta_description = "LEAMSOFT delivers advanced digital solutions — web platforms, enterprise software, AI systems, cloud, cyber security, and modern technology integration for global businesses.";
$keywords = "LEAMSOFT, software development, web development, app development, AI, machine learning, cloud solutions, cyber security, IT consulting, digital marketing";
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
        margin-bottom: 24px;
        animation: fadeUp .6s ease both;
    }
    .leam-hero-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #00b4ff; position: relative; }
    .leam-hero-badge .dot::after { content:''; position:absolute; inset:-4px; border-radius:50%; border:1px solid #00b4ff; animation: pulse-ring 1.5s ease-out infinite; }
    .leam-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(48px, 7vw, 84px);
        line-height: 0.95;
        letter-spacing: 2px;
        margin-bottom: 24px;
        animation: fadeUp .6s .1s ease both;
        color: #fff;
    }
    .leam-hero h1 em { font-style: normal; display: block; }
    .leam-hero p {
        font-size: 17px;
        color: var(--muted);
        line-height: 1.7;
        max-width: 500px;
        margin-bottom: 36px;
        animation: fadeUp .6s .2s ease both;
        font-weight: 300;
    }
    .leam-hero-btns { display: flex; gap: 14px; flex-wrap: wrap; animation: fadeUp .6s .3s ease both; }
    .leam-hero-stats {
        display: flex;
        gap: 32px;
        margin-top: 48px;
        animation: fadeUp .6s .4s ease both;
    }
    .leam-stat-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 40px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shift 4s linear infinite;
    }
    .leam-stat-label { font-size: 12px; color: var(--muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; }

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
                <span class="dot"></span> Trusted by 100+ Global Businesses
            </div>
            <h1>
                <em>Empowering</em>
                <em>Your Business</em>
                <em class="rainbow-text">With Smart Tech</em>
            </h1>
            <p>We deliver advanced digital solutions — from web platforms and enterprise software to AI systems, APIs, and modern technology integration for global businesses.</p>
            <div class="leam-hero-btns">
                <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Get Free Consultation ↗</a>
                <a href="#leam-services" class="leam-btn leam-btn-lg leam-btn-ghost">Explore Services</a>
            </div>
            <div class="leam-hero-stats">
                <div>
                    <div class="leam-stat-num">100+</div>
                    <div class="leam-stat-label">Projects Done</div>
                </div>
                <div>
                    <div class="leam-stat-num">04+</div>
                    <div class="leam-stat-label">Years Experience</div>
                </div>
                <div>
                    <div class="leam-stat-num">97%</div>
                    <div class="leam-stat-label">Happy Clients</div>
                </div>
                <div>
                    <div class="leam-stat-num">24/7</div>
                    <div class="leam-stat-label">Support</div>
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
                <strong>AI Systems</strong> Online
            </div>
            <div class="leam-floating-card leam-fc2">
                <span class="leam-fc-dot" style="background:#00b4ff"></span>
                +97% Client Satisfaction
            </div>
        </div>
    </div>
</section>

<!-- PARTNERS -->
<div class="leam-partners">
    <div class="leam-partners-inner">
        <div class="leam-partners-label">Trusted by leading organizations worldwide</div>
        <div class="leam-partners-logos">
            <div class="leam-partner-logo">Lexmark</div>
            <div class="leam-partner-logo">Walmart</div>
            <div class="leam-partner-logo">Agility</div>
            <div class="leam-partner-logo">Thompson</div>
            <div class="leam-partner-logo">Starters</div>
            <div class="leam-partner-logo">Zantis</div>
            <div class="leam-partner-logo">NexGen</div>
        </div>
    </div>
</div>

<!-- SERVICES -->
<section id="leam-services" class="leam-section leam-services-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">What We Do</div>
            <h2 class="leam-section-title">Our <span class="rainbow-text">Core Services</span></h2>
            <p class="leam-section-sub">From strategy to execution, we deliver end-to-end technology solutions that drive growth and innovation for businesses worldwide.</p>
        </div>
        <div class="leam-services-grid">
            @php
                $servicesList = \App\Models\Service::where('status', 1)->take(9)->get();
                $serviceIcons = ['🌐','📱','🤖','☁️','🛡️','📈','🔌','🛒','💼'];
                $serviceColors = [
                    'rgba(0,180,255,0.1)','rgba(168,85,247,0.1)','rgba(57,211,83,0.1)',
                    'rgba(255,215,0,0.1)','rgba(255,59,92,0.1)','rgba(0,180,255,0.1)',
                    'rgba(168,85,247,0.1)','rgba(57,211,83,0.1)','rgba(255,140,0,0.1)'
                ];
                $defaultServices = [
                    ['name'=>'Web Development','desc'=>'High-performance web platforms built with modern frameworks. Scalable, secure, and crafted to convert.'],
                    ['name'=>'App Development','desc'=>'Native and cross-platform mobile apps for iOS and Android that users love, built to perform at scale.'],
                    ['name'=>'AI & Machine Learning','desc'=>'Custom AI models, LLM integration, and intelligent automation that transforms how your business operates.'],
                    ['name'=>'Cloud Solutions','desc'=>'AWS, Azure and GCP expertise. Migration, architecture, and managed cloud services for the modern enterprise.'],
                    ['name'=>'Cyber Security','desc'=>'Comprehensive security solutions including pen testing, compliance frameworks, and incident response.'],
                    ['name'=>'Digital Marketing','desc'=>'Data-driven digital marketing strategies — SEO, PPC, social media — that grow your brand\'s online reach.'],
                    ['name'=>'API & System Integration','desc'=>'Seamless system integration and robust REST/GraphQL APIs connecting your entire tech ecosystem.'],
                    ['name'=>'E-Commerce Development','desc'=>'High-converting online stores with custom checkout flows, payment gateways, and inventory systems.'],
                    ['name'=>'IT Consulting','desc'=>'Strategic technology consulting to align your IT investments with your long-term business objectives.'],
                ];
            @endphp

            @if($servicesList->count() > 0)
                @foreach($servicesList as $key => $service)
                    <a href="{{ url($service->slug) }}" class="leam-service-card">
                        <div class="leam-service-icon" style="background:{{ $serviceColors[$key % 9] }};">
                            {{ $serviceIcons[$key % 9] }}
                        </div>
                        <h3>{{ $service->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?? $service->description ?? 'Custom-built solution tailored to your business needs and growth goals.'), 130) }}</p>
                        <span class="leam-service-link">Learn more →</span>
                    </a>
                @endforeach
            @else
                @foreach($defaultServices as $key => $s)
                    <a href="{{ url('contact-us') }}" class="leam-service-card">
                        <div class="leam-service-icon" style="background:{{ $serviceColors[$key] }};">{{ $serviceIcons[$key] }}</div>
                        <h3>{{ $s['name'] }}</h3>
                        <p>{{ $s['desc'] }}</p>
                        <span class="leam-service-link">Learn more →</span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- WHY US -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-why-grid">
            <div>
                <div class="leam-section-label">Why LEAMSOFT</div>
                <h2 class="leam-section-title">Built for <span class="rainbow-text">Results</span></h2>
                <p class="leam-section-sub" style="margin-bottom:40px">We combine deep technical expertise with strategic thinking to deliver solutions that solve real business problems and create lasting value.</p>
                <div class="leam-why-features">
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(0,180,255,0.1);">⚡</div>
                        <div>
                            <h4>Rapid Delivery</h4>
                            <p>Agile development cycles with CI/CD pipelines that ship quality features faster without compromising standards.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(168,85,247,0.1);">🔒</div>
                        <div>
                            <h4>Security First</h4>
                            <p>Every product is built with security baked in — not bolted on — following OWASP and industry best practices.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(57,211,83,0.1);">📊</div>
                        <div>
                            <h4>Data-Driven Decisions</h4>
                            <p>Analytics-powered development and strategies that optimize for real business outcomes, not vanity metrics.</p>
                        </div>
                    </div>
                    <div class="leam-why-feat">
                        <div class="leam-why-feat-icon" style="background:rgba(255,215,0,0.1);">🌍</div>
                        <div>
                            <h4>Global Expertise</h4>
                            <p>A distributed team of 50+ specialists serving clients across 25+ countries with 24/7 support coverage.</p>
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

<!-- PROJECTS -->
@php $projects = \App\Models\Service::where('status', 1)->take(6)->get(); @endphp
@if($projects->count() > 0)
<section class="leam-section leam-projects-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Our Work</div>
            <h2 class="leam-section-title">Featured <span class="rainbow-text">Projects</span></h2>
            <p class="leam-section-sub">A selection of recent work for clients across industries — from startups to enterprise.</p>
        </div>
        <div class="leam-projects-grid">
            @foreach($projects as $key => $project)
            <a class="leam-project-card" href="{{ url($project->slug) }}">
                <div class="leam-project-thumb">
                    @if(!empty($project->thumbnail_img))
                        <img src="{{ url('storage/'.$project->thumbnail_img) }}" alt="{{ $project->image_alt ?? $project->name }}">
                    @endif
                </div>
                <div class="leam-project-body">
                    <span class="leam-project-tag">{{ ['Web','Mobile','AI','Cloud','Security','Marketing'][$key % 6] }}</span>
                    <h3>{{ $project->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->short_description ?? $project->description ?? 'Successfully delivered project showcasing our technical capabilities.'), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="leam-cta-section">
    <div class="leam-cta-box">
        <h2>Ready to Build <span class="rainbow-text">Something Great?</span></h2>
        <p>Let's discuss how LEAMSOFT can help bring your vision to life with smart technology solutions tailored to your business.</p>
        <div class="leam-cta-btns">
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Start a Project ↗</a>
            <a href="{{ url('about-us') }}" class="leam-btn leam-btn-lg leam-btn-ghost">Learn More About Us</a>
        </div>
    </div>
</section>

@endsection
