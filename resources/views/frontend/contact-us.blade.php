@extends('layouts.master')

@section('content')
<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Contact' => null]])
        <h1>Let’s build something <span class="dim">that lasts.</span></h1>
        <p class="lead">Tell us about your project, timeline and budget. A senior engineer — not a sales rep — will reply within one business day.</p>
        <div class="hero__meta">
            <div><strong>&lt; 24h</strong>Response time</div>
            <div><strong>Free</strong>30-min discovery call</div>
            <div><strong>NDA</strong>On request</div>
            <div><strong>Mon–Sat</strong>9am – 7pm IST</div>
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        @include('frontend.partials.contact', [
            'contactTitle' => 'Start the <span style="color:var(--faint)">conversation.</span>',
        ])
    </div>
</section>

<section class="section section--soft" style="padding-top:88px">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">What happens next</span>
                <h2 class="h2">A simple path <span class="dim">from hello to kickoff.</span></h2>
            </div>
        </div>
        <div class="steps rv">
            <div class="step"><span class="n">01</span><h3>We reply</h3><p>Within one business day, with a few questions to understand what you need.</p><small>Day 1</small></div>
            <div class="step"><span class="n">02</span><h3>Discovery call</h3><p>A free 30-minute call with an engineer to talk through goals, users and constraints.</p><small>Day 2–3</small></div>
            <div class="step"><span class="n">03</span><h3>Proposal</h3><p>Written scope, timeline and a fixed-price or time-and-materials estimate.</p><small>Week 1</small></div>
            <div class="step"><span class="n">04</span><h3>Kickoff</h3><p>We sign, set up your project workspace and start the first sprint.</p><small>Week 2</small></div>
        </div>
    </div>
</section>
@endsection
