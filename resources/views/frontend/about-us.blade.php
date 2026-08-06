@extends('layouts.master')
@php
$meta_title = "About Leamsoft Pvt Ltd. | AI, Cloud & Blockchain Technology Company";
$meta_description = "Leamsoft Pvt Ltd. is a next-generation IT company delivering advanced software engineering, cloud infrastructure, AI automation, and blockchain solutions across Delhi NCR and India.";
$keywords = "About Leamsoft, IT company Delhi NCR, AI company, blockchain developers India, cloud DevOps team, custom software India";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta_keywords'){{ $keywords }}@stop
@section('content')
<style>
    /* ---------- Banner ---------- */
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
        max-width: 620px;
        margin: 18px auto 0;
        color: var(--muted);
        font-size: 16px;
        font-weight: 300;
        line-height: 1.7;
    }
    .leam-page-banner .crumbs {
        position: relative;
        z-index: 1;
        margin-top: 16px;
        font-size: 13px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .leam-page-banner .crumbs a { color: var(--muted); text-decoration: none; }
    .leam-page-banner .crumbs a:hover { color: #fff; }

    /* ---------- Shared card ---------- */
    .leam-value-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        transition: transform .25s, border-color .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-value-card:hover {
        border-color: rgba(0,180,255,0.28);
        transform: translateY(-4px);
    }
    .leam-value-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
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
        font-size: 20px;
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
    .leam-value-card p { font-size: 14px; color: var(--muted); line-height: 1.65; margin: 0; }

    /* 3-up card grid. Built on 6 columns so a card can be offset by half a
       column — that lets an odd last row sit centred at the same width as
       every other card, instead of hanging left. */
    .leam-card-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
    }
    .leam-card-row > * { grid-column: span 2; }
    /* 5 cards: 3 on top, last 2 centred underneath */
    .leam-card-row.is-five > :nth-child(4) { grid-column: 2 / span 2; }
    /* Cards share a row height, so pin trailing content to the bottom edge */
    .leam-card-row .leam-value-card { display: flex; flex-direction: column; }
    .leam-stack-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: auto;
        padding-top: 6px;
    }

    /* ---------- Story ---------- */
    .leam-about-grid {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        gap: 64px;
        align-items: center;
    }
    .leam-about-copy p {
        font-size: 15.5px;
        color: var(--muted);
        line-height: 1.8;
        font-weight: 300;
        margin-bottom: 16px;
    }
    .leam-about-copy p:last-of-type { margin-bottom: 0; }

    /* Visual panel replacing the old emoji boxes */
    .leam-about-visual {
        position: relative;
        border-radius: 24px;
        padding: 1px;
        background: linear-gradient(150deg, rgba(0,180,255,0.35), rgba(168,85,247,0.25) 45%, rgba(255,255,255,0.04) 80%);
    }
    .leam-about-visual-inner {
        border-radius: 23px;
        background: var(--card);
        padding: 36px 32px;
        position: relative;
        overflow: hidden;
    }
    .leam-about-visual-inner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 55% at 85% 0%, rgba(0,180,255,0.14) 0%, transparent 65%),
                    radial-gradient(ellipse 60% 50% at 0% 100%, rgba(168,85,247,0.12) 0%, transparent 65%);
        pointer-events: none;
    }
    .leam-capability-list {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 12px;
    }
    .leam-capability {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 18px;
        border-radius: 14px;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border);
        transition: transform .25s, border-color .25s, background .25s;
    }
    .leam-capability:hover {
        transform: translateX(6px);
        border-color: rgba(0,180,255,0.3);
        background: rgba(255,255,255,0.05);
    }
    .leam-capability .cap-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .leam-capability .cap-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: #fff;
        line-height: 1.2;
    }
    .leam-capability .cap-desc {
        font-size: 13px;
        color: var(--muted);
        margin-top: 3px;
        line-height: 1.5;
    }
    .leam-about-badge {
        position: absolute;
        right: -14px;
        bottom: -18px;
        background: var(--card2);
        border: 1px solid var(--border-strong);
        border-radius: 16px;
        padding: 16px 22px;
        text-align: center;
        box-shadow: 0 18px 40px rgba(0,0,0,0.45);
        z-index: 2;
    }
    .leam-about-badge .big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 34px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shift 4s linear infinite;
    }
    .leam-about-badge .small {
        font-size: 11px;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 4px;
    }

    /* ---------- Stats ---------- */
    .leam-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 56px;
    }
    .leam-stat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px 20px;
        text-align: center;
        transition: transform .25s, border-color .25s;
    }
    .leam-stat-card:hover { transform: translateY(-4px); border-color: rgba(0,180,255,0.28); }
    .leam-stat-card .num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 46px;
        line-height: 1;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shift 4s linear infinite;
    }
    .leam-stat-card .label {
        font-size: 12px;
        color: var(--muted);
        margin-top: 8px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    /* ---------- Mission / Vision ---------- */
    .leam-values-bg { background: var(--dark); }
    .leam-mv-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .leam-mv-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 40px 36px;
        position: relative;
        overflow: hidden;
        transition: transform .25s, border-color .25s;
    }
    .leam-mv-card:hover { transform: translateY(-4px); border-color: rgba(0,180,255,0.28); }
    .leam-mv-card::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
    }
    .leam-mv-card.mission::before { background: radial-gradient(ellipse 60% 60% at 100% 0%, rgba(0,180,255,0.12) 0%, transparent 65%); }
    .leam-mv-card.vision::before  { background: radial-gradient(ellipse 60% 60% at 100% 0%, rgba(168,85,247,0.12) 0%, transparent 65%); }
    .leam-mv-card .mv-icon {
        width: 56px;
        height: 56px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 22px;
        position: relative;
        z-index: 1;
    }
    .leam-mv-card h4 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 30px;
        letter-spacing: 1px;
        color: #fff;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }
    .leam-mv-card p {
        font-size: 15px;
        color: var(--muted);
        line-height: 1.75;
        font-weight: 300;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* ---------- Tech stack ---------- */
    .leam-tag {
        font-size: 12px;
        padding: 5px 12px;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        border-radius: 100px;
        color: var(--muted);
        transition: color .2s, border-color .2s, background .2s;
    }
    .leam-value-card:hover .leam-tag {
        color: rgba(255,255,255,0.8);
        border-color: rgba(0,180,255,0.22);
        background: rgba(0,180,255,0.05);
    }

    /* ---------- Process timeline ---------- */
    .leam-process {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px 28px;
        position: relative;
    }
    .leam-step {
        position: relative;
        padding: 30px 26px 28px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        transition: transform .25s, border-color .25s;
    }
    .leam-step:hover { transform: translateY(-4px); border-color: rgba(0,180,255,0.28); }
    .leam-step .step-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 54px;
        line-height: 1;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.07);
        position: absolute;
        top: 16px;
        right: 22px;
        transition: color .25s;
    }
    .leam-step:hover .step-num { color: rgba(0,180,255,0.16); }
    .leam-step .step-dot {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 17px;
        color: #000;
        margin-bottom: 18px;
    }
    .leam-step h4 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 19px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    .leam-step p { font-size: 14px; color: var(--muted); line-height: 1.65; margin: 0; }

    /* ---------- CTA ---------- */
    .leam-cta-wrap {
        max-width: 900px;
        margin: 0 auto;
        background: var(--card);
        border-radius: 28px;
        padding: 60px 50px;
        text-align: center;
        position: relative;
        border: 1px solid rgba(255,255,255,0.06);
        overflow: hidden;
    }
    .leam-cta-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 70% at 50% 0%, rgba(0,180,255,0.12) 0%, transparent 70%),
                    radial-gradient(ellipse 50% 60% at 20% 100%, rgba(168,85,247,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-cta-wrap > * { position: relative; z-index: 1; }
    .leam-cta-wrap h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 5vw, 56px);
        letter-spacing: 2px;
        margin-bottom: 16px;
        color: #fff;
    }
    .leam-cta-wrap p {
        color: var(--muted);
        margin-bottom: 32px;
        font-weight: 300;
        font-size: 16px;
    }
    .leam-cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1100px) {
        .leam-about-grid { gap: 44px; }
        .leam-process { grid-template-columns: repeat(2, 1fr); }
        /* 2-up: 4 columns, cards span 2, odd card centred */
        .leam-card-row { grid-template-columns: repeat(4, 1fr); }
        .leam-card-row.is-five > :nth-child(4) { grid-column: span 2; }
        .leam-card-row.is-five > :nth-child(5) { grid-column: 2 / span 2; }
    }
    @media (max-width: 900px) {
        .leam-about-grid { grid-template-columns: 1fr; gap: 44px; }
        .leam-about-visual { max-width: 560px; margin: 0 auto; width: 100%; }
        .leam-mv-grid { grid-template-columns: 1fr; }
        .leam-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .leam-process { grid-template-columns: 1fr; }
        .leam-about-visual-inner { padding: 28px 22px; }
        .leam-about-badge { right: 12px; bottom: -16px; padding: 12px 18px; }
        .leam-about-badge .big { font-size: 28px; }
        .leam-mv-card { padding: 32px 26px; }
        .leam-cta-wrap { padding: 44px 26px; }
        /* 1-up: every card full width, no offsets */
        .leam-card-row { grid-template-columns: 1fr; }
        .leam-card-row > *,
        .leam-card-row.is-five > :nth-child(4),
        .leam-card-row.is-five > :nth-child(5) { grid-column: 1 / -1; }
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>About <span class="rainbow-text">Leamsoft</span></h1>
    <p>A next-generation IT company building AI, cloud, blockchain, and enterprise software for businesses that
        want to move faster than their competition.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; About Us</div>
</section>

<!-- STORY -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-about-grid">
            <div class="leam-about-copy">
                <div class="leam-section-label">Company Introduction</div>
                <h2 class="leam-section-title">A Next-Generation <span class="rainbow-text">IT Company</span></h2>
                <p>
                    Leamsoft Pvt Ltd. is a next-generation IT company delivering advanced software engineering, cloud
                    infrastructure, AI automation, and blockchain technology solutions.
                </p>
                <p>
                    Our team focuses on helping businesses modernize operations through scalable digital transformation.
                    We work with startups, enterprises, agencies, and growing organizations across Delhi, Noida, Greater
                    Noida, and India.
                </p>
                <p>
                    From AI-driven workflow automation to Web3 platforms and enterprise-grade cloud infrastructure —
                    Leamsoft builds the systems that power the next generation of business.
                </p>
            </div>

            <div class="leam-about-visual">
                <div class="leam-about-visual-inner">
                    <div class="leam-capability-list">
                        <div class="leam-capability">
                            <div class="cap-icon" style="background:rgba(0,180,255,0.1); color:#00b4ff;">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div>
                                <div class="cap-title">AI &amp; Automation</div>
                                <div class="cap-desc">LLM integrations and workflow automation that cut manual effort.</div>
                            </div>
                        </div>
                        <div class="leam-capability">
                            <div class="cap-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                                <i class="fas fa-link"></i>
                            </div>
                            <div>
                                <div class="cap-title">Blockchain &amp; Web3</div>
                                <div class="cap-desc">Smart contracts and decentralized platforms, audited and secure.</div>
                            </div>
                        </div>
                        <div class="leam-capability">
                            <div class="cap-icon" style="background:rgba(57,211,83,0.1); color:#39d353;">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <div>
                                <div class="cap-title">Cloud &amp; DevOps</div>
                                <div class="cap-desc">Scalable AWS infrastructure with CI/CD and monitoring built in.</div>
                            </div>
                        </div>
                        <div class="leam-capability">
                            <div class="cap-icon" style="background:rgba(255,140,0,0.1); color:#ff8c00;">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div>
                                <div class="cap-title">Product Engineering</div>
                                <div class="cap-desc">Web and mobile products shipped end-to-end by one accountable team.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="leam-about-badge">
                    <div class="big">04+</div>
                    <div class="small">Years of<br>Engineering</div>
                </div>
            </div>
        </div>

        <div class="leam-stat-grid">
            <div class="leam-stat-card">
                <div class="num">100+</div>
                <div class="label">Projects Delivered</div>
            </div>
            <div class="leam-stat-card">
                <div class="num">04+</div>
                <div class="label">Years Experience</div>
            </div>
            <div class="leam-stat-card">
                <div class="num">12+</div>
                <div class="label">Industries Served</div>
            </div>
            <div class="leam-stat-card">
                <div class="num">24/7</div>
                <div class="label">Support &amp; Monitoring</div>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="leam-section leam-values-bg">
    <div class="leam-container">
        <div class="leam-mv-grid">
            <div class="leam-mv-card mission">
                <div class="mv-icon" style="background:rgba(0,180,255,0.1); color:#00b4ff;">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h4>Our Mission</h4>
                <p>To build intelligent digital solutions that empower businesses through automation, scalability, and
                    modern technology — making advanced tech accessible to companies of every size.</p>
            </div>
            <div class="leam-mv-card vision">
                <div class="mv-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                    <i class="fas fa-binoculars"></i>
                </div>
                <h4>Our Vision</h4>
                <p>To become a leading technology company delivering innovative AI, cloud, blockchain, and enterprise
                    software solutions globally — known for craftsmanship, security, and business impact.</p>
            </div>
        </div>
    </div>
</section>

<!-- CORE VALUES -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Our Core Values</div>
            <h2 class="leam-section-title">What We <span class="rainbow-text">Stand For</span></h2>
            <p class="leam-section-sub">Five principles that guide every project we ship and every relationship we
                build.</p>
        </div>
        @php
            $values = [
                ['icon'=>'fa-lightbulb','color'=>'0,180,255','hex'=>'#00b4ff','t'=>'Innovation','d'=>'We continuously explore modern technologies and future-ready systems — staying ahead so our clients do too.'],
                ['icon'=>'fa-handshake','color'=>'168,85,247','hex'=>'#a855f7','t'=>'Transparency','d'=>'Clear communication, reliable delivery, and honest collaboration at every stage of the engagement.'],
                ['icon'=>'fa-chart-line','color'=>'57,211,83','hex'=>'#39d353','t'=>'Scalability','d'=>'We build solutions designed for long-term business growth — never quick fixes that break under load.'],
                ['icon'=>'fa-shield-alt','color'=>'255,59,92','hex'=>'#ff3b5c','t'=>'Security','d'=>'Enterprise-level security and infrastructure reliability baked in from day one — not bolted on later.'],
                ['icon'=>'fa-bolt','color'=>'255,215,0','hex'=>'#ffd700','t'=>'Performance','d'=>'Optimized systems with high-speed performance, low latency, and dependable uptime under real-world load.'],
            ];
        @endphp
        <div class="leam-card-row is-five">
            @foreach($values as $value)
                <div class="leam-value-card">
                    <div class="value-icon" style="background:rgba({{ $value['color'] }},0.1); color:{{ $value['hex'] }};">
                        <i class="fas {{ $value['icon'] }}"></i>
                    </div>
                    <h4>{{ $value['t'] }}</h4>
                    <p>{{ $value['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- TECHNOLOGIES -->
<section class="leam-section leam-values-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Tech Stack</div>
            <h2 class="leam-section-title">Technologies <span class="rainbow-text">We Work With</span></h2>
            <p class="leam-section-sub">Modern, battle-tested tools across the full engineering stack — chosen for the
                problem, not the hype.</p>
        </div>
        @php
            $stacks = [
                ['name'=>'Frontend','icon'=>'fa-paint-brush','color'=>'0,180,255','hex'=>'#00b4ff','tags'=>['React','Next.js','Vue.js','Angular','Tailwind CSS']],
                ['name'=>'Backend','icon'=>'fa-cogs','color'=>'168,85,247','hex'=>'#a855f7','tags'=>['Node.js','Laravel','PHP','Python','Express.js']],
                ['name'=>'Database','icon'=>'fa-database','color'=>'57,211,83','hex'=>'#39d353','tags'=>['MySQL','PostgreSQL','MongoDB','Redis']],
                ['name'=>'DevOps & Cloud','icon'=>'fa-cloud','color'=>'255,140,0','hex'=>'#ff8c00','tags'=>['AWS','Docker','Kubernetes','NGINX','Linux','GitHub Actions','CI/CD']],
                ['name'=>'Blockchain','icon'=>'fa-link','color'=>'255,215,0','hex'=>'#ffd700','tags'=>['Solidity','Ethereum','Polygon','Web3.js','Smart Contracts']],
                ['name'=>'AI / Automation','icon'=>'fa-robot','color'=>'255,59,92','hex'=>'#ff3b5c','tags'=>['LLM Integrations','Workflow Automation','AI APIs','Data Pipelines']],
            ];
        @endphp
        <div class="leam-card-row">
            @foreach($stacks as $stack)
                <div class="leam-value-card">
                    <div class="value-icon" style="background:rgba({{ $stack['color'] }},0.1); color:{{ $stack['hex'] }};">
                        <i class="fas {{ $stack['icon'] }}"></i>
                    </div>
                    <h4>{{ $stack['name'] }}</h4>
                    <div class="leam-stack-tags">
                        @foreach($stack['tags'] as $tag)
                            <span class="leam-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- DEVELOPMENT PROCESS -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">How We Work</div>
            <h2 class="leam-section-title">Our Development <span class="rainbow-text">Process</span></h2>
            <p class="leam-section-sub">A predictable, transparent path from idea to deployment — and beyond.</p>
        </div>
        @php
            $steps = [
                ['n'=>'01','t'=>'Requirement Analysis','d'=>'Understanding business goals, users, and technical requirements before writing a line of code.'],
                ['n'=>'02','t'=>'Planning & Architecture','d'=>'Designing scalable architecture, data models, and integration points tailored to your roadmap.'],
                ['n'=>'03','t'=>'UI / UX Design','d'=>'Wireframes, prototypes, and polished interfaces designed for engagement and conversions.'],
                ['n'=>'04','t'=>'Development','d'=>'Agile delivery with clean, documented, modern code — frontend, backend, and infrastructure.'],
                ['n'=>'05','t'=>'Testing & QA','d'=>'Automated and manual testing for functionality, performance, security, and edge cases.'],
                ['n'=>'06','t'=>'Deployment & Support','d'=>'Cloud deployment, monitoring, and dedicated long-term technical support.'],
            ];
        @endphp
        <div class="leam-process">
            @foreach($steps as $step)
                <div class="leam-step">
                    <div class="step-num">{{ $step['n'] }}</div>
                    <div class="step-dot">{{ $step['n'] }}</div>
                    <h4>{{ $step['t'] }}</h4>
                    <p>{{ $step['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="background: var(--dark); padding: 90px 24px;">
    <div class="leam-cta-wrap">
        <h2>Want to <span class="rainbow-text">Work With Us</span>?</h2>
        <p>Whether you have a fully scoped project or just an idea, we'd love to hear from you.</p>
        <div class="leam-cta-actions">
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-lg leam-btn-primary">Get in Touch ↗</a>
            <a href="{{ url('services') }}" class="leam-btn leam-btn-lg leam-btn-ghost">Explore Services</a>
        </div>
    </div>
</section>

@endsection
