{{-- One blog post as a card. Expects $blog. --}}
<a href="{{ url('blog/' . $blog->slug) }}" class="card card--blog rv">
    <div class="card__media">
        @if(!empty($blog->banner))
            <img src="{{ url('storage/' . $blog->banner) }}" alt="{{ $blog->image_alt ?? $blog->name }}" loading="lazy" decoding="async">
        @else
            <span class="ph"><svg class="icon"><use href="#i-book"/></svg></span>
        @endif
    </div>
    <div class="card__body">
        <time class="card__kicker" datetime="{{ $blog->created_at?->toDateString() }}">{{ $blog->created_at?->format('M d, Y') }}</time>
        <h3>{{ $blog->name }}</h3>
        <p>{{ \App\Support\Ui::excerpt($blog->short_description ?? $blog->description, 130) }}</p>
        <span class="tlink">Read post <svg class="icon"><use href="#i-arrow"/></svg></span>
    </div>
</a>
