@extends('layouts.master')

@section('content')
<section class="phero">
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Terms & conditions' => null]])
        <h1>Terms &amp; conditions</h1>
        <p class="meta-line">Last updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <article class="prose legal">
            <p>By accessing this website or engaging <strong>Leamsoft Pvt Ltd.</strong> for services, you agree to these terms. Please read them carefully.</p>

            <h2>1. Services</h2>
            <p>We provide consulting, development and managed services across software, AI, cloud, security and digital marketing. Specific scope, deliverables, pricing and timeline for each engagement are defined in a written Statement of Work signed by both parties.</p>

            <h2>2. Acceptable use</h2>
            <p>You agree not to use this website to (a) violate any law, (b) infringe any intellectual property rights, (c) transmit malicious code, or (d) attempt unauthorised access to our systems. We may suspend or terminate access for any violation.</p>

            <h2>3. Intellectual property</h2>
            <p>All work product (source code, designs, documentation) developed under a paid engagement is assigned to the client on full payment. Leamsoft retains ownership of pre-existing tools, libraries, frameworks and methodologies brought into a project.</p>
            <p>Website content (logos, copy, designs) is owned by Leamsoft and may not be reproduced without permission.</p>

            <h2>4. Payment</h2>
            <p>Invoices are due within 14 days unless agreed otherwise in writing. Late payments may incur interest at 1.5% per month. We reserve the right to suspend work on overdue accounts after notice.</p>

            <h2>5. Confidentiality</h2>
            <p>We treat all client information as confidential. We sign mutual NDAs before sharing any sensitive details, and all team members are bound by confidentiality agreements.</p>

            <h2>6. Warranties &amp; disclaimers</h2>
            <p>We warrant that services will be performed with reasonable care and skill consistent with industry standards. Beyond that warranty, services are provided “as is” without other express or implied warranties.</p>

            <h2>7. Limitation of liability</h2>
            <p>To the maximum extent permitted by law, Leamsoft’s total liability for any claim arising out of an engagement is limited to the fees paid by the client for the specific service giving rise to the claim. We are not liable for indirect, incidental or consequential damages.</p>

            <h2>8. Termination</h2>
            <p>Either party may terminate an engagement with 30 days’ written notice. The client pays for all work completed up to termination and any non-cancellable third-party costs.</p>

            <h2>9. Governing law</h2>
            <p>These terms are governed by the laws of India. Disputes will be resolved through good-faith negotiation, then mediation, then the exclusive jurisdiction of the courts in Bangalore.</p>

            <h2>10. Updates</h2>
            <p>We may update these terms occasionally. Material changes will be noted with a new “Last updated” date. Continued use of our website or services after changes constitutes acceptance.</p>

            <h2>11. Contact</h2>
            <p>Questions about these terms? Reach us via the <a href="{{ url('contact-us') }}">contact page</a>.</p>
        </article>
    </div>
</section>
@endsection
