{{-- Our work / projects (route: /gallery) --}}
@extends('layouts.master')

@section('content')
@php
    $Ui = \App\Support\Ui::class;
    $active = request('cat');
    $portfolio = $services->when($active, fn ($c) => $c->filter(fn ($p) => optional($p->category)->slug === $active));
    // Only offer filters for categories that actually have work in them
    $filterCats = $services->pluck('category')->filter()->unique('id')->sortBy('sort_order');
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Work' => null]])
        <h1>Systems our clients <span class="dim">run on every day.</span></h1>
        <p class="lead">A look at the platforms, apps and automation we’ve designed, built and continue to support.</p>
        <div class="hero__meta">
            <div><strong>100+</strong>Projects delivered</div>
            <div><strong>12+</strong>Industries</div>
            <div><strong>97%</strong>Client satisfaction</div>
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        @if($filterCats->count() > 1)
            <nav class="filters" aria-label="Filter by category">
                <a href="{{ url('gallery') }}" class="{{ !$active ? 'on' : '' }}">All</a>
                @foreach($filterCats as $c)
                    <a href="{{ url('gallery?cat=' . $c->slug) }}" class="{{ $active === $c->slug ? 'on' : '' }}">{{ $c->name }}</a>
                @endforeach
            </nav>
        @endif

        @if($portfolio->count() > 0)
            <h2 class="sr-only">Projects</h2>
            <div class="cards">
                @foreach($portfolio as $project)
                    @php
                        $thumb = $project->thumb_url
                            ?? optional($project->subcategory)->thumb_url
                            ?? optional($project->category)->thumb_url;
                    @endphp
                    <a href="{{ url($project->slug) }}" class="card rv">
                        <div class="card__media">
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $project->image_alt ?? $project->name }}" loading="lazy" decoding="async">
                            @else
                                <span class="ph"><svg class="icon"><use href="#{{ $Ui::icon($project->name, $Ui::icon(optional($project->category)->name)) }}"/></svg></span>
                            @endif
                        </div>
                        <div class="card__body">
                            <span class="card__kicker">{{ optional($project->category)->name ?? 'Project' }}</span>
                            <h3>{{ $project->name }}</h3>
                            <p>{{ $Ui::excerpt($project->short_description, 110) }}</p>
                            <span class="tlink">View project <svg class="icon"><use href="#i-arrow"/></svg></span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty">
                <h2>Nothing here yet</h2>
                <p>We’re adding case studies to this section. Want to be the next one?</p>
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Start a project <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            </div>
        @endif
    </div>
</section>

@include('frontend.partials.cta', [
    'ctaTitle' => 'Your project could be next. <span style="color:var(--faint)">Let’s talk.</span>',
])
@endsection
