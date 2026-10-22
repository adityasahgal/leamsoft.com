@extends('layouts.master', [
    'seo' => \App\Support\Seo::page('home', [
        'title'     => 'Page not found',
        'robots'    => 'noindex, follow',
        'canonical' => url()->current(),
    ]),
])

@section('content')
<section class="phero" style="border-bottom:0">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        <span class="label">Error 404</span>
        <h1>This page doesn’t exist <span class="dim">— or it moved.</span></h1>
        <p class="lead">The link may be out of date. Try one of these instead, or tell us what you were looking for.</p>
        <div class="phero__cta">
            <a href="{{ url('/') }}" class="btn btn--primary">Back to home <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            <a href="{{ url('contact-us') }}" class="btn btn--ghost">Contact us</a>
        </div>
    </div>
</section>

<section class="section--tight" style="padding-top:0">
    <div class="container">
        <h2 class="sr-only">Popular pages</h2>
        <div class="tiles tiles--4">
            <a href="{{ url('services') }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-grid"/></svg></span><h3>Services</h3><p>Software, AI, cloud, security and growth.</p></a>
            <a href="{{ url('gallery') }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-rocket"/></svg></span><h3>Our work</h3><p>Projects we’ve designed and built.</p></a>
            <a href="{{ url('blog') }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-book"/></svg></span><h3>Blog</h3><p>AI and innovation, explained.</p></a>
            <a href="{{ url('faq') }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-help"/></svg></span><h3>FAQ</h3><p>Pricing, timelines and how we work.</p></a>
        </div>
    </div>
</section>
@endsection
