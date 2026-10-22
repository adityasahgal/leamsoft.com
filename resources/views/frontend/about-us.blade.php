@extends('layouts.master')

@section('content')
@php
    $values = [
        ['i-bulb',   'Innovation',   'We continuously explore modern technologies and future-ready systems — staying ahead so our clients do too.'],
        ['i-hand',   'Transparency', 'Clear communication, reliable delivery and honest collaboration at every stage of the engagement.'],
        ['i-growth', 'Scalability',  'We build solutions designed for long-term business growth — never quick fixes that break under load.'],
        ['i-shield', 'Security',     'Enterprise-level security and infrastructure reliability baked in from day one — not bolted on later.'],
        ['i-bolt',   'Performance',  'Optimised systems with high-speed performance, low latency and dependable uptime under real-world load.'],
        ['i-users',  'Ownership',    'One accountable team from the first call to production support. You always know who to talk to.'],
    ];
    $stacks = [
        ['i-monitor', 'Frontend',        ['React', 'Next.js', 'Vue.js', 'Angular', 'Tailwind CSS']],
        ['i-code',    'Backend',         ['Node.js', 'Laravel', 'PHP', 'Python', 'Express.js']],
        ['i-db',      'Database',        ['MySQL', 'PostgreSQL', 'MongoDB', 'Redis']],
        ['i-cloud',   'DevOps & Cloud',  ['AWS', 'Docker', 'Kubernetes', 'NGINX', 'Linux', 'GitHub Actions']],
        ['i-grid',    'Blockchain',      ['Solidity', 'Ethereum', 'Polygon', 'Web3.js', 'Smart contracts']],
        ['i-ai',      'AI / Automation', ['LLM integrations', 'Workflow automation', 'AI APIs', 'Data pipelines']],
    ];
    $steps = [
        ['Requirement analysis',   'Understanding business goals, users and technical requirements before writing a line of code.'],
        ['Planning & architecture', 'Designing scalable architecture, data models and integration points tailored to your roadmap.'],
        ['UI / UX design',         'Wireframes, prototypes and polished interfaces designed for engagement and conversion.'],
        ['Development',            'Agile delivery with clean, documented, modern code — frontend, backend and infrastructure.'],
        ['Testing & QA',           'Automated and manual testing for functionality, performance, security and edge cases.'],
        ['Deployment & support',   'Cloud deployment, monitoring and dedicated long-term technical support.'],
    ];
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Company' => null]])
        <h1>A next-generation IT company <span class="dim">built in Delhi NCR.</span></h1>
        <p class="lead">We build AI, cloud, blockchain and enterprise software for businesses that want to move faster than their competition.</p>
        <div class="hero__meta">
            <div><strong>100+</strong>Projects delivered</div>
            <div><strong>4+ yrs</strong>Of engineering</div>
            <div><strong>12+</strong>Industries served</div>
            <div><strong>24/7</strong>Support &amp; monitoring</div>
        </div>
    </div>
</section>

{{-- Story --}}
<section class="section">
    <div class="container split">
        <div class="copy rv">
            <span class="label">Who we are</span>
            <h2 class="h2">Software engineering, <span class="dim">done properly.</span></h2>
            <p>Leamsoft Pvt Ltd. is a next-generation IT company delivering advanced software engineering, cloud infrastructure, AI automation and blockchain technology solutions.</p>
            <p>Our team focuses on helping businesses modernise operations through scalable digital transformation. We work with startups, enterprises, agencies and growing organisations across Delhi, Noida, Greater Noida and the rest of India.</p>
            <p>From AI-driven workflow automation to Web3 platforms and enterprise-grade cloud infrastructure — Leamsoft builds the systems that power the next generation of business.</p>
        </div>
        <div class="tiles rv" style="grid-template-columns:1fr 1fr">
            <div class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-ai"/></svg></span><h3>AI &amp; automation</h3><p>LLM integrations and workflow automation that cut manual effort.</p></div>
            <div class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-grid"/></svg></span><h3>Blockchain &amp; Web3</h3><p>Smart contracts and decentralised platforms, audited and secure.</p></div>
            <div class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-cloud"/></svg></span><h3>Cloud &amp; DevOps</h3><p>Scalable AWS infrastructure with CI/CD and monitoring built in.</p></div>
            <div class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-rocket"/></svg></span><h3>Product engineering</h3><p>Web and mobile products shipped end-to-end by one accountable team.</p></div>
        </div>
    </div>
</section>

{{-- Mission & vision --}}
<section class="section section--soft">
    <div class="container">
        <div class="mv rv">
            <div>
                <span class="cell__ico"><svg class="icon"><use href="#i-target"/></svg></span>
                <span class="label">Mission</span>
                <h3>Make advanced technology accessible.</h3>
                <p>To build intelligent digital solutions that empower businesses through automation, scalability and modern technology — making advanced tech accessible to companies of every size.</p>
            </div>
            <div>
                <span class="cell__ico"><svg class="icon"><use href="#i-eye"/></svg></span>
                <span class="label">Vision</span>
                <h3>Known for craft, security and impact.</h3>
                <p>To become a leading technology company delivering innovative AI, cloud, blockchain and enterprise software solutions globally — known for craftsmanship, security and business impact.</p>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="section">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Core values</span>
                <h2 class="h2">What we stand for. <span class="dim">On every project.</span></h2>
            </div>
        </div>
        <div class="tiles rv">
            @foreach($values as [$icon, $title, $desc])
                <div class="tile"><span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span><h3>{{ $title }}</h3><p>{{ $desc }}</p></div>
            @endforeach
        </div>
    </div>
</section>

{{-- Tech stack --}}
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Tech stack</span>
                <h2 class="h2">Technologies we work with. <span class="dim">Chosen for the problem, not the hype.</span></h2>
            </div>
        </div>
        <div class="tiles rv">
            @foreach($stacks as [$icon, $title, $tags])
                <div class="tile">
                    <span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
                    <h3>{{ $title }}</h3>
                    <div class="tags" style="margin-top:14px">@foreach($tags as $tag)<span>{{ $tag }}</span>@endforeach</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process --}}
<section class="section">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">How we work</span>
                <h2 class="h2">A predictable path <span class="dim">from idea to production.</span></h2>
            </div>
        </div>
        <div class="steps steps--3 rv">
            @foreach($steps as $i => [$title, $desc])
                <div class="step"><span class="n">{{ sprintf('%02d', $i + 1) }}</span><h3>{{ $title }}</h3><p>{{ $desc }}</p></div>
            @endforeach
        </div>
    </div>
</section>

@include('frontend.partials.cta', [
    'ctaTitle' => 'Want to work with us? <span style="color:var(--faint)">We’d love to hear from you.</span>',
    'ctaText'  => 'Whether you have a fully scoped project or just an idea, let’s talk it through.',
])
@endsection
