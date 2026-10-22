@extends('layouts.master')

@section('content')
@php
    $plain = strip_tags((string) $blogDetail->description);
    $readMins = max(1, (int) ceil(str_word_count($plain) / 220));
    $shareUrl = urlencode(url()->current());
@endphp

<section class="section--tight" style="padding-top:64px">
    <div class="container">
        <article class="article">
            @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Blog' => url('blog'), \Illuminate\Support\Str::limit($blogDetail->name, 40) => null]])
            <h1>{{ $blogDetail->name }}</h1>
            @if(!empty($blogDetail->short_description))
                <p class="lead">{{ $blogDetail->short_description }}</p>
            @endif
            <div class="meta-line">
                <time datetime="{{ $blogDetail->created_at?->toDateString() }}">{{ $blogDetail->created_at?->format('F d, Y') }}</time>
                <span class="dot"></span>
                <span>{{ $readMins }} min read</span>
                <span class="dot"></span>
                <span>Leamsoft team</span>
            </div>

            @if(!empty($blogDetail->banner))
                <figure class="article-cover">
                    <img src="{{ url('storage/' . $blogDetail->banner) }}" alt="{{ $blogDetail->image_alt ?? $blogDetail->name }}" width="1536" height="1024" fetchpriority="high" decoding="async">
                </figure>
            @endif

            <div class="prose">
                {!! $blogDetail->description !!}
            </div>

            <div class="share">
                <a href="{{ url('blog') }}" class="tlink"><svg class="icon"><use href="#i-arrow-l"/></svg>All posts</a>
                <div class="social">
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ urlencode($blogDetail->name) }}" target="_blank" rel="noopener" aria-label="Share on X"><svg class="icon"><use href="#i-xs"/></svg></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg class="icon"><use href="#i-in"/></svg></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><svg class="icon"><use href="#i-fb"/></svg></a>
                    <a href="https://wa.me/?text={{ urlencode($blogDetail->name . ' ' . url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg class="icon"><use href="#i-wa"/></svg></a>
                    <a href="mailto:?subject={{ rawurlencode($blogDetail->name ?? '') }}&body={{ $shareUrl }}" aria-label="Share by email"><svg class="icon"><use href="#i-mail"/></svg></a>
                </div>
            </div>
        </article>
    </div>
</section>

@if(!empty($related) && $related->count() > 0)
<section class="section section--soft">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">Keep reading</span>
                <h2 class="h2">More from the blog</h2>
            </div>
            <a href="{{ url('blog') }}" class="btn btn--ghost">All posts <svg class="icon arr"><use href="#i-arrow"/></svg></a>
        </div>
        <div class="cards">
            @foreach($related as $rel)
                @include('frontend.partials.blog-card', ['blog' => $rel])
            @endforeach
        </div>
    </div>
</section>
@endif

@include('frontend.partials.cta')

@push('schema')
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::articleSchema($blogDetail, $seo), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush
@endsection
