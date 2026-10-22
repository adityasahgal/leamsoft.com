{{--
    Contact block: details on the left, enquiry form on the right.
    Posts to /enquiry (MainController@enquiry). Optional:
      $contactTitle, $contactLead
--}}
@php
    $recaptchaOn = config('recaptcha.enabled') && config('recaptcha.site_key');
    $interests   = $navCategories->count()
        ? $navCategories->pluck('name')->all()
        : ['Software', 'AI / ML', 'Cloud', 'Security', 'Marketing'];
    $interests[] = 'Something else';
    $picked      = (array) old('interest', []);
    $returned    = session('status') || $errors->any();
    $phoneDigits = preg_replace('/[^0-9]/', '', $genSetting['phone'] ?? '');
@endphp
<div class="contact rv" id="contact" @if($returned) data-scroll-here @endif style="scroll-margin-top:88px">
    <div class="contact__l">
        <span class="label">Contact</span>
        <h2 style="margin-top:14px">{!! $contactTitle ?? 'Tell us what you’re <span style="color:var(--faint)">building.</span>' !!}</h2>
        <p class="lead">{{ $contactLead ?? 'Share a few details and a senior engineer will get back to you within one business day — usually with questions, sometimes with a rough plan.' }}</p>

        <div class="clist">
            @if(!empty($genSetting['email']))
                <a href="mailto:{{ $genSetting['email'] }}">
                    <span class="ci"><svg class="icon"><use href="#i-mail"/></svg></span>
                    <span><small>Email</small><strong>{{ $genSetting['email'] }}</strong></span>
                    <svg class="arr"><use href="#i-arrow"/></svg>
                </a>
            @endif
            @if(!empty($genSetting['phone']))
                <a href="tel:{{ $genSetting['phone'] }}">
                    <span class="ci"><svg class="icon"><use href="#i-phone"/></svg></span>
                    <span><small>Phone</small><strong>{{ $genSetting['phone'] }}</strong></span>
                    <svg class="arr"><use href="#i-arrow"/></svg>
                </a>
                <a href="https://wa.me/{{ $phoneDigits }}" target="_blank" rel="noopener">
                    <span class="ci"><svg class="icon"><use href="#i-chat"/></svg></span>
                    <span><small>WhatsApp</small><strong>Chat with the team</strong></span>
                    <svg class="arr"><use href="#i-arrow"/></svg>
                </a>
            @endif
            <a href="{{ url('contact-us') }}">
                <span class="ci"><svg class="icon"><use href="#i-cal"/></svg></span>
                <span><small>Discovery call</small><strong>Free 30-minute consultation</strong></span>
                <svg class="arr"><use href="#i-arrow"/></svg>
            </a>
        </div>

        @if(!empty($genSetting['address']))
            <p class="addr"><svg class="icon"><use href="#i-pin"/></svg><span>{{ $genSetting['address'] }}</span></p>
        @endif
    </div>

    <form class="form" action="{{ url('/enquiry') }}" method="post" novalidate>
        @csrf
        <h3>Start a project</h3>
        <p class="sub">No sales scripts. Just a conversation about your problem.</p>

        @if(session('status'))
            <div class="full notice {{ session('status') == 'success' ? 'notice--ok' : 'notice--err' }}" role="status">
                <svg class="icon"><use href="#{{ session('status') == 'success' ? 'i-check' : 'i-alert' }}"/></svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="field @error('name') bad @enderror">
            <label for="c-name">Full name</label>
            <input id="c-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
            @error('name') <div class="ferr">{{ $message }}</div> @enderror
        </div>
        <div class="field @error('email') bad @enderror">
            <label for="c-email">Work email</label>
            <input id="c-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email') <div class="ferr">{{ $message }}</div> @enderror
        </div>
        <div class="field @error('phone') bad @enderror">
            <label for="c-phone">Phone</label>
            <input id="c-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="numeric" required>
            @error('phone') <div class="ferr">{{ $message }}</div> @enderror
        </div>
        <div class="field">
            <label for="c-company">Company <span class="opt">(optional)</span></label>
            <input id="c-company" type="text" name="company" value="{{ old('company') }}" autocomplete="organization">
        </div>

        <fieldset class="field full" style="border:0;padding:0;margin:0;min-width:0">
            <legend class="flabel">What can we help with?</legend>
            <div class="chips">
                @foreach($interests as $i => $interest)
                    <input type="checkbox" id="c-int-{{ $i }}" name="interest[]" value="{{ $interest }}" @checked(in_array($interest, $picked))>
                    <label for="c-int-{{ $i }}">{{ $interest }}</label>
                @endforeach
            </div>
        </fieldset>

        <div class="field full @error('message') bad @enderror">
            <label for="c-msg">Project details</label>
            <textarea id="c-msg" name="message" placeholder="Goals, timeline, budget range — whatever you have." required>{{ old('message') }}</textarea>
            @error('message') <div class="ferr">{{ $message }}</div> @enderror
        </div>

        @if($recaptchaOn)
            <div class="full">
                <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
                @error('g-recaptcha-response') <div class="ferr">{{ $message }}</div> @enderror
                @error('captcha') <div class="ferr">{{ $message }}</div> @enderror
            </div>
            @once
                @push('scripts')
                    <script nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}" src="https://www.google.com/recaptcha/api.js" async defer></script>
                @endpush
            @endonce
        @endif

        <button type="submit" class="btn btn--primary full">Send message <svg class="icon arr"><use href="#i-arrow"/></svg></button>
        <p class="form__note"><svg class="icon"><use href="#i-lock"/></svg>Your details stay private. NDA available on request.</p>
    </form>
</div>
