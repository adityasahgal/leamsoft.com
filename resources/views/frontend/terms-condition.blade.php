@extends('layouts.master')
@php
$meta_title = "Terms & Conditions | LEAMSOFT";
$meta_description = "LEAMSOFT's terms of service governing the use of our website and engagement of our services.";
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
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(168,85,247,0.08) 0%, transparent 70%);
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
    <h1>Terms & <span class="rainbow-text">Conditions</span></h1>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; Terms</div>
    <div class="leam-policy-meta">Last updated: {{ date('F d, Y') }}</div>
</section>

<article class="leam-policy">
    <p>By accessing this website or engaging <strong>LEAMSOFT</strong> for services, you agree to these terms. Please read them carefully.</p>

    <h2>1. Services</h2>
    <p>We provide consulting, development, and managed services across software, AI, cloud, security, and digital marketing. Specific scope, deliverables, pricing, and timeline for each engagement are defined in a written Statement of Work signed by both parties.</p>

    <h2>2. Acceptable Use</h2>
    <p>You agree not to use this website to (a) violate any law, (b) infringe any intellectual property rights, (c) transmit malicious code, or (d) attempt unauthorised access to our systems. We may suspend or terminate access for any violation.</p>

    <h2>3. Intellectual Property</h2>
    <p>All work product (source code, designs, documentation) developed under a paid engagement is assigned to the client on full payment. LEAMSOFT retains ownership of pre-existing tools, libraries, frameworks, and methodologies brought into a project.</p>
    <p>Website content (logos, copy, designs) is owned by LEAMSOFT and may not be reproduced without permission.</p>

    <h2>4. Payment</h2>
    <p>Invoices are due within 14 days unless agreed otherwise in writing. Late payments may incur interest at 1.5% per month. We reserve the right to suspend work on overdue accounts after notice.</p>

    <h2>5. Confidentiality</h2>
    <p>We treat all client information as confidential. We sign mutual NDAs before sharing any sensitive details, and all team members are bound by confidentiality agreements.</p>

    <h2>6. Warranties & Disclaimers</h2>
    <p>We warrant that services will be performed with reasonable care and skill consistent with industry standards. Beyond that warranty, services are provided "as is" without other express or implied warranties.</p>

    <h2>7. Limitation of Liability</h2>
    <p>To the maximum extent permitted by law, LEAMSOFT's total liability for any claim arising out of an engagement is limited to the fees paid by the client for the specific service giving rise to the claim. We are not liable for indirect, incidental, or consequential damages.</p>

    <h2>8. Termination</h2>
    <p>Either party may terminate an engagement with 30 days' written notice. Client pays for all work completed up to termination and any non-cancellable third-party costs.</p>

    <h2>9. Governing Law</h2>
    <p>These terms are governed by the laws of India. Disputes will be resolved through good-faith negotiation, then mediation, then exclusive jurisdiction of the courts in Bangalore.</p>

    <h2>10. Updates</h2>
    <p>We may update these terms occasionally. Material changes will be noted with a new "Last updated" date. Continued use of our website or services after changes constitutes acceptance.</p>

    <h2>11. Contact</h2>
    <p>Questions about these terms? Reach us via the <a href="{{ url('contact-us') }}">contact page</a>.</p>
</article>

@endsection
