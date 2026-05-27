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
        .leam-mv-grid { grid-template-columns: 1fr !important; }
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>About <span class="rainbow-text">Leamsoft</span></h1>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; About Us</div>
</section>

<!-- STORY -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-about-grid">
            <div>
                <div class="leam-section-label">Company Introduction</div>
                <h2 class="leam-section-title">A Next-Generation <span class="rainbow-text">IT Company</span></h2>
                <p class="leam-section-sub" style="margin-bottom: 18px;">
                    Leamsoft Pvt Ltd. is a next-generation IT company delivering advanced software engineering, cloud infrastructure, AI automation, and blockchain technology solutions.
                </p>
                <p class="leam-section-sub" style="margin-bottom: 18px;">
                    Our team focuses on helping businesses modernize operations through scalable digital transformation. We work with startups, enterprises, agencies, and growing organizations across Delhi, Noida, Greater Noida, and India.
                </p>
                <p class="leam-section-sub">
                    From AI-driven workflow automation to Web3 platforms and enterprise-grade cloud infrastructure — Leamsoft builds the systems that power the next generation of business.
                </p>

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
                </div>
            </div>
            <div class="leam-about-images">
                <div class="img-box">🤖</div>
                <div class="img-box">⛓️</div>
                <div class="img-box">☁️</div>
                <div class="img-box">🚀</div>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="leam-section leam-values-bg">
    <div class="leam-container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;" class="leam-mv-grid">
            <div class="leam-value-card" style="padding:36px;">
                <div class="value-icon" style="background:rgba(0,180,255,0.1);">🎯</div>
                <h4 style="font-size:22px;">Our Mission</h4>
                <p style="font-size:15px;">To build intelligent digital solutions that empower businesses through automation, scalability, and modern technology — making advanced tech accessible to companies of every size.</p>
            </div>
            <div class="leam-value-card" style="padding:36px;">
                <div class="value-icon" style="background:rgba(168,85,247,0.1);">🔭</div>
                <h4 style="font-size:22px;">Our Vision</h4>
                <p style="font-size:15px;">To become a leading technology company delivering innovative AI, cloud, blockchain, and enterprise software solutions globally — known for craftsmanship, security, and business impact.</p>
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
            <p class="leam-section-sub">Five principles that guide every project we ship and every relationship we build.</p>
        </div>
        <div class="leam-values-grid">
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(0,180,255,0.1);">💡</div>
                <h4>Innovation</h4>
                <p>We continuously explore modern technologies and future-ready systems — staying ahead so our clients do too.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(168,85,247,0.1);">🤝</div>
                <h4>Transparency</h4>
                <p>Clear communication, reliable delivery, and honest collaboration at every stage of the engagement.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(57,211,83,0.1);">📈</div>
                <h4>Scalability</h4>
                <p>We build solutions designed for long-term business growth — never quick fixes that break under load.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(255,59,92,0.1);">🛡️</div>
                <h4>Security</h4>
                <p>Enterprise-level security and infrastructure reliability baked in from day one — not bolted on later.</p>
            </div>
            <div class="leam-value-card">
                <div class="value-icon" style="background:rgba(255,215,0,0.1);">⚡</div>
                <h4>Performance</h4>
                <p>Optimized systems with high-speed performance, low latency, and dependable uptime under real-world load.</p>
            </div>
        </div>
    </div>
</section>

<!-- TECHNOLOGIES -->
<section class="leam-section leam-values-bg">
    <div class="leam-container">
        <div class="leam-section-head">
            <div class="leam-section-label">Tech Stack</div>
            <h2 class="leam-section-title">Technologies <span class="rainbow-text">We Work With</span></h2>
            <p class="leam-section-sub">Modern, battle-tested tools across the full engineering stack — chosen for the problem, not the hype.</p>
        </div>
        <div class="leam-values-grid">
            @php
                $stacks = [
                    ['name'=>'Frontend','icon'=>'🎨','tags'=>['React','Next.js','Vue.js','Angular','Tailwind CSS']],
                    ['name'=>'Backend','icon'=>'⚙️','tags'=>['Node.js','Laravel','PHP','Python','Express.js']],
                    ['name'=>'Database','icon'=>'🗄️','tags'=>['MySQL','PostgreSQL','MongoDB','Redis']],
                    ['name'=>'DevOps &amp; Cloud','icon'=>'☁️','tags'=>['AWS','Docker','Kubernetes','NGINX','Linux','GitHub Actions','CI/CD']],
                    ['name'=>'Blockchain','icon'=>'⛓️','tags'=>['Solidity','Ethereum','Polygon','Web3.js','Smart Contracts']],
                    ['name'=>'AI / Automation','icon'=>'🤖','tags'=>['LLM Integrations','Workflow Automation','AI APIs','Data Pipelines']],
                ];
            @endphp
            @foreach($stacks as $stack)
                <div class="leam-value-card">
                    <div class="value-icon" style="background:rgba(0,180,255,0.1);">{!! $stack['icon'] !!}</div>
                    <h4>{!! $stack['name'] !!}</h4>
                    <div style="display:flex; flex-wrap:wrap; gap:6px; margin-top:6px;">
                        @foreach($stack['tags'] as $tag)
                            <span style="font-size:12px; padding:4px 10px; background:rgba(255,255,255,0.04); border:1px solid var(--border); border-radius:100px; color:var(--muted);">{{ $tag }}</span>
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
        <div class="leam-values-grid">
            @php
                $steps = [
                    ['n'=>'01','t'=>'Requirement Analysis','d'=>'Understanding business goals, users, and technical requirements before writing a line of code.'],
                    ['n'=>'02','t'=>'Planning &amp; Architecture','d'=>'Designing scalable architecture, data models, and integration points tailored to your roadmap.'],
                    ['n'=>'03','t'=>'UI / UX Design','d'=>'Wireframes, prototypes, and polished interfaces designed for engagement and conversions.'],
                    ['n'=>'04','t'=>'Development','d'=>'Agile delivery with clean, documented, modern code — frontend, backend, and infrastructure.'],
                    ['n'=>'05','t'=>'Testing &amp; QA','d'=>'Automated and manual testing for functionality, performance, security, and edge cases.'],
                    ['n'=>'06','t'=>'Deployment &amp; Support','d'=>'Cloud deployment, monitoring, and dedicated long-term technical support.'],
                ];
            @endphp
            @foreach($steps as $step)
                <div class="leam-value-card">
                    <div class="value-icon rainbow-text" style="background:rgba(255,255,255,0.04); font-family:'Bebas Neue', sans-serif; font-size:22px;">{{ $step['n'] }}</div>
                    <h4>{!! $step['t'] !!}</h4>
                    <p>{{ $step['d'] }}</p>
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
