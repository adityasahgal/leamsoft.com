@extends('layouts.master')


@section('content')
<style>
    .leam-article-hero {
        padding: 80px 24px 46px;
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
        max-width: 820px;
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
        align-items: center;
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
        margin: 0 auto;
        max-width: 640px;
        font-weight: 300;
    }

    .leam-article-cover {
        max-width: 1120px;
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
        display: block;
    }

    /* ---- 2-column layout: article + sticky TOC sidebar ---- */
    .leam-article-layout {
        max-width: 1120px;
        margin: 50px auto 0;
        padding: 0 24px 70px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 56px;
        align-items: start;
    }
    .leam-article-layout.no-toc { grid-template-columns: minmax(0, 760px); justify-content: center; }

    .leam-article-body {
        font-size: 17px;
        color: rgba(255,255,255,0.85);
        line-height: 1.8;
        font-weight: 300;
        min-width: 0;
    }
    .leam-article-body h2, .leam-article-body h3, .leam-article-body h4 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 1px;
        margin-top: 42px;
        margin-bottom: 14px;
        scroll-margin-top: 100px;
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
        height: auto;
        border-radius: 12px;
        margin: 22px 0;
        border: 1px solid var(--border);
    }
    .leam-article-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 22px 0;
        display: block;
        overflow-x: auto;
    }
    .leam-article-body th, .leam-article-body td {
        border: 1px solid var(--border);
        padding: 10px 14px;
        text-align: left;
    }
    .leam-article-body th { background: var(--card); color: #fff; }

    /* ---- TOC sidebar ---- */
    .leam-toc {
        position: sticky;
        top: 96px;
        align-self: start;
    }
    .leam-toc-inner {
        border: 1px solid var(--border);
        border-radius: 16px;
        background: var(--card);
        padding: 20px 20px 22px;
        max-height: calc(100vh - 130px);
        overflow-y: auto;
    }
    .leam-toc-title {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }
    .leam-toc-title i { color: #00b4ff; }
    .leam-toc ul { list-style: none; margin: 0; padding: 0; }
    .leam-toc li { margin: 0; }
    .leam-toc a {
        display: block;
        padding: 6px 12px;
        font-size: 13.5px;
        line-height: 1.45;
        color: var(--muted);
        text-decoration: none;
        border-left: 2px solid transparent;
        transition: color .2s, border-color .2s, background .2s;
        border-radius: 0 6px 6px 0;
    }
    .leam-toc a:hover { color: #fff; background: rgba(255,255,255,0.04); }
    .leam-toc a.toc-h3 { padding-left: 26px; font-size: 12.5px; }
    .leam-toc a.toc-h4 { padding-left: 40px; font-size: 12px; }
    .leam-toc a.active {
        color: #00b4ff;
        border-left-color: #00b4ff;
        background: rgba(0,180,255,0.06);
        font-weight: 600;
    }

    /* ---- share ---- */
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

    @media (max-width: 900px) {
        .leam-article-layout, .leam-article-layout.no-toc {
            grid-template-columns: minmax(0, 1fr);
            gap: 34px;
        }
        .leam-toc { position: static; order: -1; top: auto; }
        .leam-toc-inner { max-height: none; }
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
        <h1>{{ $blogDetail->name }}</h1>
        @if(!empty($blogDetail->short_description))
            <p class="dek">{{ $blogDetail->short_description }}</p>
        @endif
    </div>
</section>

<!-- COVER IMAGE -->
@if(!empty($blogDetail->banner))
<div class="leam-article-cover">
    <img src="{{ url('storage/'.$blogDetail->banner) }}" alt="{{ $blogDetail->image_alt ?? $blogDetail->name }}">
</div>
@endif

<!-- BODY + TOC -->
<div class="leam-article-layout" id="leamArticleLayout">
    <article class="leam-article-body" id="leamArticleBody">
        {!! $blogDetail->description !!}
    </article>

    <aside class="leam-toc" id="leamToc" style="display:none;">
        <div class="leam-toc-inner">
            <p class="leam-toc-title"><i class="fas fa-list-ul"></i> On this page</p>
            <ul id="leamTocList"></ul>
        </div>
    </aside>
</div>

<!-- SHARE -->
<div class="leam-article-share">
    <span class="label">Share this article</span>
    <div class="leam-article-share-btns">
        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank" title="Share on X"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" title="Share on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" title="Share on Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="mailto:?subject={{ urlencode($blogDetail->name ?? '') }}&body={{ url()->current() }}" title="Share by Email"><i class="fas fa-envelope"></i></a>
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
                        @if(!empty($rel->banner))
                            <img src="{{ url('storage/'.$rel->banner) }}" alt="{{ $rel->image_alt ?? $rel->name }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span class="rainbow-text" style="font-family:'Bebas Neue'; font-size:32px; letter-spacing:2px;">LEAMSOFT</span>
                        @endif
                    </div>
                    <div style="padding:18px 20px;">
                        <div style="font-size:11.5px; color:var(--muted); letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">{{ $rel->created_at?->format('M d, Y') }}</div>
                        <h4 style="font-size:15.5px; color:#fff; font-weight:600; line-height:1.4; margin:0;">{{ $rel->name }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
(function () {
    var body = document.getElementById('leamArticleBody');
    var toc  = document.getElementById('leamToc');
    var list = document.getElementById('leamTocList');
    var layout = document.getElementById('leamArticleLayout');
    if (!body || !toc || !list) return;

    // Collect headings from the (fully dynamic) blog content
    var headings = body.querySelectorAll('h2, h3, h4');
    if (headings.length < 2) {           // not worth a TOC for 0–1 headings
        layout.classList.add('no-toc');
        return;
    }

    var used = {};
    var slugify = function (text) {
        var base = (text || 'section').toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-') || 'section';
        var slug = base, i = 2;
        while (used[slug]) { slug = base + '-' + (i++); }
        used[slug] = true;
        return slug;
    };

    var items = [];
    headings.forEach(function (h) {
        var text = h.textContent.trim();
        if (!text) return;
        if (!h.id) h.id = slugify(text);
        var li = document.createElement('li');
        var a  = document.createElement('a');
        a.href = '#' + h.id;
        a.textContent = text;
        a.className = 'toc-' + h.tagName.toLowerCase();
        li.appendChild(a);
        list.appendChild(li);
        items.push({ heading: h, link: a });
    });

    toc.style.display = '';

    // Smooth scroll with offset for the fixed header
    list.addEventListener('click', function (e) {
        var a = e.target.closest('a');
        if (!a) return;
        var target = document.getElementById(a.getAttribute('href').slice(1));
        if (!target) return;
        e.preventDefault();
        var y = target.getBoundingClientRect().top + window.pageYOffset - 90;
        window.scrollTo({ top: y, behavior: 'smooth' });
        history.replaceState(null, '', a.getAttribute('href'));
    });

    // Scrollspy — highlight the section currently in view
    var setActive = function (link) {
        items.forEach(function (it) { it.link.classList.remove('active'); });
        if (link) link.classList.add('active');
    };

    if ('IntersectionObserver' in window) {
        var visible = new Set();
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) visible.add(entry.target);
                else visible.delete(entry.target);
            });
            // pick the topmost visible heading
            var current = null, top = Infinity;
            visible.forEach(function (el) {
                var t = el.getBoundingClientRect().top;
                if (t < top) { top = t; current = el; }
            });
            if (!current) return;
            var match = items.find(function (it) { return it.heading === current; });
            if (match) setActive(match.link);
        }, { rootMargin: '-90px 0px -70% 0px', threshold: 0 });

        items.forEach(function (it) { observer.observe(it.heading); });
    }

    setActive(items[0].link);
})();
</script>

@endsection
