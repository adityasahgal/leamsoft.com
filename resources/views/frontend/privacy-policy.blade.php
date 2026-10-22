@extends('layouts.master')

@section('content')
<section class="phero">
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Privacy policy' => null]])
        <h1>Privacy policy</h1>
        <p class="meta-line">Last updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <article class="prose legal">
            <p>This Privacy Policy explains how <strong>Leamsoft Pvt Ltd.</strong> (“we”, “us”, “our”) collects, uses and protects information when you visit our website, use our services or communicate with us.</p>

            <h2>1. Information we collect</h2>
            <p>We collect information you provide directly — such as name, email, phone number and project details when you fill in an enquiry form. We also collect technical information automatically: IP address, browser type, pages visited, referrer URL and timestamps.</p>

            <h2>2. How we use your information</h2>
            <ul>
                <li>To respond to enquiries and deliver requested services</li>
                <li>To send transactional communication about active projects</li>
                <li>To improve our website and service offerings through aggregate analytics</li>
                <li>To comply with legal obligations</li>
            </ul>
            <p>We do not sell your personal information to third parties.</p>

            <h2>3. Cookies &amp; tracking</h2>
            <p>We use first-party cookies for session management and essential functionality, plus privacy-respecting analytics (no cross-site tracking) to understand which content is useful. You can disable cookies in your browser; the site will continue to function.</p>

            <h2>4. Data security</h2>
            <p>Data in transit is encrypted with TLS. At rest, sensitive data is encrypted with industry-standard algorithms. Access to production systems is least-privilege and audited. We follow the OWASP Top 10 in our engineering practices and operational controls aligned with SOC2.</p>

            <h2>5. Data retention</h2>
            <p>We retain enquiry data for as long as is necessary to provide our services and comply with legal obligations. You may request deletion at any time by emailing us.</p>

            <h2>6. Your rights</h2>
            <p>Under GDPR and similar regulations, you have the right to access, correct, export or delete your personal data, and to object to processing. To exercise these rights, contact us using the details below.</p>

            <h2>7. Third-party services</h2>
            <p>We use a small number of trusted vendors (hosting, email delivery, analytics, reCAPTCHA) — each is bound by data-processing agreements and only receives the minimum data needed.</p>

            <h2>8. Children’s privacy</h2>
            <p>Our services are not directed at individuals under 16. We do not knowingly collect personal data from children.</p>

            <h2>9. Changes to this policy</h2>
            <p>We may update this policy from time to time. Material changes will be highlighted on this page with a new “Last updated” date.</p>

            <h2>10. Contact us</h2>
            <p>Questions or requests about this policy? Reach us via the <a href="{{ url('contact-us') }}">contact page</a>@if(!empty($genSetting['email'])) or email <a href="mailto:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</a>@endif.</p>
        </article>
    </div>
</section>
@endsection
