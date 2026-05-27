@php
    $navCategories = \App\Models\Category::with(['subcategories' => function($q) {
        $q->where('status', 1)->orderBy('sort_order')->take(6);
    }])->where('status', 1)->orderBy('sort_order')->take(6)->get();
@endphp
<style>
    /* ─── TOP BAR ─── */
    .leam-topbar {
        background: #0d0d0d;
        border-bottom: 1px solid var(--border);
        padding: 6px 0;
        font-size: 12px;
        color: var(--muted);
    }
    .leam-topbar-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }
    .leam-topbar a { color: var(--muted); text-decoration: none; transition: color .2s; }
    .leam-topbar a:hover { color: var(--white); }
    .leam-topbar-left, .leam-topbar-right { display: flex; gap: 20px; align-items: center; }

    /* ─── NAVBAR ─── */
    .leam-nav {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(10,10,10,0.95);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--border);
    }
    .leam-nav-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        height: 70px;
        gap: 0;
    }
    .leam-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
        margin-right: 40px;
    }
    .leam-logo:hover { text-decoration: none; }
    .leam-logo-box {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: var(--dark);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .leam-logo-box::before {
        content: '';
        position: absolute;
        inset: -2px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 3s linear infinite;
        border-radius: 10px;
        z-index: 0;
    }
    .leam-logo-box span {
        position: relative;
        z-index: 1;
        background: var(--black);
        width: 34px;
        height: 34px;
        border-radius: 6px;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 16px;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .leam-logo-text {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 26px;
        letter-spacing: 3px;
        background: var(--rainbow);
        background-size: 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shift 4s linear infinite;
    }

    .leam-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        flex: 1;
        margin: 0;
        padding: 0;
    }
    .leam-nav-links > li { position: relative; }
    .leam-nav-links > li > a {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        border-radius: 6px;
        transition: all .2s;
        white-space: nowrap;
        font-family: 'Barlow Condensed', sans-serif;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .leam-nav-links > li > a:hover,
    .leam-nav-links > li:hover > a {
        color: #fff;
        background: rgba(255,255,255,0.06);
        text-decoration: none;
    }
    .leam-nav-links > li > a .arr {
        font-size: 9px;
        opacity: 0.6;
        transition: transform .2s;
    }
    .leam-nav-links > li:hover > a .arr { transform: rotate(180deg); }
    .leam-nav-links > li > a.active {
        color: #00b4ff;
        background: rgba(0,180,255,0.08);
    }

    /* Mega Dropdown */
    .leam-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: -20px;
        width: 600px;
        background: #111;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 8px;
        display: none;
        grid-template-columns: 220px 1fr;
        box-shadow: 0 24px 80px rgba(0,0,0,0.7);
        overflow: hidden;
    }
    .leam-nav-links > li:hover .leam-dropdown { display: grid; }

    .leam-dd-left {
        padding: 8px;
        border-right: 1px solid rgba(255,255,255,0.06);
    }
    .leam-dd-left-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        transition: background .2s;
        color: rgba(255,255,255,0.75);
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
    }
    .leam-dd-left-item:hover { background: rgba(255,255,255,0.07); color: #fff; text-decoration: none; }
    .leam-dd-icon {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        background: rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .leam-dd-right {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .leam-dd-feature {
        background: rgba(255,255,255,0.04);
        border-radius: 10px;
        padding: 14px;
        transition: background .2s;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    .leam-dd-feature:hover { background: rgba(255,255,255,0.08); text-decoration: none; }
    .leam-dd-feature-title { font-size: 13.5px; font-weight: 600; color: #fff; margin-bottom: 2px; }
    .leam-dd-feature-desc { font-size: 12px; color: var(--muted); }
    .leam-dd-feature-link { font-size: 12px; color: #00b4ff; margin-top: 6px; display: inline-block; }

    .leam-nav-cta {
        margin-left: auto;
        display: flex;
        gap: 10px;
        align-items: center;
        flex-shrink: 0;
    }
    .leam-btn-outline-nav {
        padding: 8px 18px;
        border: 1.5px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        background: transparent;
        color: #fff;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all .2s;
        font-family: 'Barlow', sans-serif;
        white-space: nowrap;
    }
    .leam-btn-outline-nav:hover { border-color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.05); color: #fff; text-decoration: none; }
    .leam-btn-primary-nav {
        padding: 8px 20px;
        border-radius: 8px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        border: none;
        color: #000;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Barlow', sans-serif;
        transition: opacity .2s;
        white-space: nowrap;
    }
    .leam-btn-primary-nav:hover { opacity: 0.9; color: #000; text-decoration: none; }

    .leam-hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 8px; background: transparent; border: none; }
    .leam-hamburger span { width: 22px; height: 2px; background: #fff; border-radius: 2px; }

    .leam-mobile-menu {
        display: none;
        flex-direction: column;
        background: #111;
        border-top: 1px solid var(--border);
        padding: 16px;
        gap: 4px;
    }
    .leam-mobile-menu.open { display: flex; }
    .leam-mobile-menu a {
        padding: 12px 14px;
        border-radius: 8px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Barlow Condensed', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: background .2s;
    }
    .leam-mobile-menu a:hover { background: rgba(255,255,255,0.07); color: #fff; }

    @media (max-width: 1000px) {
        .leam-nav-links { display: none; }
        .leam-hamburger { display: flex; }
        .leam-nav-cta .leam-btn-outline-nav { display: none; }
    }
    @media (max-width: 600px) {
        .leam-topbar { display: none; }
    }
</style>

<!-- TOP BAR -->
<div class="leam-topbar">
    <div class="leam-topbar-inner">
        <div class="leam-topbar-left">
            @if(!empty($genSetting['email']))
                <a href="mailto:{{ $genSetting['email'] }}">✉ {{ $genSetting['email'] }}</a>
            @endif
            @if(!empty($genSetting['phone']))
                <a href="tel:{{ $genSetting['phone'] }}">📞 {{ $genSetting['phone'] }}</a>
            @endif
        </div>
        <div class="leam-topbar-right">
            <a href="#">🌐 English</a>
            <a href="{{ url('admin/login') }}">Client Portal</a>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="leam-nav">
    <div class="leam-nav-inner">
        <a href="{{ url('/') }}" class="leam-logo">
            <div class="leam-logo-box"><span>LS</span></div>
            <span class="leam-logo-text">LEAMSOFT</span>
        </a>

        <ul class="leam-nav-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('about-us') }}" class="{{ request()->is('about-us') ? 'active' : '' }}">About</a></li>

            <li>
                <a href="{{ url('services') }}" class="{{ request()->is('services*') ? 'active' : '' }}">Services <span class="arr">▼</span></a>
                @if($navCategories->count() > 0)
                <div class="leam-dropdown">
                    <div class="leam-dd-left">
                        @foreach($navCategories as $navCat)
                            <a class="leam-dd-left-item" href="{{ url($navCat->slug) }}" data-cat="{{ $navCat->slug }}" onmouseenter="leamShowCatFeatures('{{ $navCat->slug }}')">
                                <span class="leam-dd-icon">{{ $navCat->icon ?? '🔧' }}</span> {{ $navCat->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="leam-dd-right">
                        @foreach($navCategories as $idx => $navCat)
                            <div class="leam-dd-features-group" data-cat="{{ $navCat->slug }}" style="display: {{ $idx === 0 ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                                @foreach($navCat->subcategories->take(3) as $sub)
                                    <a class="leam-dd-feature" href="{{ url($sub->slug) }}">
                                        <div class="leam-dd-feature-title">{{ $sub->icon ?? '•' }} {{ $sub->name }}</div>
                                        <div class="leam-dd-feature-desc">{{ \Illuminate\Support\Str::limit($sub->short_description, 80) }}</div>
                                        <span class="leam-dd-feature-link">Learn More →</span>
                                    </a>
                                @endforeach
                                @if($navCat->subcategories->count() === 0)
                                    <a class="leam-dd-feature" href="{{ url($navCat->slug) }}">
                                        <div class="leam-dd-feature-title">{{ $navCat->icon }} {{ $navCat->name }}</div>
                                        <div class="leam-dd-feature-desc">{{ \Illuminate\Support\Str::limit($navCat->short_description, 100) }}</div>
                                        <span class="leam-dd-feature-link">Explore →</span>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </li>

            <li><a href="{{ url('blog') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ url('gallery') }}" class="{{ request()->is('gallery') ? 'active' : '' }}">Projects</a></li>
            <li><a href="{{ url('faq') }}" class="{{ request()->is('faq') ? 'active' : '' }}">FAQ</a></li>
            <li><a href="{{ url('contact-us') }}" class="{{ request()->is('contact-us') ? 'active' : '' }}">Contact</a></li>
        </ul>

        <div class="leam-nav-cta">
            <a href="{{ url('contact-us') }}" class="leam-btn-outline-nav">Contact</a>
            <a href="{{ url('contact-us') }}" class="leam-btn-primary-nav">Get Started</a>
            <button class="leam-hamburger" onclick="document.getElementById('leamMobileMenu').classList.toggle('open')">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="leam-mobile-menu" id="leamMobileMenu">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('about-us') }}">About</a>
        <a href="{{ url('services') }}">Services</a>
        @foreach($navCategories as $navCat)
            <a href="{{ url($navCat->slug) }}" style="padding-left:30px; font-size:13px; color: var(--muted);">↳ {{ $navCat->name }}</a>
        @endforeach
        <a href="{{ url('blog') }}">Blog</a>
        <a href="{{ url('gallery') }}">Projects</a>
        <a href="{{ url('faq') }}">FAQ</a>
        <a href="{{ url('contact-us') }}">Contact</a>
        <a href="{{ url('contact-us') }}" style="color:#00b4ff; font-weight:700;">Get Started →</a>
    </div>
</nav>

<div class="rainbow-divider"></div>

<script>
function leamShowCatFeatures(slug) {
    document.querySelectorAll('.leam-dd-features-group').forEach(g => g.style.display = 'none');
    var target = document.querySelector('.leam-dd-features-group[data-cat="' + slug + '"]');
    if (target) target.style.display = 'flex';
    document.querySelectorAll('.leam-dd-left-item').forEach(a => a.classList.remove('active'));
    var activeLink = document.querySelector('.leam-dd-left-item[data-cat="' + slug + '"]');
    if (activeLink) activeLink.classList.add('active');
}
</script>
<style>
    .leam-dd-left-item.active { background: rgba(0,180,255,0.08); color: #00b4ff; }
</style>
