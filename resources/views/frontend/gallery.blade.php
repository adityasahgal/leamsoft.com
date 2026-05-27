@extends('layouts.master')
@php
$meta_title = "Projects & Portfolio | LEAMSOFT";
$meta_description = "Explore selected projects from LEAMSOFT — web, mobile, AI, cloud, and security work for clients worldwide.";
$keywords = "leamsoft projects, portfolio, case studies, client work";
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
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(168,85,247,0.10) 0%, transparent 70%),
                    radial-gradient(ellipse 40% 40% at 30% 100%, rgba(0,180,255,0.08) 0%, transparent 70%);
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
        max-width: 600px;
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

    .leam-portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 22px;
    }
    .leam-portfolio-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        transition: all .25s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .leam-portfolio-card:hover {
        transform: translateY(-6px);
        border-color: rgba(168,85,247,0.3);
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        text-decoration: none;
        color: inherit;
    }
    .leam-portfolio-thumb {
        height: 240px;
        background: linear-gradient(135deg, var(--card2) 0%, #1a1a2e 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }
    .leam-portfolio-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s;
    }
    .leam-portfolio-card:hover .leam-portfolio-thumb img { transform: scale(1.05); }
    .leam-portfolio-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--rainbow2);
        opacity: 0;
        transition: opacity .3s;
    }
    .leam-portfolio-card:hover .leam-portfolio-thumb::after { opacity: 0.1; }
    .leam-portfolio-body { padding: 22px 24px 24px; }
    .leam-portfolio-tag {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 100px;
        background: rgba(168,85,247,0.1);
        color: #a855f7;
        display: inline-block;
        margin-bottom: 10px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .leam-portfolio-card h3 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #fff;
    }
    .leam-portfolio-card p {
        font-size: 13.5px;
        color: var(--muted);
        line-height: 1.6;
        margin: 0;
    }

    .leam-portfolio-filters {
        display: flex;
        gap: 8px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .leam-portfolio-filter {
        padding: 8px 16px;
        border-radius: 100px;
        background: var(--card);
        border: 1px solid var(--border);
        color: var(--muted);
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: 'Barlow', sans-serif;
    }
    .leam-portfolio-filter:hover, .leam-portfolio-filter.active {
        background: rgba(0,180,255,0.1);
        border-color: rgba(0,180,255,0.3);
        color: #00b4ff;
        text-decoration: none;
    }

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
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>Our <span class="rainbow-text">Projects</span></h1>
    <p>A selection of recent work for clients across industries — from startups to enterprise.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Projects</div>
</section>

<!-- PORTFOLIO -->
<section class="leam-section">
    <div class="leam-container">
        @php
            $portfolioServices = (isset($services) && $services->count()) ? $services : \App\Models\Service::where('status', 1)->latest()->get();
            $cats = \App\Models\Category::where('status', 1)->orderBy('sort_order')->get();
        @endphp

        @if($cats->count() > 0)
        <div class="leam-portfolio-filters">
            <a href="{{ url('gallery') }}" class="leam-portfolio-filter {{ !request('cat') ? 'active' : '' }}">All</a>
            @foreach($cats as $c)
                <a href="{{ url('gallery?cat='.$c->slug) }}" class="leam-portfolio-filter {{ request('cat') === $c->slug ? 'active' : '' }}">{{ $c->icon }} {{ $c->name }}</a>
            @endforeach
        </div>
        @endif

        @if($portfolioServices->count() > 0)
            <div class="leam-portfolio-grid">
                @foreach($portfolioServices as $key => $project)
                    @if(request('cat') && optional($project->category)->slug !== request('cat'))
                        @continue
                    @endif
                    <a href="{{ url($project->slug) }}" class="leam-portfolio-card">
                        <div class="leam-portfolio-thumb">
                            @if(!empty($project->thumbnail_img))
                                <img src="{{ url('storage/'.$project->thumbnail_img) }}" alt="{{ $project->image_alt ?? $project->name }}">
                            @else
                                <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:42px; letter-spacing:2px;">{{ $project->icon ?? 'PROJ' }}</span>
                            @endif
                        </div>
                        <div class="leam-portfolio-body">
                            <span class="leam-portfolio-tag">{{ optional($project->category)->name ?? 'Project' }}</span>
                            <h3>{{ $project->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->short_description ?? ''), 110) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="leam-empty">
                <h3>Projects coming soon</h3>
                <p>We're curating recent client work to feature here.</p>
                <div style="margin-top:24px;">
                    <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-primary">Start a Project</a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
