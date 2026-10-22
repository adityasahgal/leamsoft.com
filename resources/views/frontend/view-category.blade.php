@extends('layouts.master')

@section('content')
@php $Ui = \App\Support\Ui::class; @endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container phero__split">
        <div>
            @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Services' => url('services'), $categories->name => null]])
            <h1>{!! $Ui::dimTail($categories->name, 1) !!}</h1>
            @if($categories->short_description)
                <p class="lead">{{ $Ui::excerpt($categories->short_description, 320) }}</p>
            @endif
            <div class="phero__cta">
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Start a project <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                @if($subcategories->count() || $services->count())
                    <a href="#offerings" class="btn btn--ghost">What we offer</a>
                @endif
            </div>
            <div class="hero__meta">
                @if($subcategories->count())<div><strong>{{ $subcategories->count() }}</strong>Specialisations</div>@endif
                @if($services->count())<div><strong>{{ $services->count() }}</strong>Services</div>@endif
                <div><strong>24/7</strong>Support</div>
            </div>
        </div>
        <div class="phero__media">
            @if($categories->thumb_url)
                <img src="{{ $categories->thumb_url }}" alt="{{ $categories->image_alt ?? $categories->name }}" fetchpriority="high" decoding="async">
            @else
                <span class="ph"><svg class="icon"><use href="#{{ $Ui::icon($categories->name) }}"/></svg></span>
            @endif
        </div>
    </div>
</section>

@if($subcategories->count() > 0)
<section class="section" id="offerings" style="scroll-margin-top:64px">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Capabilities</span>
                <h2 class="h2">{{ $categories->name }}, <span class="dim">broken down.</span></h2>
            </div>
        </div>
        <div class="cards">
            @foreach($subcategories as $sub)
                <a href="{{ url($sub->slug) }}" class="card rv">
                    <div class="card__media">
                        @if($sub->thumb_url)
                            <img src="{{ $sub->thumb_url }}" alt="{{ $sub->image_alt ?? $sub->name }}" loading="lazy" decoding="async">
                        @else
                            <span class="ph"><svg class="icon"><use href="#{{ $Ui::icon($sub->name, $Ui::icon($categories->name)) }}"/></svg></span>
                        @endif
                    </div>
                    <div class="card__body">
                        <span class="card__kicker">{{ $categories->name }}</span>
                        <h3>{{ $sub->name }}</h3>
                        <p>{{ $Ui::excerpt($sub->short_description, 130) }}</p>
                        <span class="tlink">Explore <svg class="icon"><use href="#i-arrow"/></svg></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($services->count() > 0)
<section class="section {{ $subcategories->count() ? 'section--soft' : '' }}" @if(!$subcategories->count()) id="offerings" style="scroll-margin-top:64px" @endif>
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Services</span>
                <h2 class="h2">All {{ $categories->name }} services</h2>
            </div>
        </div>
        <div class="tiles">
            @foreach($services as $service)
                <a href="{{ url($service->slug) }}" class="tile rv">
                    <span class="cell__ico"><svg class="icon"><use href="#{{ $Ui::icon($service->name, $Ui::icon($categories->name)) }}"/></svg></span>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $Ui::excerpt($service->short_description, 110) }}</p>
                    <span class="tlink">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!empty($categories->description))
<section class="section">
    <div class="container split">
        <div class="rv">
            <span class="label">Why Leamsoft</span>
            <h2 class="h2">{{ $categories->name }}, <span class="dim">done right.</span></h2>
        </div>
        <div class="prose rv">{!! $categories->description !!}</div>
    </div>
</section>
@endif

@include('frontend.partials.cta', [
    'ctaTitle' => 'Have a ' . e($categories->name) . ' project? <span style="color:var(--faint)">Let’s talk.</span>',
    'ctaText'  => 'Tell us your goals and timeline — we’ll come back with a plan and a clear estimate.',
])
@push('schema')
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::serviceSchema($categories, url($categories->slug), null), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
@endsection
