@extends('layouts.master')
@php
$meta_title = "About LEAMSOFT | Smart Technology Partner for Modern Businesses";
$meta_description = "Learn about LEAMSOFT — a team of 50+ specialists delivering web, mobile, AI, cloud, and cyber security solutions to global businesses since 2021.";
$keywords = "About LEAMSOFT, software company, technology partner, web development team, AI experts, cloud specialists, IT consulting";
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
    .leam-page-banner .crumbs {
        position: relative;
        z-index: 1;
        margin-top: 18px;
        font-size: 13px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .leam-page-banner .crumbs a { color: var(--muted); text-decoration: none; }
    .leam-page-banner .crumbs a:hover { color: #fff; }

    /* About story */
    .leam-about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }
    .leam-about-images {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        position: relative;
    }
    .leam-about-images .img-box {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--card);
        aspect-ratio: 4 / 5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        position: relative;
    }
    .leam-about-images .img-box:nth-child(1) { margin-top: 40px; background: linear-gradient(135deg, rgba(0,180,255,0.15), rgba(168,85,247,0.1)); }
    .leam-about-images .img-box:nth-child(2) { background: linear-gradient(135deg, rgba(255,59,92,0.15), rgba(255,140,0,0.1)); }
    .leam-about-images .img-box:nth-child(3) { background: linear-gradient(135deg, rgba(57,211,83,0.15), rgba(0,180,255,0.1)); }
    .leam-about-images .img-box:nth-child(4) { margin-top: 40px; background: linear-gradient(135deg, rgba(168,85,247,0.15), rgba(255,215,0,0.1)); }

    .leam-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 32px;
    }
    .leam-stat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        text-align: center;
    }
    .leam-stat-card .num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 36px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shift 4s linear infinite;
    }
    .leam-stat-card .label {
        font-size: 12px;
        color: var(--muted);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Values */
    .leam-values-bg { background: var(--dark); }
    .leam-values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }
    .leam-value-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-value-card:hover {
        border-color: rgba(0,180,255,0.25);
        transform: translateY(-4px);
    }
    .leam-value-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        opacity: 0;
        transition: opacity .25s;
    }
    .leam-value-card:hover::after { opacity: 1; }
    .leam-value-card .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 18px;
    }
    .leam-value-card h4 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 19px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #fff;
    }
    .leam-value-card p { font-size: 14px; color: var(--muted); line-height: 1.6; margin: 0; }

    /* Team */
    .leam-team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
    .leam-team-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: all .3s;
    }
    .leam-team-card:hover { transform: translateY(-4px); border-color: rgba(0,180,255,0.25); }
    .leam-team-photo {
        height: 220px;
        background: linear-gradient(135deg, var(--card2) 0%, rgba(0,180,255,0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 72px;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shift 4s linear infinite;
    }
    .leam-team-photo-wrap {
        background: linear-gradient(135deg, var(--card2) 0%, #1a1a2e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 220px;
    }
    .leam-team-body { padding: 18px 22px 22px; }
    .leam-team-name { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 4px; }
    .leam-team-role { font-size: 13px; color: #00b4ff; margin-bottom: 12px; }
    .leam-team-socials { display: flex; gap: 8px; }
    .leam-team-socials a {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        text-decoration: none;
        font-size: 12px;
        transition: all .2s;
    }
    .leam-team-socials a:hover { border-color: rgba(0,180,255,0.4); color: #00b4ff; background: rgba(0,180,255,0.06); }

    @media (max-width: 900px) {
        .leam-about-grid { grid-template-columns: 1fr; gap: 40px; }
        .leam-about-images { max-width: 500px; margin: 0 auto; }
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>About <span class="rainbow-text">LEAMSOFT</span></h1>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; About Us</div>
</section>

<!-- STORY -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-about-grid">
            <div>
                <div class="leam-section-label">Our Story</div>
                <h2 class="leam-section-title">Building <span class="rainbow-text">Tomorrow's</span> Tech, Today</h2>
                <p class="leam-section-sub" style="margin-bottom: 18px;">
                    LEAMSOFT was founded with one mission: to make smart technology accessible to every business. What started as a small team of engineers in 2021 has grown into a distributed company of 50+ specialists serving clients across 25+ countries.
                </p>
                <p class="leam-section-sub" style="margin-bottom: 18px;">
                    We believe great technology isn't about using the trendiest stack — it's about choosing the right tools to solve real business problems. From scrappy startups to enterprise organizations, we partner with teams who care deeply about quality, speed, and outcomes.
                </p>
                <p class="leam-section-sub">
                    Today, LEAMSOFT operates across web development, mobile apps, AI/ML, cloud, cyber security, and digital marketing. But at our core, we're still the same team obsessed with shipping things that actually work.
                </p>

                <div class="leam-stat-grid">
                    <div class="leam-stat-card">
                        <div class="num">100+</div>
                        <div class="label">Projects Done</div>
                    </div>
                    <div class="leam-stat-card">
                        <div class="num">50+</div>
                        <div class="label">Team Members</div>
                    </div>
                    <div class="leam-stat-card">
                        <div class="num">25+</div>
                        <div class="label">Countries Served</div>
                    </div>
                </div>
            </div>
            <div class="leam-about-images">
                <div class="img-box">⚡</div>
                <div class="img-box">🚀</div>
                <div class="img-box">💡</div>
                <div class="img-box">🌐</div>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="leam-section leam-values-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Our Values</div>
            <h2 class="leam-section-title">What We <span class="rainbow-text">Stand For</span></h2>
            <p class="leam-section-sub">The principles that guide every decision we make and every line of code we ship.</p>
        </div>
        <div class="leam-values-grid">
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(0,180,255,0.1);">🎯</div>
                <h4>Outcome-Focused</h4>
                <p>We measure success by the business outcomes we create — not lines of code, story points, or vanity metrics.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(168,85,247,0.1);">🤝</div>
                <h4>True Partnership</h4>
                <p>Every client gets a dedicated team that treats your roadmap as our own, with transparent communication every step.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(57,211,83,0.1);">🛠️</div>
                <h4>Craft Over Speed</h4>
                <p>We move fast but never at the cost of quality. Every shipped feature is built to last, scale, and evolve.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(255,140,0,0.1);">🔓</div>
                <h4>No Lock-In</h4>
                <p>Open standards, clean code, full documentation. If you ever want to take it in-house, the handoff is painless.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(255,59,92,0.1);">🛡️</div>
                <h4>Security By Default</h4>
                <p>Security isn't a feature we sprinkle on top — it's woven into our process from day one through OWASP, ISO, and SOC2.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(255,215,0,0.1);">📈</div>
                <h4>Continuous Learning</h4>
                <p>The industry moves fast, so we move faster. Every engineer gets time for R&amp;D, conferences, and certifications.</p>
            </div>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Meet The Team</div>
            <h2 class="leam-section-title">The People <span class="rainbow-text">Behind</span> LEAMSOFT</h2>
            <p class="leam-section-sub">A handful of the engineers, designers, and strategists shipping work you'll love.</p>
        </div>
        <div class="leam-team-grid">
            @php
                $team = [
                    ['name'=>'Aditya Sharma','role'=>'Founder & CEO','init'=>'AS'],
                    ['name'=>'Priya Verma','role'=>'CTO','init'=>'PV'],
                    ['name'=>'Rohan Mehta','role'=>'Head of Engineering','init'=>'RM'],
                    ['name'=>'Sneha Iyer','role'=>'Head of Design','init'=>'SI'],
                ];
            @endphp
            @foreach($team as $t)
            <div class="leam-team-card">
                <div class="leam-team-photo-wrap">
                    <div class="leam-team-photo">{{ $t['init'] }}</div>
                </div>
                <div class="leam-team-body">
                    <div class="leam-team-name">{{ $t['name'] }}</div>
                    <div class="leam-team-role">{{ $t['role'] }}</div>
                    <div class="leam-team-socials">
                        <a href="#" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" title="GitHub"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="background: var(--dark); padding: 90px 24px;">
    <div style="max-width:900px; margin:0 auto; background: var(--card); border-radius:28px; padding: 60px 50px; text-align:center; position:relative; border: 1px solid rgba(255,255,255,0.06); overflow:hidden;">
        <div style="position:absolute; inset:-2px; border-radius:30px; background: var(--rainbow); background-size:200%; animation: shift 4s linear infinite; z-index:-1; opacity:0.25;"></div>
        <h2 style="font-family:'Bebas Neue'; font-size: clamp(36px, 5vw, 56px); letter-spacing:2px; margin-bottom:16px; color:#fff;">Want to <span class="rainbow-text">Work With Us</span>?</h2>
        <p style="color:var(--muted); margin-bottom:32px; font-weight:300; font-size:16px;">Whether you have a fully scoped project or just an idea, we'd love to hear from you.</p>
        <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Get in Touch ↗</a>
    </div>
</section>

@endsection
