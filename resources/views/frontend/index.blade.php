@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;

    // ---- Services bento: live categories, or a sensible default set ----
    $bentoItems = $categories->count()
        ? $categories->map(fn ($c) => [
            'name' => $c->name,
            'url'  => url($c->slug),
            'desc' => $Ui::excerpt($c->short_description, 150),
            'subs' => $c->subcategories->take(4)->map(fn ($s) => ['name' => $s->name, 'url' => url($s->slug)])->all(),
        ])->values()->all()
        : collect([
            ['AI & Machine Learning', 'Custom models, LLM integrations and agents that automate real workflows.', ['LLM apps & agents', 'Computer vision', 'Predictive analytics', 'Workflow automation']],
            ['Software Development', 'Web platforms, internal tools and enterprise systems built to last.', ['Web applications', 'CRM & ERP', 'API development']],
            ['Cloud Solutions', 'Migration, architecture and DevOps on AWS, Azure and GCP.', ['Cloud migration', 'CI/CD pipelines', 'Monitoring']],
            ['Mobile Apps', 'Native and cross-platform apps your customers keep using.', ['iOS & Android', 'React Native', 'Flutter']],
            ['Cyber Security', 'Pentesting, audits and compliance for teams that can’t afford a breach.', ['VAPT', 'Security audits', 'ISO 27001 readiness']],
            ['Digital Marketing', 'SEO, PPC and social campaigns tied to pipeline, not vanity metrics.', ['SEO', 'Performance marketing', 'Social media']],
        ])->map(fn ($d) => [
            'name' => $d[0], 'url' => url('services'), 'desc' => $d[1],
            'subs' => array_map(fn ($s) => ['name' => $s, 'url' => url('services')], $d[2]),
        ])->all();

    // First tile spans two columns; the last tile stretches to close its row.
    $spans = array_map(fn ($i) => $i === 0 ? 2 : 1, array_keys($bentoItems));
    if ($spans) {
        $rem = array_sum($spans) % 3;
        if ($rem) {
            $spans[count($spans) - 1] += 3 - $rem;
        }
    }
    $uptimeShown = false;

    // ---- Selected work: featured services ----
    $work = $featuredServices->take(3)->values();

    // ---- Testimonials ----
    $quotes = $clients->filter(fn ($c) => !empty($c->testimonial))->take(3);
    $logos  = $clients->filter(fn ($c) => !empty($c->logo) && file_exists('storage/' . $c->logo));

    $industries = [
        ['Real estate', 'i-home'], ['Healthcare', 'i-health'], ['Construction', 'i-crane'], ['E-commerce', 'i-cart'],
        ['Education', 'i-edu'], ['Finance & fintech', 'i-bank'], ['Logistics', 'i-truck'], ['Manufacturing', 'i-factory'],
        ['Hospitality', 'i-bed'], ['Startups', 'i-rocket'], ['SaaS', 'i-cloud'], ['Agencies', 'i-growth'],
    ];

    $homeFaqs = [
        ['How much does a software project cost?', 'It depends on scope. Small websites and MVPs usually start at a few lakh rupees; larger platforms are priced per milestone. After a free discovery call we send a fixed-price or time-and-materials proposal — no hidden fees.'],
        ['How fast can you start?', 'Small projects often kick off within a week. Dedicated teams for larger engagements typically take 2–4 weeks to put together.'],
        ['Do you work with startups or only enterprises?', 'Both. Around 40% of our clients are early-stage startups; the rest range from mid-market companies to large enterprises. Our process scales up or down to match.'],
        ['Who owns the code and IP?', 'You do. All source code, designs and documentation are assigned to you on payment. No lock-in, and we’re happy to hand over to your in-house team.'],
        ['Do you offer support after launch?', 'Yes. Most clients move to a managed support plan covering monitoring, bug fixes, security patches and small enhancements, with 24/7 cover for critical systems.'],
    ];
@endphp

