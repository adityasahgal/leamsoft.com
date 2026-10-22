@extends('layouts.master')

@section('content')
<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Blog' => null]])
        <h1>The Leamsoft <span class="dim">blog.</span></h1>
        <p class="lead">AI, innovation and engineering — practical thinking from the team building software at Leamsoft.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        @if(isset($blogs) && $blogs->count() > 0)
            <h2 class="sr-only">Latest posts</h2>
            <div class="cards">
                @foreach($blogs as $blog)
                    @include('frontend.partials.blog-card', ['blog' => $blog])
                @endforeach
            </div>

            @if(method_exists($blogs, 'links'))
                {{ $blogs->links('frontend.partials.pagination') }}
            @endif
        @else
            <div class="empty">
                <h2>No posts yet</h2>
                <p>We’re writing our first pieces. Check back soon.</p>
                <a href="{{ url('/') }}" class="btn btn--primary">Back to home</a>
            </div>
        @endif
    </div>
</section>

@include('frontend.partials.cta')
@endsection
