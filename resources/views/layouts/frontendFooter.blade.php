<style>
    .leam-footer {
        background: #090909;
        border-top: 1px solid var(--border);
        padding: 64px 24px 0;
        position: relative;
    }
    .leam-footer-grid {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 48px;
        padding-bottom: 48px;
        border-bottom: 1px solid var(--border);
    }
    .leam-footer-brand .leam-logo { margin-right: 0; margin-bottom: 16px; }
    .leam-footer-brand .leam-logo-img { max-height: 48px; width: auto; display: block; }
    .leam-footer-brand p {
        font-size: 14px;
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 24px;
        max-width: 320px;
        font-weight: 300;
    }
    .leam-footer-contact { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
    .leam-footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: var(--muted);
    }
    .leam-footer-contact-item i {
        color: #00b4ff;
        font-size: 13px;
        margin-top: 3px;
        flex-shrink: 0;
        width: 14px;
    }
    .leam-footer-contact-item a { color: var(--muted); text-decoration: none; transition: color .2s; }
    .leam-footer-contact-item a:hover { color: #fff; }
    .leam-footer-socials { display: flex; gap: 10px; }
    .leam-social-btn {
        width: 36px; height: 36px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        text-decoration: none;
        color: var(--muted);
        transition: all .2s;
    }
    .leam-social-btn:hover {
        border-color: rgba(0,180,255,0.4);
        color: #00b4ff;
        background: rgba(0,180,255,0.06);
        text-decoration: none;
    }

    .leam-footer-col h4 {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255,255,255,0.5);
        margin-bottom: 20px;
    }
    .leam-footer-col ul {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 0;
        margin: 0;
    }
    .leam-footer-col ul li a {
        font-size: 14px;
        color: var(--muted);
        text-decoration: none;
        transition: color .2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .leam-footer-col ul li a::before {
        content: '›';
        color: #00b4ff;
        opacity: 0.6;
        font-size: 14px;
    }
    .leam-footer-col ul li a:hover { color: #fff; text-decoration: none; }

    .leam-newsletter input {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 10px 12px;
        color: #fff;
        font-size: 13px;
        font-family: 'Barlow', sans-serif;
        outline: none;
        width: 100%;
        margin-bottom: 10px;
        transition: border-color .2s;
    }
    .leam-newsletter input:focus { border-color: #00b4ff; background: rgba(0,180,255,0.04); }
    .leam-newsletter input::placeholder { color: var(--muted2); }
    .leam-newsletter button {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        background: var(--rainbow);
        background-size: 200%;
        animation: shift 4s linear infinite;
        border: none;
        color: #000;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Barlow', sans-serif;
        letter-spacing: 0.5px;
        transition: opacity .2s;
    }
    .leam-newsletter button:hover { opacity: 0.9; }

    .leam-footer-bottom {
        max-width: 1280px;
        margin: 0 auto;
        padding: 24px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: rgba(255,255,255,0.3);
        flex-wrap: wrap;
        gap: 12px;
    }
    .leam-footer-bottom a { color: rgba(255,255,255,0.3); text-decoration: none; }
    .leam-footer-bottom a:hover { color: #fff; }
    .leam-footer-bottom-links { display: flex; gap: 24px; flex-wrap: wrap; }

    @media (max-width: 900px) {
        .leam-footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .leam-footer-grid { grid-template-columns: 1fr; gap: 32px; }
        .leam-footer { padding: 48px 20px 0; }
    }
</style>

<footer class="leam-footer">
    <div class="leam-footer-grid">
        <div class="leam-footer-brand">
            @php
                $brandName = $genSetting['site_name'] ?? $genSetting['name'] ?? config('app.name', 'LEAMSOFT');
                $brandInitials = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($brandName, 0, 2));
                $hasLogo = ! empty($genSetting['logo']) && file_exists('storage/' . $genSetting['logo']);
            @endphp
            <a href="{{ url('/') }}" class="leam-logo">
                @if($hasLogo)
                    <img src="{{ url('storage/' . $genSetting['logo']) }}" alt="{{ $brandName }}" class="leam-logo-img">
                @else
                    <div class="leam-logo-box"><span>{{ $brandInitials }}</span></div>
                    <span class="leam-logo-text">{{ $brandName }}</span>
                @endif
            </a>
            <p>{{ $genSetting['description'] ?? 'Leamsoft Pvt Ltd. builds AI-powered software, cloud infrastructure, blockchain systems, and scalable digital platforms for startups and enterprises across Delhi, Noida, and Greater Noida.' }}</p>

            <div class="leam-footer-contact">
                @if(!empty($genSetting['address']))
                <div class="leam-footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $genSetting['address'] }}</span>
                </div>
                @endif
                @if(!empty($genSetting['email']))
                <div class="leam-footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</a>
                </div>
                @endif
                @if(!empty($genSetting['phone']))
                <div class="leam-footer-contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <a href="tel:{{ $genSetting['phone'] }}">{{ $genSetting['phone'] }}</a>
                </div>
                @endif
            </div>

            <div class="leam-footer-socials">
                @if(!empty($genSetting['facebook']))
                    <a href="{{ $genSetting['facebook'] }}" target="_blank" rel="noopener" class="leam-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                @endif
                @if(!empty($genSetting['twitter']))
                    <a href="{{ $genSetting['twitter'] }}" target="_blank" rel="noopener" class="leam-social-btn" title="X"><i class="fa-brands fa-x-twitter"></i></a>
                @endif
                @if(!empty($genSetting['linkedin']))
                    <a href="{{ $genSetting['linkedin'] }}" target="_blank" rel="noopener" class="leam-social-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                @endif
                @if(!empty($genSetting['instagram']))
                    <a href="{{ $genSetting['instagram'] }}" target="_blank" rel="noopener" class="leam-social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                @endif
                @if(!empty($genSetting['youtube']))
                    <a href="{{ $genSetting['youtube'] }}" target="_blank" rel="noopener" class="leam-social-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                @endif
                @if(!empty($genSetting['phone']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $genSetting['phone']) }}" target="_blank" rel="noopener" class="leam-social-btn" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                @endif
            </div>
        </div>

        <div class="leam-footer-col">
            <h4>Services</h4>
            <ul>
                @php
                    $footerCats = \App\Models\Category::where('status', 1)->orderBy('sort_order')->take(6)->get();
                @endphp
                @if($footerCats->count())
                    @foreach($footerCats as $fc)
                        <li><a href="{{ url($fc->slug) }}">{{ $fc->name }}</a></li>
                    @endforeach
                @else
                    <li><a href="{{ url('services') }}">AI-Powered Software</a></li>
                    <li><a href="{{ url('services') }}">Web Development</a></li>
                    <li><a href="{{ url('services') }}">Blockchain Development</a></li>
                    <li><a href="{{ url('services') }}">Cloud &amp; DevOps</a></li>
                    <li><a href="{{ url('services') }}">CRM &amp; ERP Systems</a></li>
                    <li><a href="{{ url('services') }}">SaaS Development</a></li>
                @endif
            </ul>
        </div>

        <div class="leam-footer-col">
            <h4>Company</h4>
            <ul>
                <li><a href="{{ url('about-us') }}">About Us</a></li>
                <li><a href="{{ url('blog') }}">Blog</a></li>
                <li><a href="{{ url('gallery') }}">Projects</a></li>
                <li><a href="{{ url('faq') }}">FAQ</a></li>
                <li><a href="{{ url('help') }}">Help Center</a></li>
                <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
            </ul>
        </div>

        <div class="leam-footer-col">
            <h4>Newsletter</h4>
            <p style="font-size:13px; color:var(--muted); margin-bottom:16px; line-height:1.6; font-weight:300;">Get the latest tech insights and updates straight to your inbox.</p>
            <form class="leam-newsletter" onsubmit="event.preventDefault(); this.querySelector('button').innerText='Subscribed ✓';">
                <input type="email" placeholder="your@email.com" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>

    <div class="leam-footer-bottom">
        <div>© {{ date('Y') }} LEAMSOFT. All rights reserved.</div>
        <div class="leam-footer-bottom-links">
            <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
            <a href="{{ url('terms-condition') }}">Terms & Conditions</a>
            <a href="{{ url('faq') }}">FAQ</a>
        </div>
    </div>
</footer>
