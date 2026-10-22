@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;
    $trail = ['Home' => url('/'), 'Services' => url('services')];
    if ($categories) {
        $trail[$categories->name] = url($categories->slug);
    }
    $trail[$subcategory->name] = null;
    $fallbackIcon = $Ui::icon($subcategory->name, $Ui::icon(optional($categories)->name));
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container phero__split">
        <div>
            @include('frontend.partials.crumbs', ['trail' => $trail])
            <h1>{!! $Ui::dimTail($subcategory->name, 1) !!}</h1>
            @if($subcategory->short_description)
                <p class="lead">{{ $Ui::excerpt($subcategory->short_description, 320) }}</p>
            @endif
            <div class="phero__cta">
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Request a quote <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                @if($categories)
                    <a href="{{ url($categories->slug) }}" class="btn btn--ghost">More in {{ $categories->name }}</a>
                @endif
            </div>
        </div>
        <div class="phero__media">
            @if($subcategory->thumb_url)
                <img src="{{ $subcategory->thumb_url }}" alt="{{ $subcategory->image_alt ?? $subcategory->name }}" fetchpriority="high" decoding="async">
            @else
                <span class="ph"><svg class="icon"><use href="#{{ $fallbackIcon }}"/></svg></span>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($services->count() > 0)
            <div class="sec-head rv">
                <div>
                    <span class="label">Offerings</span>
                    <h2 class="h2">{{ $subcategory->name }} <span class="dim">services.</span></h2>
                </div>
            </div>
            <div class="cards">
                @foreach($services as $service)
                    <a href="{{ url($service->slug) }}" class="card rv">
                        <div class="card__media">
                            @if($service->thumb_url)
                                <img src="{{ $service->thumb_url }}" alt="{{ $service->image_alt ?? $service->name }}" loading="lazy" decoding="async">
                            @else
                                <span class="ph"><svg class="icon"><use href="#{{ $Ui::icon($service->name, $fallbackIcon) }}"/></svg></span>
                            @endif
                        </div>
                        <div class="card__body">
                            <span class="card__kicker">{{ $subcategory->name }}</span>
                            <h3>{{ $service->name }}</h3>
                            <p>{{ $Ui::excerpt($service->short_description, 120) }}</p>
                            <span class="tlink">View details <svg class="icon"><use href="#i-arrow"/></svg></span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty rv">
                <h2>Services coming soon</h2>
                <p>We’re documenting our {{ $subcategory->name }} offerings. In the meantime, tell us what you need.</p>
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Contact us <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            </div>
        @endif
    </div>
</section>

@if(!empty($subcategory->description))
<section class="section section--soft">
    <div class="container split">
        <div class="rv">
            <span class="label">In detail</span>
            <h2 class="h2">{{ $subcategory->name }}, <span class="dim">explained.</span></h2>
        </div>
        <div class="prose rv">{!! $subcategory->description !!}</div>
    </div>
</section>
@endif

@include('frontend.partials.cta')
@push('schema')
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::serviceSchema($subcategory, url($subcategory->slug), optional($categories)->name), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
@endsection
