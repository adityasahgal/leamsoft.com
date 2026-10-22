{{-- Services listing (route: /services) --}}
@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;

    $staticServices = [
        ['Software Development', 'Web, mobile and enterprise software engineered for scale.', ['Web application development', 'Mobile apps (iOS & Android)', 'CRM & ERP systems', 'SaaS product development', 'API development & integrations', 'UI / UX design']],
        ['AI & Machine Learning', 'Custom models, LLM integrations and intelligent automation.', ['LLM apps & AI agents', 'Computer vision', 'Predictive analytics', 'Chatbots & assistants']],
        ['Cloud Solutions', 'Migration, architecture and DevOps across AWS, Azure and GCP.', ['Cloud migration', 'DevOps & CI/CD', 'Kubernetes & containers', 'Monitoring & cost optimisation']],
        ['Cyber Security', 'Protect your applications, data and infrastructure.', ['Penetration testing', 'Security audits', 'Compliance readiness', 'Managed security']],
        ['Digital Marketing', 'Growth marketing tied to pipeline, not vanity metrics.', ['SEO', 'Performance marketing', 'Social media', 'Content marketing']],
        ['IT Consulting', 'Strategy, transformation and dedicated teams.', ['Technology strategy', 'Digital transformation', 'Dedicated teams', 'Architecture reviews']],
    ];
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Services' => null]])
        <h1>Everything you need to build, <span class="dim">run and grow software.</span></h1>
        <p class="lead">Software, AI, cloud, security and growth — delivered by one senior team for businesses across Noida, Delhi, Ghaziabad and India.</p>
        <div class="phero__cta">
            <a href="{{ url('contact-us') }}" class="btn btn--primary">Talk to our team <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            <a href="{{ url('gallery') }}" class="btn btn--ghost">See our work</a>
        </div>
    </div>
</section>

@if($categories->count() > 1)
    <nav class="jump" aria-label="Service categories">
        <div class="container">
            @foreach($categories as $cat)
                <a href="#cat-{{ $cat->slug }}">{{ $cat->name }}</a>
            @endforeach
        </div>
    </nav>
@endif

<section class="section" style="padding-top:88px">
    <div class="container">
        @if($categories->count() > 0)
            @foreach($categories as $cat)
                <div class="catb" id="cat-{{ $cat->slug }}">
                    <div class="catb__head rv">
                        <span class="cell__ico"><svg class="icon"><use href="#{{ $Ui::icon($cat->name) }}"/></svg></span>
                        <h2>{{ $cat->name }}</h2>
                        <p>{{ $Ui::excerpt($cat->short_description, 220) }}</p>
                        <a href="{{ url($cat->slug) }}" class="btn btn--ghost btn--sm">View {{ $cat->name }} <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                    </div>

                    @php
                        $children = $cat->subcategories->count()
                            ? $cat->subcategories
                            : $cat->services->take(8);
                    @endphp
                    @if($children->count())
                        <div class="sublist rv">
                            @foreach($children as $child)
                                <a href="{{ url($child->slug) }}">
                                    <svg class="icon"><use href="#i-chev-r"/></svg>
                                    <span>
                                        <strong>{{ $child->name }}</strong>
                                        <span>{{ $Ui::excerpt($child->short_description, 90) }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            @foreach($staticServices as $i => [$name, $desc, $items])
                <div class="catb">
                    <div class="catb__head rv">
                        <span class="cell__ico"><svg class="icon"><use href="#{{ $Ui::icon($name) }}"/></svg></span>
                        <h2>{{ $name }}</h2>
                        <p>{{ $desc }}</p>
                        <a href="{{ url('contact-us') }}" class="btn btn--ghost btn--sm">Get a quote <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                    </div>
                    <div class="sublist rv">
                        @foreach($items as $item)
                            <a href="{{ url('contact-us') }}"><svg class="icon"><use href="#i-chev-r"/></svg><span><strong>{{ $item }}</strong></span></a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>

@include('frontend.partials.cta', [
    'ctaTitle'     => 'Not sure which service fits? <span style="color:var(--faint)">Ask an engineer.</span>',
    'ctaText'      => 'Book a free 30-minute consultation and we’ll help you scope the right solution.',
    'ctaSecondary' => ['Read the FAQ' => url('faq')],
])
@endsection
