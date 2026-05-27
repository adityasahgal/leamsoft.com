@extends('layouts.master')
@php
$meta_title = "Privacy Policy | LEAMSOFT";
$meta_description = "How LEAMSOFT collects, uses, and protects your personal data — written in plain English.";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('content')
<style>
    .leam-page-banner {
        padding: 80px 24px 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .leam-page-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0,180,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .leam-page-banner h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(40px, 6vw, 68px);
        letter-spacing: 2px;
        line-height: 1;
        margin: 0;
        position: relative;
        z-index: 1;
        color: #fff;
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
    .leam-policy-meta {
        position: relative;
        z-index: 1;
        margin-top: 10px;
        color: var(--muted2);
        font-size: 12px;
    }

    .leam-policy {
        max-width: 820px;
        margin: 0 auto;
        padding: 60px 24px 80px;
        color: rgba(255,255,255,0.82);
        font-size: 15.5px;
        line-height: 1.8;
        font-weight: 300;
    }
    .leam-policy h2 {
        color: #fff;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: 1px;
        margin-top: 40px;
        margin-bottom: 12px;
    }
    .leam-policy h2:first-of-type { margin-top: 0; }
    .leam-policy p { margin-bottom: 14px; }
    .leam-policy ul { padding-left: 22px; margin: 12px 0 18px; }
    .leam-policy li { margin-bottom: 8px; }
    .leam-policy strong { color: #fff; }
    .leam-policy a { color: #00b4ff; }
</style>

<section class="leam-page-banner">
    <h1>Privacy <span class="rainbow-text">Policy</span></h1>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Privacy Policy</div>
    <div class="leam-policy-meta">Last updated: {{ date('F d, Y') }}</div>
</section>

<article class="leam-policy">
    <p>This Privacy Policy explains how <strong>LEAMSOFT</strong> ("we", "us", "our") collects, uses, and protects information when you visit our website, use our services, or communicate with us.</p>

    <h2>1. Information We Collect</h2>
    <p>We collect information you provide directly — such as name, email, phone number, and project details when you fill in an enquiry form. We also collect technical information automatically: IP address, browser type, pages visited, referrer URL, and timestamps.</p>

    <h2>2. How We Use Your Information</h2>
    <ul>
        <li>To respond to enquiries and deliver requested services</li>
        <li>To send transactional communication about active projects</li>
        <li>To improve our website and service offerings through aggregate analytics</li>
        <li>To comply with legal obligations</li>
    </ul>
    <p>We do not sell your personal information to third parties.</p>

    <h2>3. Cookies & Tracking</h2>
    <p>We use first-party cookies for session management and essential functionality, plus privacy-respecting analytics (no cross-site tracking) to understand which content is useful. You can disable cookies in your browser; the site will continue to function.</p>

    <h2>4. Data Security</h2>
    <p>Data in transit is encrypted with TLS. At rest, sensitive data is encrypted with industry-standard algorithms. Access to production systems is least-privilege and audited. We follow OWASP Top 10 in our engineering practices and operational controls aligned with SOC2.</p>

    <h2>5. Data Retention</h2>
    <p>We retain enquiry data for as long as is necessary to provide our services and comply with legal obligations. You may request deletion at any time by emailing us.</p>

    <h2>6. Your Rights</h2>
    <p>Under GDPR and similar regulations, you have the right to access, correct, export, or delete your personal data, and to object to processing. To exercise these rights, contact us using the details below.</p>

    <h2>7. Third-Party Services</h2>
    <p>We use a small number of trusted vendors (hosting, email delivery, analytics, reCAPTCHA) — each is bound by data-processing agreements and only receives the minimum data needed.</p>

    <h2>8. Children's Privacy</h2>
    <p>Our services are not directed at individuals under 16. We do not knowingly collect personal data from children.</p>

    <h2>9. Changes to This Policy</h2>
    <p>We may update this policy from time to time. Material changes will be highlighted on this page with a new "Last updated" date.</p>

    <h2>10. Contact Us</h2>
    <p>Questions or requests about this policy? Reach us via the <a href="{{ url('contact-us') }}">contact page</a> or email directly.</p>
</article>

@endsection
