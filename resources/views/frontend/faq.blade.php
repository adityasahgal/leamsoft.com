@extends('layouts.master')

@section('content')
@php
    $faqs = config('site.faqs', []);
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'FAQ' => null]])
        <h1>Frequently asked <span class="dim">questions.</span></h1>
        <p class="lead">Quick answers to what people usually ask before starting a project with us. Can’t find yours? Just ask.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container faq">
        <div>
            <div class="box box--soft" style="position:sticky;top:88px">
                <h2>Still have questions?</h2>
                <p>Talk to an engineer — we reply within one business day.</p>
                <div class="hero__cta" style="margin-top:20px">
                    <a href="{{ url('contact-us') }}" class="btn btn--primary btn--sm">Contact us <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                    <a href="{{ url('help') }}" class="btn btn--ghost btn--sm">Help center</a>
                </div>
            </div>
        </div>
        <div>
            @foreach($faqs as $group => $items)
                <div class="faqg rv">
                    <span class="label">{{ $group }}</span>
                    <div>
                        @foreach($items as [$q, $a])
                            <details>
                                <summary>{{ $q }} <svg class="icon"><use href="#i-plus"/></svg></summary>
                                <p>{{ $a }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => collect($faqs)->flatten(1)->map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@endsection
