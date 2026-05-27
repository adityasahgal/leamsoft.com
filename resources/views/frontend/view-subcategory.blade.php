@extends('layouts.master')

@section('meta_title'){{ $subcategory->meta_title ?? $subcategory->name }}@stop
@section('meta_description'){{ $subcategory->meta_description ?? $subcategory->short_description }}@stop
@section('meta_keywords'){{ $subcategory->keywords }}@stop

@section('content')
<style>
    .leam-sub-hero {
        padding: 80px 24px 60px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-sub-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0,180,255,0.10) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-sub-hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .leam-sub-hero .meta {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 14px;
    }
    .leam-sub-hero .meta a { color: var(--muted); text-decoration: none; }
    .leam-sub-hero .meta a:hover { color: #fff; }
    .leam-sub-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(40px, 6vw, 68px);
        letter-spacing: 2px;
        line-height: 1;
        margin: 0 0 16px;
        color: #fff;
    }
    .leam-sub-hero .icon-big {
        font-size: 64px;
        margin-bottom: 18px;
    }
    .leam-sub-hero p {
        font-size: 16px;
        color: var(--muted);
        max-width: 640px;
        margin: 0 auto 28px;
        line-height: 1.7;
        font-weight: 300;
    }

    .leam-service-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 22px;
    }
    .leam-service-tile {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        transition: all .25s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .leam-service-tile:hover {
        transform: translateY(-6px);
        border-color: rgba(0,180,255,0.25);
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        text-decoration: none;
        color: inherit;
    }
    .leam-service-tile-thumb {
        height: 200px;
        background: linear-gradient(135deg, var(--card2) 0%, #1a1a2e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        position: relative;
        overflow: hidden;
    }
    .leam-service-tile-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s;
    }
    .leam-service-tile:hover .leam-service-tile-thumb img { transform: scale(1.05); }
    .leam-service-tile-body { padding: 22px 24px 24px; }
    .leam-service-tile .tag {
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
    .leam-service-tile h3 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #fff;
    }
    .leam-service-tile p {
        font-size: 13.5px;
        color: var(--muted);
        line-height: 1.6;
        margin: 0 0 14px;
    }
    .leam-service-tile .arrow {
        color: #00b4ff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .leam-sub-desc-block {
        padding: 70px 24px;
        background: var(--dark);
        border-top: 1px solid var(--border);
    }
    .leam-sub-desc-content {
        max-width: 800px;
        margin: 0 auto;
        font-size: 16px;
        color: var(--muted);
        line-height: 1.8;
        font-weight: 300;
    }
    .leam-sub-desc-content h2, .leam-sub-desc-content h3 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 1px;
        margin-top: 32px;
        margin-bottom: 14px;
    }
</style>

<!-- SUBCATEGORY HERO -->
<section class="leam-sub-hero">
    <div class="leam-sub-hero-inner">
        <div class="meta">
            <a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp;
            <a href="{{ url('services') }}">Services</a> &nbsp;›&nbsp;
            @if($categories)
                <a href="{{ url($categories->slug) }}">{{ $categories->name }}</a> &nbsp;›&nbsp;
            @endif
            <span style="color:#00b4ff;">{{ $subcategory->name }}</span>
        </div>
        <div class="icon-big">{{ $subcategory->icon ?? '🔧' }}</div>
        <h1>{{ $subcategory->name }}</h1>
        <p>{{ $subcategory->short_description }}</p>
        <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-primary">Request a Quote ↗</a>
    </div>
</section>

<!-- SERVICES UNDER THIS SUBCATEGORY -->
@if($services->count() > 0)
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">Services</div>
            <h2 class="leam-section-title">{{ $subcategory->name }} <span class="rainbow-text">offerings</span></h2>
        </div>
        <div class="leam-service-card-grid">
            @foreach($services as $service)
                <a href="{{ url($service->slug) }}" class="leam-service-tile">
                    <div class="leam-service-tile-thumb">
                        @if(!empty($service->thumbnail_img))
                            <img src="{{ url('storage/'.$service->thumbnail_img) }}" alt="{{ $service->image_alt ?? $service->name }}">
                        @else
                            <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:42px; letter-spacing:2px;">{{ $service->icon ?? 'SVC' }}</span>
                        @endif
                    </div>
                    <div class="leam-service-tile-body">
                        <span class="tag">{{ $subcategory->name }}</span>
                        <h3>{{ $service->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->short_description ?? ''), 110) }}</p>
                        <span class="arrow">View details →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="leam-section">
    <div class="leam-container" style="text-align:center; padding: 60px 20px;">
        <h3 style="font-family:'Bebas Neue'; font-size:28px; color:#fff;">No services listed yet</h3>
        <p style="color:var(--muted); margin: 12px 0 24px;">We're working on it. In the meantime, reach out — we'd love to build with you.</p>
        <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-primary">Contact Us</a>
    </div>
</section>
@endif

<!-- DESCRIPTION -->
@if(!empty($subcategory->description))
<section class="leam-sub-desc-block">
    <div class="leam-sub-desc-content">
        <div class="leam-section-label">More about</div>
        <h2 class="leam-section-title" style="margin-bottom:24px;">{{ $subcategory->name }} <span class="rainbow-text">in detail</span></h2>
        {!! $subcategory->description !!}
    </div>
</section>
@endif

@endsection
