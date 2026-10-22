{{-- Optional: $ctaTitle (HTML allowed), $ctaText, $ctaSecondary ['label' => url] --}}
<section class="section--tight">
    <div class="container">
        <div class="cta rv">
            <div>
                <h2>{!! $ctaTitle ?? 'Have a project in mind? <span style="color:var(--faint)">Let’s talk.</span>' !!}</h2>
                <p>{{ $ctaText ?? 'Whether you have a detailed brief or just an idea, a senior engineer will reply within one business day.' }}</p>
            </div>
            <div class="cta__btns">
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Start a project <svg class="icon arr"><use href="#i-arrow"/></svg></a>
                @foreach(($ctaSecondary ?? ['Explore services' => url('services')]) as $label => $href)
                    <a href="{{ $href }}" class="btn btn--ghost">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>
