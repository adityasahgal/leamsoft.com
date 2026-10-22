@extends('layouts.master')

@section('content')
@php
    $Meeting     = \App\Models\Meeting::class;
    $recaptchaOn = config('recaptcha.enabled') && config('recaptcha.site_key');
    $oldSlot     = old('slot');
    $oldDate     = $oldSlot ? substr($oldSlot, 0, 10) : null;
    $activeDate  = collect($days)->pluck('date')->contains($oldDate) ? $oldDate : ($days[0]['date'] ?? null);
    $topics      = $navCategories->count() ? $navCategories->pluck('name')->all() : ['Software', 'AI / ML', 'Cloud', 'Security', 'Marketing'];
    $topics[]    = 'Something else';
    $mins        = config('meetings.slot_minutes');
@endphp

<section class="phero">
    <div class="hero__guides" aria-hidden="true"><div></div></div>
    <div class="container">
        @include('frontend.partials.crumbs', ['trail' => ['Home' => url('/'), 'Schedule a meeting' => null]])
        <h1>Schedule a meeting. <span class="dim">Free, {{ $mins }} minutes.</span></h1>
        <p class="lead">Pick a time that suits you and talk to a senior engineer about your project — no sales pitch, just a useful conversation.</p>
        <div class="hero__meta">
            <div><strong>{{ $mins }} min</strong>Discovery call</div>
            <div><strong>Free</strong>No obligation</div>
            <div><strong>Meet / Phone</strong>Or in person in NCR</div>
            <div><strong>Mon–Sat</strong>{{ $Meeting::timeLabel(config('meetings.day_start')) }} – {{ $Meeting::timeLabel(config('meetings.day_end')) }} IST</div>
        </div>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        @if(count($days))
            <form class="booking" method="POST" action="{{ route('meeting.store') }}" data-loading-form novalidate
                  id="booking" @if($errors->any()) data-scroll-here @endif style="scroll-margin-top:88px">
                @csrf

                {{-- Step 1: when --}}
                <div class="booking__pick">
                    <h2><span class="n">1</span>Pick a day</h2>
                    <p class="hint">Showing the next {{ config('meetings.days_ahead') }} days. All times are India Standard Time (IST).</p>

                    <div class="days" role="tablist" aria-label="Available days">
                        @foreach($days as $d)
                            <button type="button" class="day {{ $d['date'] === $activeDate ? 'on' : '' }}" role="tab"
                                    aria-selected="{{ $d['date'] === $activeDate ? 'true' : 'false' }}"
                                    aria-controls="slots-{{ $d['date'] }}" data-day="{{ $d['date'] }}" data-long="{{ $d['long'] }}">
                                <small>{{ $d['weekday'] }}</small>
                                <strong>{{ $d['day'] }}</strong>
                                <span>{{ $d['month'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="slots-wrap">
                        <div class="flabel">Pick a time <span>{{ $mins }}-min slots · IST</span></div>
                        @foreach($days as $d)
                            <fieldset class="slotg" id="slots-{{ $d['date'] }}" role="tabpanel" data-slots="{{ $d['date'] }}"
                                      @if($d['date'] !== $activeDate) hidden @endif style="border:0;padding:0;margin:0;min-width:0">
                                <legend class="sr-only">Times on {{ $d['long'] }}</legend>
                                <h3>{{ $d['long'] }}</h3>
                                <div class="slots">
                                    @foreach($d['slots'] as $t)
                                        @php $val = $d['date'] . ' ' . $t; $id = 'slot-' . str_replace([' ', ':'], '-', $val); @endphp
                                        <input type="radio" name="slot" id="{{ $id }}" value="{{ $val }}" data-label="{{ $d['long'] }} · {{ $Meeting::timeLabel($t) }} IST" @checked($oldSlot === $val) required>
                                        <label for="{{ $id }}">{{ $Meeting::timeLabel($t) }}</label>
                                    @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                        @error('slot') <div class="ferr" style="margin-top:12px">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Step 2: who --}}
                <div class="booking__form">
                    <h2><span class="n">2</span>Your details</h2>

                    <div class="summary {{ $oldSlot ? '' : 'empty' }}" id="slot-summary" aria-live="polite">
                        <span class="ci"><svg class="icon"><use href="#i-cal"/></svg></span>
                        <span><small>Selected time</small><strong>{{ $oldSlot ? \Illuminate\Support\Carbon::parse($oldSlot)->format('l, j F · g:i A') . ' IST' : 'No time picked yet' }}</strong></span>
                    </div>

                    <fieldset class="field" style="border:0;padding:0;margin:0;min-width:0">
                        <legend class="flabel">How should we meet?</legend>
                        <div class="chips">
                            @foreach(config('meetings.modes') as $value => $label)
                                <input type="radio" id="mode-{{ $value }}" name="mode" value="{{ $value }}" @checked(old('mode', 'video') === $value)>
                                <label for="mode-{{ $value }}">{{ $label }}</label>
                            @endforeach
                        </div>
                        @error('mode') <div class="ferr">{{ $message }}</div> @enderror
                    </fieldset>

                    <div class="grid2">
                        <div class="field @error('name') bad @enderror">
                            <label for="m-name">Full name</label>
                            <input id="m-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
                            @error('name') <div class="ferr">{{ $message }}</div> @enderror
                        </div>
                        <div class="field @error('email') bad @enderror">
                            <label for="m-email">Work email</label>
                            <input id="m-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                            @error('email') <div class="ferr">{{ $message }}</div> @enderror
                        </div>
                        <div class="field @error('phone') bad @enderror">
                            <label for="m-phone">Phone / WhatsApp</label>
                            <input id="m-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="numeric" required>
                            @error('phone') <div class="ferr">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label for="m-company">Company <span class="opt">(optional)</span></label>
                            <input id="m-company" type="text" name="company" value="{{ old('company') }}" autocomplete="organization">
                        </div>
                    </div>

                    <fieldset class="field" style="border:0;padding:0;margin:0;min-width:0">
                        <legend class="flabel">What would you like to discuss?</legend>
                        <div class="chips">
                            @foreach($topics as $i => $topic)
                                <input type="radio" id="m-topic-{{ $i }}" name="topic" value="{{ $topic }}" @checked(old('topic') === $topic)>
                                <label for="m-topic-{{ $i }}">{{ $topic }}</label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="field">
                        <label for="m-notes">Anything we should know? <span class="opt">(optional)</span></label>
                        <textarea id="m-notes" name="notes" placeholder="A line or two about your project, goals or timeline.">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Honeypot: bots fill every field --}}
                    <div class="hp" aria-hidden="true">
                        <label for="m-website">Website</label>
                        <input id="m-website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    @if($recaptchaOn)
                        <div>
                            <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
                            @error('g-recaptcha-response') <div class="ferr">{{ $message }}</div> @enderror
                            @error('captcha') <div class="ferr">{{ $message }}</div> @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn btn--primary">Schedule meeting <svg class="icon arr"><use href="#i-arrow"/></svg></button>
                    <p class="form__note"><svg class="icon"><use href="#i-lock"/></svg>We’ll confirm by email or phone. Your details stay private.</p>
                </div>
            </form>
        @else
            <div class="empty">
                <h2>All slots are booked right now</h2>
                <p>Our calendar is full for the next {{ config('meetings.days_ahead') }} days. Send us a message and we’ll find a time that works.</p>
                <a href="{{ url('contact-us') }}" class="btn btn--primary">Contact us <svg class="icon arr"><use href="#i-arrow"/></svg></a>
            </div>
        @endif
    </div>
