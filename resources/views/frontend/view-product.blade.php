@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;
    $svc = $productrow;

    $trail = ['Home' => url('/'), 'Services' => url('services')];
    if ($svc->category) {
        $trail[$svc->category->name] = url($svc->category->slug);
    }
    if ($svc->subcategory) {
        $trail[$svc->subcategory->name] = url($svc->subcategory->slug);
    }
    $trail[$svc->name] = null;

    $thumb = $svc->thumb_url ?? optional($svc->subcategory)->thumb_url ?? optional($svc->category)->thumb_url;
    $icon  = $Ui::icon($svc->name, $Ui::icon(optional($svc->category)->name));

    $photos = [];
    if (!empty($svc->photos)) {
        $decoded = json_decode($svc->photos, true);
        if (is_array($decoded)) {
            $photos = $decoded;
        }
    }
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container phero__split">
        <div>
            @include('frontend.partials.crumbs', ['trail' => $trail])
            <h1>{{ $svc->h1_tag ?? $svc->name }}</h1>
            @if($svc->short_description)
                <p class="lead">{{ $Ui::excerpt($svc->short_description, 320) }}</p>
            @endif
            @if($svc->category || $svc->subcategory || $svc->featured)
                <div class="tags">
                    @if($svc->featured)<span style="color:var(--brand);border-color:var(--brand-soft);background:var(--brand-soft)">Featured</span>@endif
                    @if($svc->category)<a href="{{ url($svc->category->slug) }}">{{ $svc->category->name }}</a>@endif
                    @if($svc->subcategory)<a href="{{ url($svc->subcategory->slug) }}">{{ $svc->subcategory->name }}</a>@endif
                </div>
            @endif
            <div class="phero__cta">
                <a href="#enquire" class="btn btn--primary">Get a free quote <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                <a href="{{ url('contact-us') }}" class="btn btn--ghost">Talk to us</a>
            </div>
        </div>
        <div class="phero__media">
            @if($thumb)
                <img src="{{ $thumb }}" alt="{{ $svc->image_alt ?? $svc->name }}" fetchpriority="high" decoding="async">
            @else
                <span class="ph"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
            @endif
        </div>
    </div>
</section>

<section class="section--tight" style="padding-bottom:0">
    <div class="container">
        <div class="facts rv">
            <div><span class="cell__ico"><svg class="icon"><use href="#i-bolt"/></svg></span><span><small>Delivery</small><strong>2 – 12 weeks</strong></span></div>
            <div><span class="cell__ico"><svg class="icon"><use href="#i-users"/></svg></span><span><small>Team</small><strong>Senior engineers</strong></span></div>
            <div><span class="cell__ico"><svg class="icon"><use href="#i-shield"/></svg></span><span><small>Support</small><strong>24/7 coverage</strong></span></div>
            <div><span class="cell__ico"><svg class="icon"><use href="#i-hand"/></svg></span><span><small>Engagement</small><strong>Flexible models</strong></span></div>
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container layout">
        <div>
            <div class="prose">
                @if(!empty($svc->description))
                    {!! $svc->description !!}
                @else
                    <p>{{ $svc->short_description }}</p>
                @endif
            </div>

            @if(count($photos) > 0)
                <h2 style="font-size:22px;margin-top:48px">Gallery</h2>
                <div class="gal">
                    @foreach($photos as $photo)
                        <img src="{{ url('storage/' . $photo) }}" alt="{{ $svc->image_alt ?? $svc->name }}" loading="lazy" decoding="async">
                    @endforeach
                </div>
            @endif
        </div>

        <aside class="aside">
            <div class="box" id="enquire" style="scroll-margin-top:88px" @if(session('status')) data-scroll-here @endif>
                <h2>Get a free quote</h2>
                <p>Tell us about your project — we respond within one business day.</p>
                <form class="form" action="{{ url('storeEnquiry') }}" method="POST">
                    @csrf
                    @if(session('status'))
                        <div class="notice {{ session('status') == 'success' ? 'notice--ok' : 'notice--err' }}" role="status">
                            <svg class="icon"><use href="#{{ session('status') == 'success' ? 'i-check' : 'i-alert' }}"/></svg>
                            <span>{{ session('message') }}</span>
                        </div>
                    @endif
                    <input type="hidden" name="pname" value="{{ $svc->name }}">
                    <div class="field"><label for="q-name">Name</label><input id="q-name" type="text" name="name" autocomplete="name" required></div>
                    <div class="field"><label for="q-email">Email</label><input id="q-email" type="email" name="email" autocomplete="email" required></div>
                    <div class="field"><label for="q-phone">Phone</label><input id="q-phone" type="tel" name="phone" autocomplete="tel" required></div>
                    <div class="field"><label for="q-msg">Project details</label><textarea id="q-msg" name="message" placeholder="Goals, timeline, budget…" style="height:96px"></textarea></div>
                    <button type="submit" class="btn btn--primary">Send enquiry <svg class="icon arr"><use href="#i-arrow"/></svg></button>
                </form>
            </div>

            <div class="box box--soft">
                <h2>Prefer to talk?</h2>
                <div class="clist">
                    @if(!empty($genSetting['phone']))
                        <a href="tel:{{ $genSetting['phone'] }}"><span class="ci"><svg class="icon"><use href="#i-phone"/></svg></span><span><small>Phone</small><strong>{{ $genSetting['phone'] }}</strong></span></a>
                    @endif
                    @if(!empty($genSetting['email']))
                        <a href="mailto:{{ $genSetting['email'] }}"><span class="ci"><svg class="icon"><use href="#i-mail"/></svg></span><span><small>Email</small><strong>{{ $genSetting['email'] }}</strong></span></a>
                    @endif
                    <div><span class="ci"><svg class="icon"><use href="#i-clock"/></svg></span><span><small>Hours</small><strong>Mon – Sat, 9am – 7pm</strong></span></div>
                </div>
            </div>
        </aside>
    </div>
</section>

@if(!empty($related) && $related->count() > 0)
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Related</span>
                <h2 class="h2">You might also need</h2>
            </div>
            <a href="{{ url('services') }}" class="btn btn--ghost">All services <svg class="icon arr"><use href="#i-arrow"/></svg></a>
        </div>
        <div class="tiles">
            @foreach($related as $rel)
                <a href="{{ url($rel->slug) }}" class="tile rv">
                    <span class="cell__ico"><svg class="icon"><use href="#{{ $Ui::icon($rel->name, $icon) }}"/></svg></span>
                    <h3>{{ $rel->name }}</h3>
                    <p>{{ $Ui::excerpt($rel->short_description, 100) }}</p>
                    <span class="tlink">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@push('schema')
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::serviceSchema($svc, url($svc->slug), optional($svc->category)->name), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
@endsection
