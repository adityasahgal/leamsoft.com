@extends('layouts.master')

@section('meta_title'){{ $blogDetail->meta_title ?? $blogDetail->title ?? $blogDetail->name }}@stop
@section('meta_description'){{ $blogDetail->meta_description ?? $blogDetail->short_description }}@stop
@section('meta_keywords'){{ $blogDetail->keywords }}@stop

@section('content')
<style>
    .leam-article-hero {
        padding: 80px 24px 50px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-article-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0,180,255,0.10) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-article-hero-inner {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .leam-article-meta {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 16px;
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .leam-article-meta a { color: var(--muted); text-decoration: none; }
    .leam-article-meta a:hover { color: #fff; }
    .leam-article-meta .leam-blog-tag {
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        padding: 3px 12px;
        border-radius: 100px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .leam-article-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 6vw, 64px);
        letter-spacing: 1.5px;
        line-height: 1.05;
        margin: 0 0 18px;
        color: #fff;
    }
    .leam-article-hero p.dek {
        font-size: 17px;
        color: var(--muted);
        line-height: 1.7;
        margin: 0 0 24px;
        font-weight: 300;
    }

    .leam-article-cover {
        max-width: 1100px;
        margin: -30px auto 0;
        padding: 0 24px;
        position: relative;
        z-index: 2;
    }
    .leam-article-cover img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
        border-radius: 22px;
        border: 1px solid var(--border);
    }

    .leam-article-body {
        max-width: 760px;
        margin: 50px auto 0;
        padding: 0 24px 70px;
        font-size: 17px;
        color: rgba(255,255,255,0.85);
        line-height: 1.8;
        font-weight: 300;
    }
    .leam-article-body h2, .leam-article-body h3, .leam-article-body h4 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 1px;
        margin-top: 40px;
        margin-bottom: 14px;
    }
    .leam-article-body h2 { font-size: 36px; }
    .leam-article-body h3 { font-size: 28px; }
    .leam-article-body h4 { font-size: 22px; }
    .leam-article-body p { margin-bottom: 18px; }
    .leam-article-body a { color: #00b4ff; text-decoration: underline; text-decoration-color: rgba(0,180,255,0.4); }
    .leam-article-body a:hover { text-decoration-color: #00b4ff; }
    .leam-article-body blockquote {
        border-left: 3px solid #00b4ff;
        padding: 14px 22px;
        background: var(--card);
        border-radius: 0 12px 12px 0;
        margin: 24px 0;
        color: #fff;
        font-style: italic;
    }
    .leam-article-body ul, .leam-article-body ol { padding-left: 24px; margin: 16px 0 22px; }
    .leam-article-body li { margin-bottom: 8px; }
    .leam-article-body code {
        background: rgba(255,255,255,0.08);
        padding: 2px 7px;
        border-radius: 5px;
        font-family: monospace;
        font-size: 14px;
    }
    .leam-article-body pre {
        background: #0a0a0a;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px 22px;
        overflow-x: auto;
        margin: 22px 0;
    }
    .leam-article-body img {
        max-width: 100%;
        border-radius: 12px;
        margin: 22px 0;
        border: 1px solid var(--border);
    }

    .leam-article-share {
        max-width: 760px;
        margin: 0 auto;
        padding: 28px 24px;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
    }
    .leam-article-share .label {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
    }
    .leam-article-share-btns { display: flex; gap: 8px; }
    .leam-article-share-btns a {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        text-decoration: none;
        transition: all .2s;
    }
    .leam-article-share-btns a:hover { border-color: rgba(0,180,255,0.4); color: #00b4ff; }

    .leam-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 22px;
    }
</style>

<!-- ARTICLE HERO -->
<section class="leam-article-hero">
    <div class="leam-article-hero-inner">
        <div class="leam-article-meta">
            <a href="{{ url('blog') }}">← All Posts</a>
            <span class="leam-blog-tag">Insights</span>
            <span>{{ $blogDetail->created_at?->format('F d, Y') }}</span>
        </div>
        <h1>{{ $blogDetail->title ?? $blogDetail->name }}</h1>
        @if(!empty($blogDetail->short_description))
            <p class="dek">{{ $blogDetail->short_description }}</p>
        @endif
    </div>
</section>

<!-- COVER IMAGE -->
@if(!empty($blogDetail->thumbnail_img))
<div class="leam-article-cover">
    <img src="{{ url('storage/'.$blogDetail->thumbnail_img) }}" alt="{{ $blogDetail->image_alt ?? $blogDetail->title }}">
</div>
@endif

<!-- BODY -->
<article class="leam-article-body">
    {!! $blogDetail->description !!}
</article>

<!-- SHARE -->
<div class="leam-article-share">
    <span class="label">Share this article</span>
    <div class="leam-article-share-btns">
        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank" title="Share on X"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" title="Share on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" title="Share on Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="mailto:?subject={{ urlencode($blogDetail->title ?? '') }}&body={{ url()->current() }}" title="Share by Email"><i class="fas fa-envelope"></i></a>
    </div>
</div>

<!-- RELATED -->
@if(!empty($related) && $related->count() > 0)
<section class="leam-section" style="background: var(--dark); border-top: 1px solid var(--border);">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">Keep reading</div>
            <h2 class="leam-section-title">Related <span class="rainbow-text">Posts</span></h2>
        </div>
        <div class="leam-related-grid">
            @foreach($related as $rel)
                <a href="{{ url('blog/'.$rel->slug) }}" style="background:var(--card); border:1px solid var(--border); border-radius:14px; overflow:hidden; text-decoration:none; color:inherit; display:block; transition:all .25s;"
                   onmouseover="this.style.borderColor='rgba(0,180,255,0.3)'; this.style.transform='translateY(-3px)';"
                   onmouseout="this.style.borderColor='var(--border)'; this.style.transform='';">
                    <div style="height:160px; background: linear-gradient(135deg, var(--card2), #1a1a2e); display:flex; align-items:center; justify-content:center;">
                        @if(!empty($rel->thumbnail_img))
                            <img src="{{ url('storage/'.$rel->thumbnail_img) }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:32px; letter-spacing:2px;">LEAMSOFT</span>
                        @endif
                    </div>
                    <div style="padding:18px 20px;">
                        <div style="font-size:11.5px; color:var(--muted); letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">{{ $rel->created_at?->format('M d, Y') }}</div>
                        <h4 style="font-size:15.5px; color:#fff; font-weight:600; line-height:1.4; margin:0;">{{ $rel->title ?? $rel->name }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
