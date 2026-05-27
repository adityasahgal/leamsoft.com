<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Help Center | LEAMSOFT";
$meta_description = "Get help with your LEAMSOFT project, account, or partnership. Browse resources or contact our team directly.";
$keywords = "leamsoft help, support, contact, resources";
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
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(57,211,83,0.10) 0%, transparent 70%);
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

    .leam-help-search {
        max-width: 580px;
        margin: 28px auto 0;
        position: relative;
        z-index: 1;
    }
    .leam-help-search input {
        width: 100%;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 14px 18px 14px 48px;
        color: #fff;
        font-size: 14px;
        font-family: 'Barlow', sans-serif;
        outline: none;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.5)' stroke-width='2'><circle cx='11' cy='11' r='7'/><path stroke-linecap='round' d='M21 21l-4.3-4.3'/></svg>");
        background-repeat: no-repeat;
        background-position: 16px center;
        background-size: 18px;
        transition: border-color .2s;
    }
    .leam-help-search input:focus { border-color: rgba(0,180,255,0.4); background-color: rgba(0,180,255,0.04); }

    .leam-help-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 18px;
    }
    .leam-help-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-help-card:hover {
        border-color: rgba(0,180,255,0.3);
        transform: translateY(-4px);
        text-decoration: none;
        color: inherit;
    }
    .leam-help-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        opacity: 0;
        transition: opacity .25s;
    }
    .leam-help-card:hover::after { opacity: 1; }
    .leam-help-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(0,180,255,0.1);
        color: #00b4ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }
    .leam-help-card h3 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 8px;
    }
    .leam-help-card p {
        font-size: 13.5px;
        color: var(--muted);
        line-height: 1.6;
        margin: 0;
    }

    .leam-contact-block {
        background: var(--dark);
        border-top: 1px solid var(--border);
        padding: 70px 24px;
        text-align: center;
    }
    .leam-contact-channels {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        max-width: 900px;
        margin: 36px auto 0;
    }
    .leam-channel {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 24px;
        text-decoration: none;
        color: inherit;
        transition: all .25s;
        display: block;
    }
    .leam-channel:hover { border-color: rgba(0,180,255,0.3); text-decoration:none; color:inherit; transform: translateY(-3px); }
    .leam-channel-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(0,180,255,0.08);
        color: #00b4ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
    }
    .leam-channel h4 { font-size: 14px; color: #fff; font-weight: 600; margin-bottom: 4px; }
    .leam-channel p { font-size: 13px; color: var(--muted); margin: 0; }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>How can we <span class="rainbow-text">help</span>?</h1>
    <p>Browse common topics below or reach out directly — we typically respond within one business day.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Help Center</div>
    <div class="leam-help-search">
        <input type="text" placeholder="Search help articles…">
    </div>
</section>

<!-- HELP TOPICS -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-section-head" style="text-align:left; margin-bottom:32px;">
            <div class="leam-section-label">Popular topics</div>
            <h2 class="leam-section-title">Browse <span class="rainbow-text">resources</span></h2>
        </div>
        <div class="leam-help-grid">
            <a href="{{ url('faq') }}" class="leam-help-card">
                <div class="leam-help-icon">❓</div>
                <h3>Frequently Asked</h3>
                <p>Quick answers to the most common questions about engagements, pricing, and timelines.</p>
            </a>
            <a href="{{ url('services') }}" class="leam-help-card">
                <div class="leam-help-icon">🛠️</div>
                <h3>Services & Categories</h3>
                <p>See every service we offer organised by category and subcategory.</p>
            </a>
            <a href="{{ url('contact-us') }}" class="leam-help-card">
                <div class="leam-help-icon">💬</div>
                <h3>Talk to Sales</h3>
                <p>Start a new project, get a quote, or schedule a discovery call with our team.</p>
            </a>
            <a href="{{ url('blog') }}" class="leam-help-card">
                <div class="leam-help-icon">📚</div>
                <h3>Articles & Guides</h3>
                <p>Long-form pieces on engineering, AI, growth, and what we've learned shipping.</p>
            </a>
            <a href="{{ url('privacy-policy') }}" class="leam-help-card">
                <div class="leam-help-icon">🔒</div>
                <h3>Privacy & Data</h3>
                <p>How we handle your data, GDPR compliance, and our security commitments.</p>
            </a>
            <a href="{{ url('terms-condition') }}" class="leam-help-card">
                <div class="leam-help-icon">📜</div>
                <h3>Terms of Service</h3>
                <p>Master services agreement and platform usage terms.</p>
            </a>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="leam-contact-block">
    <div class="leam-container">
        <div class="leam-section-label">Still stuck?</div>
        <h2 class="leam-section-title" style="margin-bottom:14px;">Get in <span class="rainbow-text">touch</span> directly</h2>
        <p style="color:var(--muted); max-width:520px; margin: 0 auto; font-weight:300;">A human will reply — no chatbots, no ticket auto-responders.</p>
        <div class="leam-contact-channels">
            @if(!empty($genSetting['email']))
            <a href="mailto:{{ $genSetting['email'] }}" class="leam-channel">
                <div class="leam-channel-icon">✉️</div>
                <h4>Email</h4>
                <p>{{ $genSetting['email'] }}</p>
            </a>
            @endif
            @if(!empty($genSetting['phone']))
            <a href="tel:{{ $genSetting['phone'] }}" class="leam-channel">
                <div class="leam-channel-icon">📞</div>
                <h4>Phone</h4>
                <p>{{ $genSetting['phone'] }}</p>
            </a>
            @endif
            <a href="{{ url('contact-us') }}" class="leam-channel">
                <div class="leam-channel-icon">📝</div>
                <h4>Contact Form</h4>
                <p>Send us a project brief</p>
            </a>
            <a href="https://wa.me/97450434870" target="_blank" class="leam-channel">
                <div class="leam-channel-icon">💬</div>
                <h4>WhatsApp</h4>
                <p>Quick chat 9 – 7 IST</p>
            </a>
        </div>
    </div>
</section>

@endsection
