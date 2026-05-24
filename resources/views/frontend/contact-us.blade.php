<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Contact LEAMSOFT | Talk to Our Tech Team";
$meta_description = "Get in touch with LEAMSOFT for web, mobile, AI, cloud, and cyber security solutions. Free consultation. Email, call, or fill the form.";
$keywords = "Contact LEAMSOFT, tech consulting, project enquiry, software development quote, hire developers";
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
        max-width: 580px;
        margin: 18px auto 0;
        color: var(--muted);
        font-size: 16px;
        font-weight: 300;
    }
    .leam-page-banner .crumbs {
        position: relative;
        z-index: 1;
        margin-top: 12px;
        font-size: 13px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .leam-page-banner .crumbs a { color: var(--muted); text-decoration: none; }
    .leam-page-banner .crumbs a:hover { color: #fff; }

    /* Contact cards */
    .leam-contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 56px;
    }
    .leam-contact-info-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        text-align: center;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }
    .leam-contact-info-card:hover { border-color: rgba(0,180,255,0.25); transform: translateY(-4px); }
    .leam-contact-info-card::after {
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
    .leam-contact-info-card:hover::after { opacity: 1; }
    .leam-contact-info-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: rgba(0,180,255,0.08);
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #00b4ff;
    }
    .leam-contact-info-card h3 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 8px;
    }
    .leam-contact-info-card p {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
        line-height: 1.6;
        word-break: break-word;
    }
    .leam-contact-info-card a { color: var(--muted); text-decoration: none; transition: color .2s; }
    .leam-contact-info-card a:hover { color: #00b4ff; }

    /* Form + Map */
    .leam-contact-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 32px;
        align-items: stretch;
    }
    .leam-contact-form-wrap {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 40px 36px;
        position: relative;
        overflow: hidden;
    }
    .leam-contact-form-wrap::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: 21px;
        background: var(--rainbow);
        background-size: 300%;
        animation: shift 6s linear infinite;
        z-index: -1;
        opacity: 0.4;
    }
    .leam-contact-form-wrap h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        letter-spacing: 1px;
        margin-bottom: 6px;
        color: #fff;
    }
    .leam-contact-form-wrap > p {
        font-size: 14px;
        color: var(--muted);
        margin-bottom: 28px;
        font-weight: 300;
    }
    .leam-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 14px;
    }
    .leam-form-group { margin-bottom: 14px; }
    .leam-form-group label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 8px;
        display: block;
    }
    .leam-form-group input,
    .leam-form-group textarea,
    .leam-form-group select {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
        font-family: 'Barlow', sans-serif;
        outline: none;
        transition: border-color .2s, background .2s;
    }
    .leam-form-group input:focus,
    .leam-form-group textarea:focus,
    .leam-form-group select:focus {
        border-color: #00b4ff;
        background: rgba(0,180,255,0.04);
    }
    .leam-form-group input::placeholder,
    .leam-form-group textarea::placeholder { color: var(--muted2); }
    .leam-form-group textarea { resize: vertical; min-height: 130px; }
    .leam-form-submit {
        width: 100%;
        padding: 14px;
        border-radius: 10px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        border: none;
        color: #000;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Barlow', sans-serif;
        letter-spacing: 0.5px;
        transition: opacity .2s;
        margin-top: 4px;
    }
    .leam-form-submit:hover { opacity: 0.9; }
    .leam-form-error {
        margin-top: 6px;
        font-size: 12px;
        color: #ff3b5c;
    }
    .leam-form-status {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 18px;
    }
    .leam-form-status.success {
        background: rgba(57,211,83,0.08);
        border: 1px solid rgba(57,211,83,0.25);
        color: #39d353;
    }
    .leam-form-status.error {
        background: rgba(255,59,92,0.08);
        border: 1px solid rgba(255,59,92,0.25);
        color: #ff3b5c;
    }

    .leam-map-wrap {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 520px;
    }
    .leam-map-wrap iframe {
        width: 100%;
        flex: 1;
        border: none;
        filter: grayscale(0.6) brightness(0.7) invert(0.92) hue-rotate(180deg);
        min-height: 400px;
    }
    .leam-map-overlay {
        padding: 20px 24px;
        border-top: 1px solid var(--border);
        background: var(--card2);
    }
    .leam-map-overlay h4 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #00b4ff;
        margin-bottom: 4px;
    }
    .leam-map-overlay p {
        font-size: 13.5px;
        color: var(--muted);
        margin: 0;
    }

    @media (max-width: 900px) {
        .leam-contact-grid { grid-template-columns: 1fr; }
        .leam-form-row { grid-template-columns: 1fr; }
        .leam-contact-form-wrap { padding: 32px 24px; }
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>Get in <span class="rainbow-text">Touch</span></h1>
    <p>Tell us about your project — whether it's a fully scoped brief or a rough idea — and we'll get back to you within one business day.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Contact Us</div>
</section>

<!-- CONTACT -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-contact-info-grid">
            <div class="leam-contact-info-card">
                <div class="leam-contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Office Address</h3>
                <p>{{ $genSetting['address'] ?? 'Bangalore, India' }}</p>
            </div>
            <div class="leam-contact-info-card">
                <div class="leam-contact-info-icon"><i class="fas fa-envelope"></i></div>
                <h3>Email Us</h3>
                <p>
                    @if(!empty($genSetting['email']))
                        <a href="mailto:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</a>
                    @else
                        <a href="mailto:hello@leamsoft.com">hello@leamsoft.com</a>
                    @endif
                </p>
            </div>
            <div class="leam-contact-info-card">
                <div class="leam-contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                <h3>Call Us</h3>
                <p>
                    @if(!empty($genSetting['phone']))
                        <a href="tel:{{ $genSetting['phone'] }}">{{ $genSetting['phone'] }}</a>
                    @else
                        <a href="tel:+1234567890">+1 (234) 567-890</a>
                    @endif
                </p>
            </div>
            <div class="leam-contact-info-card">
                <div class="leam-contact-info-icon"><i class="fas fa-clock"></i></div>
                <h3>Working Hours</h3>
                <p>Mon – Fri: 9am – 7pm<br>24/7 Support</p>
            </div>
        </div>

        <div class="leam-contact-grid">
            <div class="leam-contact-form-wrap">
                <h3>Send Us a Message</h3>
                <p>Drop your details below — we read every enquiry personally.</p>

                @if(Session('status'))
                    <div class="leam-form-status {{ Session('status') == 'success' ? 'success' : 'error' }}">
                        {{ Session('message') }}
                    </div>
                @endif

                <form action="{{ url('/enquiry') }}" method="post">
                    @csrf
                    <div class="leam-form-row">
                        <div class="leam-form-group">
                            <label>Your Name</label>
                            <input type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" />
                            @error('name') <div class="leam-form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="leam-form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="you@company.com" value="{{ old('email') }}" required />
                            @error('email') <div class="leam-form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="leam-form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+1 (234) 567-890" value="{{ old('phone') }}" />
                        @error('phone') <div class="leam-form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="leam-form-group">
                        <label>Your Message</label>
                        <textarea name="message" placeholder="Tell us about your project, timeline, and budget…">{{ old('message') }}</textarea>
                        @error('message') <div class="leam-form-error">{{ $message }}</div> @enderror
                    </div>

                    @if(env('RECAPTCHA_SITE_KEY'))
                        <div class="leam-form-group">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            @error('g-recaptcha-response') <div class="leam-form-error">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <button type="submit" class="leam-form-submit">Send Message →</button>
                </form>
            </div>

            <div class="leam-map-wrap">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3477.473554758739!2d79.4775400150991!3d29.356420482137853!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjnCsDIxJzIzLjEiTiA3OcKwMjgnNDcuMCJF!5e0!3m2!1sen!2sin!4v1571907242738!5m2!1sen!2sin"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
                <div class="leam-map-overlay">
                    <h4>Visit Our Office</h4>
                    <p>{{ $genSetting['address'] ?? 'Drop by for a coffee and a chat about your project.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    setTimeout(function() {
        var status = document.querySelector('.leam-form-status');
        if (status) status.style.transition = 'opacity .5s';
        if (status) setTimeout(function() { status.style.opacity = '0'; }, 3500);
    }, 100);
</script>

@endsection
