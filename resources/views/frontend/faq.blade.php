@extends('layouts.master')
@php
$meta_title = "FAQ | LEAMSOFT — Frequently Asked Questions";
$meta_description = "Answers to common questions about working with LEAMSOFT — pricing, engagement models, timelines, and more.";
$keywords = "leamsoft faq, hire leamsoft, questions, pricing";
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
        background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0,180,255,0.10) 0%, transparent 70%);
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

    .leam-faq-wrap {
        max-width: 820px;
        margin: 0 auto;
    }
    .leam-faq-cat {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #00b4ff;
        margin: 36px 0 14px;
    }
    .leam-faq-cat:first-of-type { margin-top: 0; }
    .leam-faq-item {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 14px;
        margin-bottom: 10px;
        overflow: hidden;
        transition: border-color .2s;
    }
    .leam-faq-item:hover, .leam-faq-item.open { border-color: rgba(0,180,255,0.25); }
    .leam-faq-q {
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        font-size: 15.5px;
        color: #fff;
        font-weight: 500;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        font-family: 'Barlow', sans-serif;
    }
    .leam-faq-q:hover { background: rgba(255,255,255,0.02); }
    .leam-faq-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: rgba(0,180,255,0.08);
        color: #00b4ff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform .2s;
        font-size: 14px;
        font-weight: 700;
    }
    .leam-faq-item.open .leam-faq-icon { transform: rotate(45deg); background: var(--rainbow); background-size: 200%; animation: shift 4s linear infinite; color: #000; }
    .leam-faq-q-text { flex: 1; }
    .leam-faq-a {
        max-height: 0;
        overflow: hidden;
        transition: max-height .25s ease;
    }
    .leam-faq-item.open .leam-faq-a { max-height: 500px; }
    .leam-faq-a-inner {
        padding: 0 22px 22px 60px;
        color: var(--muted);
        font-size: 14.5px;
        line-height: 1.7;
        font-weight: 300;
    }
</style>

<!-- BANNER -->
<section class="leam-page-banner">
    <h1>Frequently Asked <span class="rainbow-text">Questions</span></h1>
    <p>Quick answers to what people typically ask before starting a project with us. Can't find your question? Just contact us.</p>
    <div class="crumbs"><a href="{{ url('/') }}">Home</a> &nbsp;›&nbsp; FAQ</div>
</section>

<!-- FAQ -->
<section class="leam-section">
    <div class="leam-container">
        <div class="leam-faq-wrap">
            @php
                $faqs = [
                    'Working with LEAMSOFT' => [
                        ['What types of projects do you take on?', 'We work across web development, mobile apps, AI/ML, cloud infrastructure, cyber security, and digital marketing. Whether you have a fully scoped brief or a rough idea, we can shape it into a delivery plan together.'],
                        ['What does the engagement process look like?', 'A typical engagement starts with a 30-min discovery call, followed by a written scope and fixed-price or T&M proposal. Once you sign, we run agile two-week sprints with weekly demos and full transparency in our project management tool of choice.'],
                        ['Do you work with startups or only enterprise?', 'Both. About 40% of our clients are early-stage startups, the rest range from mid-market to Fortune 500. Our delivery model adapts — we have lightweight processes for startup speed and heavier governance for enterprise.'],
                    ],
                    'Pricing & Timeline' => [
                        ['How do you price projects?', 'Two models: fixed-price for well-scoped projects, and time & materials for ongoing or exploratory work. We share rate cards upfront and never have hidden fees.'],
                        ['How fast can you start?', 'For small projects, often within a week. For larger engagements requiring a dedicated team, allow 2 – 4 weeks for resourcing. Urgent work? Tell us — we can usually accommodate.'],
                        ['Do you sign NDAs?', 'Yes, mutual NDAs are standard before any detailed scoping discussion. Just send us yours or use ours.'],
                    ],
                    'Technology & Team' => [
                        ['What technologies do you specialise in?', 'Frontend: React, Vue, Next.js. Backend: Node.js, Python, Laravel, .NET. Mobile: React Native, Swift, Kotlin. AI: PyTorch, LLM integration. Cloud: AWS, Azure, GCP. We pick the right tool for the job, not the trendiest one.'],
                        ['Who actually does the work?', 'Senior engineers with 5+ years of shipped portfolio. No bait-and-switch — the team you meet during scoping is the team you get.'],
                        ['Do you offer ongoing maintenance after launch?', 'Yes. Most clients move into a managed support contract post-launch covering monitoring, bug fixes, security patches, and minor enhancements.'],
                    ],
                    'IP, Security & Legal' => [
                        ['Who owns the code?', 'You do. All work product is assigned to you on payment, including source code, designs, and documentation. No vendor lock-in.'],
                        ['How do you handle data security?', 'Production access is least-privilege and audited. We follow OWASP Top 10 in code, SOC2-aligned operational practices, and offer ISO 27001 compliance assistance.'],
                        ['Can we run our own security review?', 'Absolutely encouraged. We provide architecture docs, threat models, and access for your pen-test or code-review partners.'],
                    ],
                ];
            @endphp

            @foreach($faqs as $section => $items)
                <div class="leam-faq-cat">{{ $section }}</div>
                @foreach($items as [$q, $a])
                    <div class="leam-faq-item">
                        <button class="leam-faq-q" onclick="this.closest('.leam-faq-item').classList.toggle('open')">
                            <span class="leam-faq-icon">+</span>
                            <span class="leam-faq-q-text">{{ $q }}</span>
                        </button>
                        <div class="leam-faq-a">
                            <div class="leam-faq-a-inner">{{ $a }}</div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div style="text-align:center; margin-top: 64px;">
            <p style="color:var(--muted); margin-bottom:20px;">Still have questions?</p>
            <a href="{{ url('contact-us') }}" class="leam-btn leam-btn-primary">Talk to Our Team ↗</a>
        </div>
    </div>
</section>

@endsection