{{-- ================= HERO ================= --}}
<section class="hero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        <a href="{{ url('services') }}" class="announce"><b>New</b> AI agents &amp; LLM integration for your business <svg class="icon"><use href="#i-chev-r"/></svg></a>

        <div class="hero__grid">
            <h1>Software that runs <span class="dim">modern businesses.</span></h1>
            <div class="hero__side">
                <p>Leamsoft designs, builds and runs AI‑powered software, cloud platforms and mobile apps for startups and enterprises across Delhi NCR and India.</p>
                <div class="hero__cta">
                    <a href="{{ route('meeting.create') }}" class="btn btn--primary"><svg class="icon"><use href="#i-cal"/></svg>Schedule a meeting</a>
                    <a href="{{ $work->count() ? '#work' : url('gallery') }}" class="btn btn--ghost">See our work</a>
                </div>
            </div>
        </div>

        <div class="hero__meta">
            <div><strong>100+</strong>Projects delivered</div>
            <div><strong>97%</strong>Client satisfaction</div>
            <div><strong>24/7</strong>Technical support</div>
            <div><strong>4+ yrs</strong>Engineering in NCR</div>
        </div>

        {{-- Illustrative client-portal UI --}}
        <div class="shot" aria-label="Preview of the Leamsoft client portal">
            <div class="frame">
                <div class="frame__bar">
                    <div class="frame__dots"><i></i><i></i><i></i></div>
                    <div class="frame__url"><svg class="icon"><use href="#i-lock"/></svg>Client portal</div>
                </div>
                <div class="app" aria-hidden="true">
                    <aside class="app__side">
                        <div class="app__org"><i></i>Acme Industries</div>
                        <div class="app__nav on"><svg class="icon"><use href="#i-grid"/></svg>Overview</div>
                        <div class="app__nav"><svg class="icon"><use href="#i-flag"/></svg>Milestones</div>
                        <div class="app__nav"><svg class="icon"><use href="#i-rocket"/></svg>Deployments</div>
                        <div class="app__nav"><svg class="icon"><use href="#i-chat"/></svg>Support<em>3</em></div>
                        <div class="app__nav"><svg class="icon"><use href="#i-receipt"/></svg>Invoices</div>
                        <div class="app__nav"><svg class="icon"><use href="#i-file"/></svg>Documents</div>
                        <div class="app__sep"></div>
                        <div class="app__nav"><svg class="icon"><use href="#i-users"/></svg>Team</div>
                    </aside>
                    <div class="app__main">
                        <div class="app__top">
                            <div>
                                <div class="crumb">Projects / ERP Rollout</div>
                                <div class="app__title"><strong>ERP Rollout — Phase 2</strong><span class="st st--g"><i></i>On track</span></div>
                            </div>
                            <div class="app__btns"><span class="mbtn">Share</span><span class="mbtn mbtn--d">New request</span></div>
                        </div>

                        <div class="kpis">
                            <div><small>Sprint progress</small><strong>68%</strong><div class="bar"><i style="width:68%"></i></div></div>
                            <div><small>Open tickets</small><strong>3</strong><div class="bar"><i style="width:18%"></i></div></div>
                            <div><small>Uptime (30d)</small><strong>99.98%</strong><div class="bar"><i style="width:99%;background:var(--green)"></i></div></div>
                            <div><small>Next release</small><strong>Fri</strong><div class="bar"><i style="width:80%"></i></div></div>
                        </div>

                        <div class="app__cols">
                            <div class="panel">
                                <div class="panel__h">Deployments <span>last 8 weeks</span></div>
                                <div class="bars">
                                    <i style="height:38%"></i><i style="height:52%"></i><i style="height:44%"></i><i style="height:61%"></i>
                                    <i style="height:57%"></i><i style="height:72%"></i><i style="height:66%"></i><i class="b" style="height:88%"></i>
                                </div>
                                <div class="bars-x"><span>W1</span><span>W2</span><span>W3</span><span>W4</span><span>W5</span><span>W6</span><span>W7</span><span>W8</span></div>
                            </div>
                            <div class="panel">
                                <div class="panel__h">Milestones <span>4 of 6</span></div>
                                <ul class="ms">
                                    <li><span class="ck done"><svg><use href="#i-tick"/></svg></span>Discovery &amp; scope<span>Mar</span></li>
                                    <li><span class="ck done"><svg><use href="#i-tick"/></svg></span>Inventory module<span>Apr</span></li>
                                    <li><span class="ck done"><svg><use href="#i-tick"/></svg></span>Billing &amp; GST<span>May</span></li>
                                    <li><span class="ck now"></span>Vendor portal<span>Jun</span></li>
                                    <li><span class="ck todo"></span>Mobile app<span>Jul</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel__h">Recent deployments <span>production</span></div>
                            <table class="tbl">
                                <thead><tr><th>Release</th><th>Change</th><th>Status</th></tr></thead>
                                <tbody>
                                    <tr><td><code>v2.14.0</code></td><td>Vendor onboarding flow</td><td><span class="st st--g"><i></i>Live</span></td></tr>
                                    <tr><td><code>v2.13.2</code></td><td>Invoice PDF performance fix</td><td><span class="st st--g"><i></i>Live</span></td></tr>
                                    <tr><td><code>v2.13.1</code></td><td>Stock sync retry logic</td><td><span class="st st--a"><i></i>Monitoring</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= STACK STRIP ================= --}}
