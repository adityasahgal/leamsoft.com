{{-- Areas we serve (route: /near_by) --}}
@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;
    $cities = array_values(array_unique(array_merge(
        config('seo.geo.primary', []),
        array_diff(config('seo.geo.secondary', []), ['Delhi NCR'])
    )));
    $localities = config('seo.geo.localities', []);
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Areas we serve' => null]])
        <h1>Your technology partner, <span class="dim">right here in Delhi NCR.</span></h1>
        <p class="lead">Leamsoft works with businesses across Noida, Greater Noida, Ghaziabad, Delhi, Gurugram and Faridabad — close enough to meet in person, and fully set up for remote delivery across India.</p>
        <div class="phero__cta">
            <a href="{{ url('contact-us') }}" class="btn btn--primary">Book a meeting <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            <a href="{{ url('services') }}" class="btn btn--ghost">Our services</a>
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Cities</span>
                <h2 class="h2">Where we work <span class="dim">on-site.</span></h2>
            </div>
        </div>
        <ul class="inds rv">
            @foreach($cities as $city)
                <li><svg class="icon"><use href="#i-pin"/></svg>{{ $city }}</li>
            @endforeach
        </ul>

        @if(count($localities))
            <div class="tags rv" style="margin-top:32px">
                @foreach($localities as $loc)
                    <span>{{ $loc }}</span>
                @endforeach
            </div>
        @endif
    </div>
</section>

@if($navCategories->count())
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Services near you</span>
                <h2 class="h2">What we build <span class="dim">for local businesses.</span></h2>
            </div>
        </div>
        <div class="tiles">
            @foreach($navCategories as $cat)
                <a href="{{ url($cat->slug) }}" class="tile rv">
                    <span class="cell__ico"><svg class="icon"><use href="#{{ $Ui::icon($cat->name) }}"/></svg></span>
                    <h3>{{ $cat->name }}</h3>
                    <p>{{ $Ui::excerpt($cat->short_description, 110) }}</p>
                    <span class="tlink">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        @include('frontend.partials.contact', [
            'contactTitle' => 'Meet us in <span style="color:var(--faint)">Delhi NCR.</span>',
            'contactLead'  => 'Prefer to talk face to face? Tell us a little about your project and we’ll set up a meeting at your office or ours.',
        ])
    </div>
</section>
@endsection