</section>

<section class="section section--soft" style="padding-top:88px">
    <div class="container">
        <div class="sec-head rv">
            <div>
                <span class="label">What to expect</span>
                <h2 class="h2">A useful {{ $mins }} minutes. <span class="dim">Not a sales call.</span></h2>
            </div>
        </div>
        <div class="steps rv">
            <div class="step"><span class="n">01</span><h3>We confirm</h3><p>You’ll hear from us by email or phone to confirm the slot and share the meeting link.</p></div>
            <div class="step"><span class="n">02</span><h3>We listen</h3><p>Tell us about your goals, users and constraints. We’ll ask a lot of questions.</p></div>
            <div class="step"><span class="n">03</span><h3>We advise</h3><p>Honest thoughts on approach, stack and rough effort — even if we’re not the right fit.</p></div>
            <div class="step"><span class="n">04</span><h3>Next steps</h3><p>If it makes sense, a written scope and estimate follows within a few days.</p></div>
        </div>
    </div>
</section>

@push('scripts')
    @if($recaptchaOn && count($days))
        <script nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}" src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script nonce="{{ \Illuminate\Support\Facades\Vite::cspNonce() }}">
        (function () {
            var days = document.querySelectorAll('.day[data-day]');
            var groups = document.querySelectorAll('[data-slots]');
            var summary = document.getElementById('slot-summary');
            if (!days.length || !summary) return;
            var text = summary.querySelector('strong');

            days.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var day = btn.getAttribute('data-day');
                    days.forEach(function (b) {
                        var on = b === btn;
                        b.classList.toggle('on', on);
                        b.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    groups.forEach(function (g) { g.hidden = g.getAttribute('data-slots') !== day; });
                });
            });

            document.querySelectorAll('input[name="slot"]').forEach(function (r) {
                r.addEventListener('change', function () {
                    text.textContent = r.getAttribute('data-label');
                    summary.classList.remove('empty');
                });
            });
        })();
    </script>
@endpush
@endsection