<section class="strip" aria-label="Technologies we work with">
    <div class="container">
        <p>Built on proven, modern technology</p>
        <ul>
            <li>Laravel</li><li>React</li><li>Node.js</li><li>Python</li><li>Flutter</li><li>AWS</li><li>OpenAI</li>
        </ul>
    </div>
</section>

{{-- ================= SERVICES ================= --}}
<section class="section" id="services">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">What we do</span>
                <h2 class="h2">One team for the whole stack. <span class="dim">From first sketch to 3 a.m. pager.</span></h2>
            </div>
            <a href="{{ url('services') }}" class="btn btn--ghost">All services <svg class="icon arr"><use href="#i-arrow"/></svg></a>
        </div>

        <div class="bento rv">
            @foreach($bentoItems as $i => $item)
                @php $span = $spans[$i]; $icon = $Ui::icon($item['name']); @endphp

                @if($span === 3)
                    <div class="cell cell--3">
                        <div>
                            <span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
                            <h3>{{ $item['name'] }}</h3>
                            <p>{{ $item['desc'] }}</p>
                            <a href="{{ $item['url'] }}" class="tlink">Explore {{ $item['name'] }} <svg class="icon"><use href="#i-arrow"/></svg></a>
                        </div>
                        @if($item['subs'])
                            <ul>
                                @foreach($item['subs'] as $sub)
                                    <li><a href="{{ $sub['url'] }}">{{ $sub['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @elseif($span === 2 && $i === 0)
                    <div class="cell cell--2">
                        <div class="cell__split">
                            <div>
                                <span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
                                <h3>{{ $item['name'] }}</h3>
                                <p>{{ $item['desc'] }}</p>
                                @if($item['subs'])
                                    <ul>
                                        @foreach($item['subs'] as $sub)
                                            <li><a href="{{ $sub['url'] }}">{{ $sub['name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                                <a href="{{ $item['url'] }}" class="tlink">Explore {{ $item['name'] }} <svg class="icon"><use href="#i-arrow"/></svg></a>
                            </div>
                            <div class="run" aria-hidden="true">
                                <div class="run__q"><small>agent · ops-assistant</small>Summarise yesterday’s orders and flag anything unusual.</div>
                                <div class="run__steps">
                                    <div><svg><use href="#i-check"/></svg>Queried orders database<code>0.4s</code></div>
                                    <div><svg><use href="#i-check"/></svg>Compared with 30-day baseline<code>1.1s</code></div>
                                    <div><svg><use href="#i-check"/></svg>Found 2 anomalies in returns<code>0.3s</code></div>
                                    <div><svg><use href="#i-check"/></svg>Posted summary to Slack<code>0.2s</code></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $showUptime = !$uptimeShown && $span === 1 && $icon === 'i-cloud';
                        $uptimeShown = $uptimeShown || $showUptime;
                    @endphp
                    <div class="cell {{ $span === 2 ? 'cell--2' : '' }}">
                        <span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
                        <h3>{{ $item['name'] }}</h3>
                        <p>{{ $item['desc'] }}</p>
                        @if($showUptime)
                            <div class="upt" aria-hidden="true">
                                <div class="upt__row">
                                    @for($b = 0; $b < 30; $b++)<i @class(['w' => in_array($b, [9, 22])])></i>@endfor
                                </div>
                                <div class="upt__meta"><span>30 days ago</span><span>99.98% uptime</span><span>today</span></div>
                            </div>
                        @elseif($item['subs'])
                            <ul>
                                @foreach(array_slice($item['subs'], 0, 3) as $sub)
                                    <li><a href="{{ $sub['url'] }}">{{ $sub['name'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ $item['url'] }}" class="tlink">Learn more <svg class="icon"><use href="#i-arrow"/></svg></a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ================= WORK ================= --}}
@if($work->count())
<section class="section section--soft" id="work">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Selected work</span>
                <h2 class="h2">Systems our clients run on. <span class="dim">Every day.</span></h2>
            </div>
            <a href="{{ url('gallery') }}" class="btn btn--ghost">All work <svg class="icon arr"><use href="#i-arrow"/></svg></a>
        </div>

        <div class="work">
            @foreach($work as $i => $svc)
                @php
                    $thumb = $svc->thumb_url
                        ?? optional($svc->subcategory)->thumb_url
                        ?? optional($svc->category)->thumb_url;
                @endphp
                <article class="case rv {{ $i === 0 ? 'case--wide' : '' }}">
                    <div class="case__vis">
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $svc->image_alt ?? $svc->name }}" loading="lazy" decoding="async">
                        @elseif($i % 3 === 0)
                            <div class="mock" aria-hidden="true">
                                <div class="mock__h">Estimate #1042 <span>auto-generated</span></div>
                                <table class="boq">
                                    <thead><tr><th>#</th><th>Item</th><th>Qty</th><th>Amount</th></tr></thead>
                                    <tbody>
                                        <tr><td>01</td><td>Discovery &amp; UX</td><td>1</td><td>₹1,20,000</td></tr>
                                        <tr><td>02</td><td>Web platform</td><td>1</td><td>₹4,80,000</td></tr>
                                        <tr><td>03</td><td>Mobile app</td><td>2</td><td>₹3,60,000</td></tr>
                                        <tr><td>04</td><td>Cloud setup</td><td>1</td><td>₹90,000</td></tr>
                                        <tr class="tot"><td></td><td>Total</td><td></td><td>₹10,50,000</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        @elseif($i % 3 === 1)
                            <div class="mock site" aria-hidden="true">
                                <div class="site__nav"><b>BRAND</b><i></i><i></i><i></i></div>
                                <div class="site__hero">
                                    <div><div class="t1"></div><div class="t2"></div><div class="t3"></div><div class="t4"></div><div class="b"></div></div>
                                    <div class="site__img"><svg viewBox="0 0 200 80" preserveAspectRatio="none"><path d="M0 80 50 35l30 25 45-45 75 65Z" fill="#c9d4e5"/></svg></div>
                                </div>
                                <div class="site__row"><div></div><div></div><div></div></div>
                            </div>
                        @else
                            <div class="i2v" aria-hidden="true">
                                <div class="i2v__tile"><div class="img"></div><small>IMG</small></div>
                                <span class="i2v__arrow"><svg class="icon"><use href="#i-arrow"/></svg></span>
                                <div class="i2v__tile"><div class="img" style="filter:hue-rotate(40deg)"></div><small>MP4</small><div class="tl"><svg><use href="#i-play"/></svg><i></i></div></div>
                            </div>
                        @endif
                    </div>
                    <div class="case__body">
                        <span class="case__client">{{ optional($svc->category)->name ?? 'Featured' }}</span>
                        <h3>{{ $svc->name }}</h3>
                        <p>{{ $Ui::excerpt($svc->short_description ?? $svc->description, $i === 0 ? 220 : 140) }}</p>
                        @if($svc->category || $svc->subcategory)
                            <div class="tags">
                                @if($svc->category)<span>{{ $svc->category->name }}</span>@endif
                                @if($svc->subcategory)<span>{{ $svc->subcategory->name }}</span>@endif
                            </div>
                        @endif
                        <a href="{{ url($svc->slug) }}" class="tlink">View details <svg class="icon"><use href="#i-arrow"/></svg></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================= WHY ================= --}}
<section class="section">
    <div class="container why">
        <div class="rv">
            <span class="label">Why Leamsoft</span>
            <h2 class="h2">Senior engineers. Clear plans. <span class="dim">No surprises.</span></h2>
            <p class="lead">We keep teams small and senior, show working software every week, and put everything in writing — so you always know where your project stands.</p>
            <div class="hero__cta"><a href="{{ url('about-us') }}" class="btn btn--ghost">About the company <svg class="icon arr"><use href="#i-arrow"/></svg></a></div>
        </div>
        <div class="why__grid rv">
            <div class="big">
                <span class="n">01</span>
                <strong>97%</strong>
                <p>of clients rate us 5/5 and most come back for the next project.</p>
            </div>
            <div>
                <span class="n">02</span>
                <h3>The team you meet builds it</h3>
                <p>No bait-and-switch. Engineers with years of shipped work lead your project end to end.</p>
            </div>
            <div>
                <span class="n">03</span>
                <h3>Weekly demos, written scope</h3>
                <p>Two-week sprints, a live staging link and a fixed scope document — progress you can check.</p>
            </div>
            <div class="big">
                <span class="n">04</span>
                <strong>100%</strong>
                <p>of the code, designs and IP belong to you. No lock-in, ever.</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= PROCESS ================= --}}
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">How we work</span>
                <h2 class="h2">From first call to production <span class="dim">in four steps.</span></h2>
            </div>
        </div>
        <div class="steps rv">
            <div class="step"><span class="n">01</span><h3>Discover</h3><p>A free call to understand your goals, users and constraints. We ask a lot of questions.</p><small>Week 0</small></div>
            <div class="step"><span class="n">02</span><h3>Plan &amp; design</h3><p>Written scope, architecture and clickable designs — with a fixed price or clear estimate.</p><small>Week 1–2</small></div>
            <div class="step"><span class="n">03</span><h3>Build &amp; ship</h3><p>Two-week sprints with a demo every week. You see working software early and often.</p><small>Sprints</small></div>
            <div class="step"><span class="n">04</span><h3>Run &amp; grow</h3><p>Deployment, monitoring and 24/7 support, plus a roadmap for what comes next.</p><small>Ongoing</small></div>
        </div>
    </div>
</section>

{{-- ================= INDUSTRIES ================= --}}
<section class="section">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Industries</span>
                <h2 class="h2">Built for how your industry <span class="dim">actually works.</span></h2>
            </div>
            <p class="lead" style="margin-top:0;max-width:420px">From real estate to fintech, we’ve shipped software for businesses across India and beyond.</p>
        </div>
        <ul class="inds rv">
            @foreach($industries as [$name, $icon])
                <li><svg class="icon"><use href="#{{ $icon }}"/></svg>{{ $name }}</li>
            @endforeach
        </ul>
    </div>
</section>

{{-- ================= TESTIMONIALS ================= --}}
@if($quotes->count() || $logos->count())
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Clients</span>
                <h2 class="h2">Teams that trust us <span class="dim">with the important stuff.</span></h2>
            </div>
        </div>

        @if($quotes->count())
            <div class="quotes">
                @foreach($quotes as $client)
                    @php $hasLogo = !empty($client->logo) && file_exists('storage/' . $client->logo); @endphp
                    <figure class="quote rv" style="margin:0">
                        <blockquote>“{{ $Ui::excerpt($client->testimonial, 260) }}”</blockquote>
                        <figcaption>
                            @if($hasLogo)
                                <img src="{{ url('storage/' . $client->logo) }}" alt="{{ $client->image_alt ?? $client->name }}" loading="lazy" decoding="async">
                            @else
                                <span class="av">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($client->name, 0, 1)) }}</span>
                            @endif
                            <span>
                                @if(!empty($client->website))
                                    <a href="{{ $client->website }}" target="_blank" rel="noopener"><strong>{{ $client->name }}</strong></a>
                                @else
                                    <strong>{{ $client->name }}</strong>
                                @endif
                                <small>{{ trim(($client->designation ?? '') . (($client->designation && $client->company) ? ', ' : '') . ($client->company ?? '')) }}</small>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif

        @if($logos->count())
            <div class="logos rv" @style(['margin-top:56px' => $quotes->count()])>
                @foreach($logos as $client)
                    <img src="{{ url('storage/' . $client->logo) }}" alt="{{ $client->image_alt ?? $client->name }}" loading="lazy" decoding="async">
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

