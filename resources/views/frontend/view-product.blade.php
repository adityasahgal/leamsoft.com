<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')

@section('meta_title'){{ $productrow->meta_title ?? $productrow->name }}@stop
@section('meta_description'){{ $productrow->meta_description ?? $productrow->short_description }}@stop
@section('meta_keywords'){{ $productrow->keywords }}@stop

@section('content')
<style>
    .leam-svc-hero {
        padding: 70px 24px 60px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-svc-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 70% 0%, rgba(0,180,255,0.12) 0%, transparent 70%),
                    radial-gradient(ellipse 40% 40% at 20% 100%, rgba(168,85,247,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-svc-hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 50px;
        align-items: center;
    }
    .leam-svc-hero .meta {
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 14px;
    }
    .leam-svc-hero .meta a { color: var(--muted); text-decoration: none; }
    .leam-svc-hero .meta a:hover { color: #fff; }
    .leam-svc-hero h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 5vw, 60px);
        letter-spacing: 1.5px;
        line-height: 1;
        margin: 0 0 18px;
        color: #fff;
    }
    .leam-svc-hero p.lead {
        font-size: 17px;
        color: var(--muted);
        line-height: 1.7;
        margin: 0 0 26px;
        font-weight: 300;
    }
    .leam-svc-hero .badges {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .leam-svc-hero .badge-pill {
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 4px 12px;
        border-radius: 100px;
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        border: 1px solid rgba(0,180,255,0.2);
    }
    .leam-svc-hero .ctas { display: flex; gap: 12px; flex-wrap: wrap; }

    .leam-svc-hero-visual {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: var(--card);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .leam-svc-hero-visual::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: 23px;
        background: var(--rainbow);
        background-size: 300%;
        animation: shift 5s linear infinite;
        z-index: 0;
        opacity: 0.4;
        pointer-events: none;
    }
    .leam-svc-hero-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 22px;
        position: relative;
        z-index: 1;
    }
    .leam-svc-hero-visual .placeholder {
        font-size: 140px;
        z-index: 1;
        position: relative;
    }

    /* Quick facts */
    .leam-svc-facts {
        background: var(--dark);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 36px 24px;
    }
    .leam-svc-facts-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    .leam-svc-fact {
        display: flex;
        gap: 14px;
        align-items: center;
    }
    .leam-svc-fact-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(0,180,255,0.08);
        color: #00b4ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .leam-svc-fact-lab { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }
    .leam-svc-fact-val { font-size: 15px; color: #fff; font-weight: 600; }

    /* Body grid */
    .leam-svc-body {
        max-width: 1280px;
        margin: 0 auto;
        padding: 70px 24px;
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 48px;
        align-items: start;
    }
    .leam-svc-content {
        font-size: 16px;
        color: var(--muted);
        line-height: 1.8;
        font-weight: 300;
    }
    .leam-svc-content h2, .leam-svc-content h3 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        letter-spacing: 1px;
        margin-top: 36px;
        margin-bottom: 14px;
    }
    .leam-svc-content h2 { font-size: 32px; }
    .leam-svc-content h3 { font-size: 24px; }
    .leam-svc-content p { margin-bottom: 16px; }
    .leam-svc-content ul, .leam-svc-content ol { padding-left: 22px; margin: 14px 0 18px; }
    .leam-svc-content li { margin-bottom: 8px; }
    .leam-svc-content a { color: #00b4ff; }

    /* Photo gallery */
    .leam-svc-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
        margin-top: 28px;
    }
    .leam-svc-gallery img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border);
        transition: transform .25s;
    }
    .leam-svc-gallery img:hover { transform: scale(1.02); }

    /* Sticky sidebar */
    .leam-svc-side {
        position: sticky;
        top: 90px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .leam-svc-side-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 26px;
        position: relative;
        overflow: hidden;
    }
    .leam-svc-side-card.accent::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: 19px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        z-index: -1;
        opacity: 0.45;
    }
    .leam-svc-side-card h4 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 1px;
        margin-bottom: 6px;
        color: #fff;
    }
    .leam-svc-side-card p {
        font-size: 13.5px;
        color: var(--muted);
        margin: 0 0 16px;
        line-height: 1.6;
    }
    .leam-svc-side-form input,
    .leam-svc-side-form textarea {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 10px 14px;
        color: #fff;
        font-size: 13.5px;
        font-family: 'Barlow', sans-serif;
        outline: none;
        margin-bottom: 10px;
        transition: border-color .2s;
    }
    .leam-svc-side-form input:focus,
    .leam-svc-side-form textarea:focus { border-color: #00b4ff; background: rgba(0,180,255,0.04); }
    .leam-svc-side-form input::placeholder,
    .leam-svc-side-form textarea::placeholder { color: var(--muted2); }
    .leam-svc-side-form textarea { resize: vertical; min-height: 80px; }
    .leam-svc-side-form button {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        border: none;
        color: #000;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Barlow', sans-serif;
        letter-spacing: 0.5px;
        transition: opacity .2s;
    }
    .leam-svc-side-form button:hover { opacity: 0.92; }

    .leam-svc-side-contact-row {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: var(--muted);
        padding: 10px 0;
        border-top: 1px solid var(--border);
    }
    .leam-svc-side-contact-row:first-of-type { border-top: none; padding-top: 0; }
    .leam-svc-side-contact-row i { width: 18px; color: #00b4ff; }
    .leam-svc-side-contact-row a { color: var(--muted); text-decoration: none; }
    .leam-svc-side-contact-row a:hover { color: #fff; }

    /* Related */
    .leam-related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 18px;
    }

    @media (max-width: 900px) {
        .leam-svc-hero-inner { grid-template-columns: 1fr; }
        .leam-svc-body { grid-template-columns: 1fr; }
        .leam-svc-side { position: static; }
        .leam-svc-facts-grid { grid-template-columns: 1fr 1fr; gap: 18px; }
    }
</style>

<!-- SERVICE HERO -->
<section class="leam-svc-hero">
    <div class="leam-svc-hero-inner">
        <div>
            <div class="meta">
                <a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp;
                <a href="{{ url('services') }}">Services</a>
                @if($productrow->category)
                    &nbsp;›&nbsp; <a href="{{ url($productrow->category->slug) }}">{{ $productrow->category->name }}</a>
                @endif
                @if($productrow->subcategory)
                    &nbsp;›&nbsp; <a href="{{ url($productrow->subcategory->slug) }}">{{ $productrow->subcategory->name }}</a>
                @endif
                &nbsp;›&nbsp; <span style="color:#00b4ff;">{{ $productrow->name }}</span>
            </div>
            <div class="badges">
                @if($productrow->category)
                    <span class="badge-pill">{{ $productrow->category->name }}</span>
                @endif
                @if($productrow->subcategory)
                    <span class="badge-pill">{{ $productrow->subcategory->name }}</span>
                @endif
                @if($productrow->featured)
                    <span class="badge-pill" style="background:rgba(57,211,83,0.1); color:#39d353; border-color:rgba(57,211,83,0.2);">★ Featured</span>
                @endif
            </div>
            <h1>{{ $productrow->h1_tag ?? $productrow->name }}</h1>
            <p class="lead">{{ $productrow->short_description }}</p>
            <div class="ctas">
                <a href="#enquire" class="leam-btn leam-btn-primary">Request a Quote ↗</a>
                <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-ghost">Talk to Us</a>
            </div>
        </div>
        <div class="leam-svc-hero-visual">
            @if(!empty($productrow->thumbnail_img))
                <img src="{{ url('storage/'.$productrow->thumbnail_img) }}" alt="{{ $productrow->image_alt ?? $productrow->name }}">
            @else
                <div class="placeholder">{{ $productrow->icon ?? '⚡' }}</div>
            @endif
        </div>
    </div>
</section>

<!-- QUICK FACTS -->
<div class="leam-svc-facts">
    <div class="leam-svc-facts-grid">
        <div class="leam-svc-fact">
            <div class="leam-svc-fact-icon"><i class="fas fa-bolt"></i></div>
            <div>
                <div class="leam-svc-fact-lab">Delivery</div>
                <div class="leam-svc-fact-val">2 – 12 weeks</div>
            </div>
        </div>
        <div class="leam-svc-fact">
            <div class="leam-svc-fact-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="leam-svc-fact-lab">Team</div>
                <div class="leam-svc-fact-val">Senior engineers</div>
            </div>
        </div>
        <div class="leam-svc-fact">
            <div class="leam-svc-fact-icon"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="leam-svc-fact-lab">Support</div>
                <div class="leam-svc-fact-val">24/7 coverage</div>
            </div>
        </div>
        <div class="leam-svc-fact">
            <div class="leam-svc-fact-icon"><i class="fas fa-handshake"></i></div>
            <div>
                <div class="leam-svc-fact-lab">Engagement</div>
                <div class="leam-svc-fact-val">Flexible models</div>
            </div>
        </div>
    </div>
</div>

<!-- BODY -->
<div class="leam-svc-body">
    <div class="leam-svc-content">
        @if(!empty($productrow->description))
            {!! $productrow->description !!}
        @else
            <p>{{ $productrow->short_description }}</p>
        @endif

        @php
            $photos = [];
            if (!empty($productrow->photos)) {
                $decoded = json_decode($productrow->photos, true);
                if (is_array($decoded)) { $photos = $decoded; }
            }
        @endphp
        @if(count($photos) > 0)
            <h3>Gallery</h3>
            <div class="leam-svc-gallery">
                @foreach($photos as $photo)
                    <img src="{{ url('storage/'.$photo) }}" alt="{{ $productrow->image_alt ?? $productrow->name }}">
                @endforeach
            </div>
        @endif
    </div>

    <aside class="leam-svc-side">
        <div class="leam-svc-side-card accent" id="enquire">
            <h4>Get a Free Quote</h4>
            <p>Tell us about your project — we respond within one business day.</p>
            <form class="leam-svc-side-form" action="{{ url('storeEnquiry') }}" method="POST">
                @csrf
                <input type="hidden" name="pname" value="{{ $productrow->name }}">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <textarea name="message" placeholder="Tell us about your project…"></textarea>
                <button type="submit">Send Enquiry →</button>
            </form>
        </div>

        <div class="leam-svc-side-card">
            <h4>Talk to Us</h4>
            @if(!empty($genSetting['phone']))
                <div class="leam-svc-side-contact-row">
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:{{ $genSetting['phone'] }}">{{ $genSetting['phone'] }}</a>
                </div>
            @endif
            @if(!empty($genSetting['email']))
                <div class="leam-svc-side-contact-row">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</a>
                </div>
            @endif
            <div class="leam-svc-side-contact-row">
                <i class="fas fa-clock"></i>
                <span>Mon – Fri, 9am – 7pm</span>
            </div>
        </div>
    </aside>
</div>

<!-- RELATED SERVICES -->
@if(!empty($related) && $related->count() > 0)
<section class="leam-section" style="background: var(--dark); border-top: 1px solid var(--border);">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">You might also like</div>
            <h2 class="leam-section-title">Related <span class="rainbow-text">Services</span></h2>
        </div>
        <div class="leam-related-grid">
            @foreach($related as $rel)
                <a href="{{ url($rel->slug) }}" style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px; text-decoration:none; color:inherit; display:block; transition:all .25s;"
                   onmouseover="this.style.borderColor='rgba(0,180,255,0.3)'; this.style.transform='translateY(-3px)';"
                   onmouseout="this.style.borderColor='var(--border)'; this.style.transform='';">
                    <div style="font-size:28px; margin-bottom:12px;">{{ $rel->icon ?? '🔧' }}</div>
                    <h4 style="font-family:'Barlow Condensed'; font-size:17px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; color:#fff; margin-bottom:8px;">{{ $rel->name }}</h4>
                    <p style="font-size:13px; color:var(--muted); line-height:1.55; margin:0 0 12px;">{{ \Illuminate\Support\Str::limit(strip_tags($rel->short_description ?? ''), 80) }}</p>
                    <span style="font-size:12px; color:#00b4ff; font-weight:600; letter-spacing:0.5px;">VIEW DETAILS →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
