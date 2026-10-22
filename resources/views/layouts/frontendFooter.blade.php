@php
    $brandName = $genSetting['site_name'] ?? $genSetting['name'] ?? 'Leamsoft';
    $logoUrl   = \App\Support\Ui::logoUrl($genSetting);
    $socials   = [
        'linkedin'  => ['i-in', 'LinkedIn'],
        'twitter'   => ['i-xs', 'X'],
        'instagram' => ['i-ig', 'Instagram'],
        'facebook'  => ['i-fb', 'Facebook'],
        'youtube'   => ['i-yt', 'YouTube'],
    ];
@endphp
<footer class="footer">
    <div class="container">
        <div class="fgrid">
            <div>
                <a href="{{ url('/') }}" class="logo" aria-label="{{ $brandName }} home">
                    @if($logoUrl)
                        <img class="logo__img" src="{{ $logoUrl }}" alt="{{ $brandName }}" height="36">
                    @else
                        <span class="logo__mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16h11"/></svg></span>Leamsoft
                    @endif
                </a>
                <p class="desc">{{ \App\Support\Ui::siteDescription($genSetting) }}</p>

                <div class="social">
                    @foreach($socials as $key => [$icon, $label])
                        @if(!empty($genSetting[$key]))
                            <a href="{{ $genSetting[$key] }}" target="_blank" rel="noopener" aria-label="{{ $label }}"><svg class="icon"><use href="#{{ $icon }}"/></svg></a>
                        @endif
                    @endforeach
                    @if(!empty($genSetting['email']))
                        <a href="mailto:{{ $genSetting['email'] }}" aria-label="Email"><svg class="icon"><use href="#i-mail"/></svg></a>
                    @endif
                </div>

                @if(!empty($genSetting['address']))
                    <address class="addr" style="font-style:normal;margin-top:22px;padding:0;max-width:300px">
                        <svg class="icon" aria-hidden="true"><use href="#i-pin"/></svg><span>{{ $genSetting['address'] }}</span>
                    </address>
                @endif
            </div>

            <div>
                <h2>Services</h2>
                <ul>
                    @forelse($navCategories as $fc)
                        <li><a href="{{ url($fc->slug) }}">{{ $fc->name }}</a></li>
                    @empty
                        <li><a href="{{ url('services') }}">Software Development</a></li>
                        <li><a href="{{ url('services') }}">AI &amp; Machine Learning</a></li>
                        <li><a href="{{ url('services') }}">Cloud Solutions</a></li>
                    @endforelse
                    <li><a href="{{ url('services') }}">All services</a></li>
                </ul>
            </div>

            <div>
                <h2>Company</h2>
                <ul>
                    <li><a href="{{ url('about-us') }}">About us</a></li>
                    <li><a href="{{ url('gallery') }}">Our work</a></li>
                    <li><a href="{{ url('blog') }}">Blog</a></li>
                    <li><a href="{{ url('near_by') }}">Areas we serve</a></li>
                    <li><a href="{{ url('contact-us') }}">Contact</a></li>
                </ul>
            </div>

            <div>
                <h2>Support</h2>
                <ul>
                    <li><a href="{{ url('help') }}">Help center</a></li>
                    <li><a href="{{ url('faq') }}">FAQ</a></li>
                    <li><a href="{{ url('admin/login') }}">Client login</a></li>
                    @if(!empty($genSetting['phone']))
                        <li><a href="tel:{{ $genSetting['phone'] }}">{{ $genSetting['phone'] }}</a></li>
                    @endif
                    @if(!empty($genSetting['email']))
                        <li><a href="mailto:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="fbottom">
            <span>© {{ date('Y') }} Leamsoft Pvt Ltd. All rights reserved.</span>
            <nav aria-label="Legal">
                <a href="{{ url('privacy-policy') }}">Privacy</a>
                <a href="{{ url('terms-condition') }}">Terms</a>
                <a href="{{ url('sitemap.xml') }}">Sitemap</a>
            </nav>
        </div>
    </div>
</footer>