{{-- ================= BLOG ================= --}}
@if($latestBlogs->count())
<section class="section">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Blog</span>
                <h2 class="h2">Latest on AI <span class="dim">and innovation.</span></h2>
            </div>
            <a href="{{ url('blog') }}" class="btn btn--ghost">All posts <svg class="icon arr"><use href="#i-arrow"/></svg></a>
        </div>
        <div class="cards">
            @foreach($latestBlogs as $blog)
                @include('frontend.partials.blog-card', ['blog' => $blog])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================= FAQ ================= --}}
<section class="section section--soft">
    <div class="container faq">
        <div class="rv">
            <span class="label">FAQ</span>
            <h2 class="h2">Questions we hear <span class="dim">every week.</span></h2>
            <p class="lead">Still unsure? Ask us directly — we reply within one business day.</p>
            <div class="hero__cta"><a href="{{ url('faq') }}" class="btn btn--ghost">All FAQs <svg class="icon arr"><use href="#i-arrow"/></svg></a></div>
        </div>
        <div class="rv">
            @foreach($homeFaqs as [$q, $a])
                <details>
                    <summary>{{ $q }} <svg class="icon"><use href="#i-plus"/></svg></summary>
                    <p>{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= CONTACT ================= --}}
<section class="section">
    <div class="container">
        @include('frontend.partials.contact')
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $homeFaqs),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@endsection
