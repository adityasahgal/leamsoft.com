@extends('layouts.master')

@section('content')
@php
    $topics = [
        ['i-help',    'Frequently asked',     'Quick answers about engagements, pricing and timelines.',        url('faq')],
        ['i-grid',    'Services & categories', 'Every service we offer, organised by category.',                url('services')],
        ['i-chat',    'Talk to sales',        'Start a project, get a quote or book a discovery call.',          url('contact-us')],
        ['i-book',    'Articles & guides',    'Engineering, AI and growth lessons from our team.',               url('blog')],
        ['i-lock',    'Privacy & data',       'How we handle your data and our security commitments.',           url('privacy-policy')],
        ['i-file',    'Terms of service',     'Our services agreement and website usage terms.',                 url('terms-condition')],
    ];
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Help center' => null]])
        <h1>How can we <span class="dim">help?</span></h1>
        <p class="lead">Browse common topics below or reach out directly — we typically respond within one business day.</p>
        <div class="hsearch">
            <svg aria-hidden="true"><use href="#i-search"/></svg>
            <label class="sr-only" for="help-q">Search help topics</label>
            <input id="help-q" type="search" placeholder="Search help topics…" autocomplete="off">
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <h2 class="sr-only">Help topics</h2>
        <div class="tiles" id="help-topics">
            @foreach($topics as [$icon, $title, $desc, $href])
                <a href="{{ $href }}" class="tile rv">
                    <span class="cell__ico"><svg class="icon"><use href="#{{ $icon }}"/></svg></span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                    <span class="tlink">Open <svg class="icon"><use href="#i-arrow"/></svg></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Still stuck?</span>
                <h2 class="h2">Get in touch directly. <span class="dim">A human will reply.</span></h2>
            </div>
        </div>
        <div class="tiles tiles--4 rv">
            @if(!empty($genSetting['email']))
                <a href="mailto:{{ $genSetting['email'] }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-mail"/></svg></span><h3>Email</h3><p>{{ $genSetting['email'] }}</p></a>
            @endif
            @if(!empty($genSetting['phone']))
                <a href="tel:{{ $genSetting['phone'] }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-phone"/></svg></span><h3>Phone</h3><p>{{ $genSetting['phone'] }}</p></a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $genSetting['phone']) }}" target="_blank" rel="noopener" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-wa"/></svg></span><h3>WhatsApp</h3><p>Quick chat, 9am – 7pm IST</p></a>
            @endif
            <a href="{{ url('contact-us') }}" class="tile"><span class="cell__ico"><svg class="icon"><use href="#i-file"/></svg></span><h3>Contact form</h3><p>Send us a project brief</p></a>
        </div>
    </div>
</section>

@push('scripts')
<script nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}">
    (function () {
        var q = document.getElementById('help-q');
        var tiles = document.querySelectorAll('#help-topics .tile');
        if (!q) return;
        q.addEventListener('input', function () {
            var term = q.value.trim().toLowerCase();
            tiles.forEach(function (t) {
                t.style.display = !term || t.textContent.toLowerCase().indexOf(term) !== -1 ? '' : 'none';
            });
        });
    })();
</script>
@endpush
@endsection
