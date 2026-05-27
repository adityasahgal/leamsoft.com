@extends('layouts.master')
@php
$meta_title = "Blog | LEAMSOFT — Insights on Tech, AI, and Growth";
$meta_description = "Read the LEAMSOFT blog for engineering deep-dives, AI insights, and growth strategies for modern businesses.";
$keywords = "leamsoft blog, tech insights, engineering blog, AI articles, cloud, security";
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
    .leam-page-banner .crumbs a:hover { color: #fff; }

    .leam-blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 26px;
    }
    .leam-blog-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        transition: all .25s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }
    .leam-blog-card:hover {
        transform: translateY(-5px);
        border-color: rgba(0,180,255,0.25);
        box-shadow: 0 18px 50px rgba(0,0,0,0.4);
        text-decoration: none;
        color: inherit;
    }
    .leam-blog-thumb {
        height: 200px;
        background: linear-gradient(135deg, var(--card2) 0%, #1a1a2e 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
    }
    .leam-blog-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s;
    }
    .leam-blog-card:hover .leam-blog-thumb img { transform: scale(1.06); }
    .leam-blog-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--rainbow2);
        opacity: 0;
        transition: opacity .3s;
    }
    .leam-blog-card:hover .leam-blog-thumb::after { opacity: 0.1; }
    .leam-blog-body { padding: 22px 24px 24px; flex: 1; display: flex; flex-direction: column; }
    .leam-blog-meta {
        font-size: 11.5px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: flex;
        gap: 14px;
        align-items: center;
    }
    .leam-blog-tag {
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        padding: 2px 10px;
        border-radius: 100px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 10.5px;
    }
    .leam-blog-card h3 {
        font-size: 18px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 10px;
        color: #fff;
    }
    .leam-blog-card p {
        font-size: 13.5px;
        color: var(--muted);
        line-height: 1.6;
        flex: 1;
        margin: 0 0 14px;
    }
    .leam-blog-link {
        font-size: 12.5px;
        color: #00b4ff;
        font-weight: 600;
        letter-spacing: 0.5px;
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

    .leam-pagination {
        margin-top: 48px;
        display: flex;
        justify-content: center;
        gap: 6px;
    }
    .leam-pagination a, .leam-pagination span {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--muted);
        text-decoration: none;
        font-size: 13px;
        transition: all .2s;
    }
    .leam-pagination a:hover { border-color: rgba(0,180,255,0.4); color: #fff; }
    .leam-pagination .active span,
    .leam-pagination span.active {
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        color: #000;
        font-weight: 700;
        border-color: transparent;
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>LEAMSOFT <span class="rainbow-text">Blog</span></h1>
    <p>Engineering deep-dives, AI insights, growth strategies, and field notes from the trenches.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Blog</div>
</section>

<!-- BLOG GRID -->
<section class="leam-section">
    <div class="leam-container">
        @if(isset($blogs) && $blogs->count() > 0)
            <div class="leam-blog-grid">
                @foreach($blogs as $blog)
                    <a href="{{ url('blog/'.$blog->slug) }}" class="leam-blog-card">
                        <div class="leam-blog-thumb">
                            @if(!empty($blog->thumbnail_img))
                                <img src="{{ url('storage/'.$blog->thumbnail_img) }}" alt="{{ $blog->image_alt ?? $blog->title }}">
                            @else
                                <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:42px; letter-spacing:2px;">LEAMSOFT</span>
                            @endif
                        </div>
                        <div class="leam-blog-body">
                            <div class="leam-blog-meta">
                                <span class="leam-blog-tag">Insights</span>
                                <span>{{ $blog->created_at?->format('M d, Y') }}</span>
                            </div>
                            <h3>{{ $blog->title ?? $blog->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->short_description ?? $blog->description ?? ''), 130) }}</p>
                            <span class="leam-blog-link">Read article →</span>
                        </div>
                    </a>
                @endforeach
            </div>

            @if(method_exists($blogs, 'links'))
                <div class="leam-pagination">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="leam-empty">
                <h3>No posts published yet</h3>
                <p>We're putting together our first articles. Stay tuned — or follow along on social.</p>
                <div style="margin-top:24px;">
                    <a href="{{ url('/') }}" class="leam-btn leam-btn-primary">Back to Home</a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
