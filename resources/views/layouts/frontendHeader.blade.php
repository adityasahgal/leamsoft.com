@php
    $brandName = $genSetting['site_name'] ?? $genSetting['name'] ?? 'Leamsoft';
    $logoUrl   = \App\Support\Ui::logoUrl($genSetting);
    $onHome    = request()->is('/');
    // On the home page "Start a project" jumps to the inline form
    $startUrl  = $onHome ? '#contact' : url('contact-us');
@endphp
<header class="header" id="header">
    <div class="container nav">
        <a href="{{ url('/') }}" class="logo" aria-label="{{ $brandName }} home">
            @if($logoUrl)
                <img class="logo__img" src="{{ $logoUrl }}" alt="{{ $brandName }}" height="36">
            @else
                <span class="logo__mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16h11"/></svg></span>Leamsoft
            @endif
        </a>

        <nav aria-label="Primary">
            <ul class="menu">
                <li class="has-mega">
                    <button type="button" aria-expanded="false" class="{{ request()->is('services') ? 'on' : '' }}">Services <svg class="chev"><use href="#i-chev"/></svg></button>
                    <div class="mega">
                        @forelse($navCategories as $navCat)
                            <a href="{{ url($navCat->slug) }}">
                                <span class="mi"><svg class="icon"><use href="#{{ \App\Support\Ui::icon($navCat->name) }}"/></svg></span>
                                <span><strong>{{ $navCat->name }}</strong><span>{{ \App\Support\Ui::excerpt($navCat->short_description, 48) }}</span></span>
                            </a>
                        @empty
                            <a href="{{ url('services') }}">
                                <span class="mi"><svg class="icon"><use href="#i-code"/></svg></span>
                                <span><strong>All services</strong><span>Software, AI, cloud &amp; more</span></span>
                            </a>
                        @endforelse
                        <div class="mega__foot">
                            <a href="{{ url('services') }}" class="tlink" style="padding:0">All services <svg class="icon"><use href="#i-arrow"/></svg></a>
                            <a href="{{ url('contact-us') }}" class="tlink" style="padding:0">Book a free consultation <svg class="icon"><use href="#i-arrow"/></svg></a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ url('gallery') }}" class="{{ request()->is('gallery') ? 'on' : '' }}">Work</a></li>
                <li><a href="{{ url('about-us') }}" class="{{ request()->is('about-us') ? 'on' : '' }}">Company</a></li>
                <li><a href="{{ url('blog') }}" class="{{ request()->is('blog*') ? 'on' : '' }}">Blog</a></li>
                <li><a href="{{ url('faq') }}" class="{{ request()->is('faq') ? 'on' : '' }}">FAQ</a></li>
                <li><a href="{{ url('contact-us') }}" class="{{ request()->is('contact-us') ? 'on' : '' }}">Contact</a></li>
            </ul>
        </nav>

        <div class="nav__right">
            <a href="{{ $startUrl }}" class="btn btn--primary btn--sm">Start a project <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            <button class="burger" id="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="drawer"><svg class="icon"><use href="#i-menu"/></svg></button>
        </div>
    </div>
</header>

<div class="drawer" id="drawer">
    <details>
        <summary>Services <svg class="icon"><use href="#i-chev"/></svg></summary>
        @foreach($navCategories as $navCat)
            <a href="{{ url($navCat->slug) }}">{{ $navCat->name }}</a>
        @endforeach
        <a href="{{ url('services') }}">All services</a>
    </details>
    <a href="{{ url('gallery') }}">Work</a>
    <a href="{{ url('about-us') }}">Company</a>
    <a href="{{ url('blog') }}">Blog</a>
    <a href="{{ url('faq') }}">FAQ</a>
    <a href="{{ url('contact-us') }}">Contact</a>
    <a href="{{ $startUrl }}" class="btn btn--primary">Start a project</a>
</div>
