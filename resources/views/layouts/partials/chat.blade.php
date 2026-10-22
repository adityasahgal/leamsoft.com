{{-- Website chat widget (assets/js/chat.js) --}}
@php
    $chatName = config('chatbot.assistant_name', 'Leamsoft Assistant');
    $waDigits = preg_replace('/[^0-9]/', '', $genSetting['phone'] ?? '');
@endphp
<div class="chat" id="chat"
     data-endpoint="{{ route('chat.message') }}"
     data-reset="{{ route('chat.reset') }}"
     data-lead="{{ route('chat.lead') }}"
     data-meeting="{{ route('meeting.create') }}">

    <button type="button" class="chat__launch" id="chat-launch" aria-expanded="false" aria-controls="chat-panel">
        <span class="chat__launch-ico"><svg class="icon" aria-hidden="true"><use href="#i-chat"/></svg></span>
        <span class="chat__launch-txt">Ask us anything</span>
    </button>

    <section class="chat__panel" id="chat-panel" role="dialog" aria-modal="false" aria-labelledby="chat-title" hidden>
        <header class="chat__head">
            <span class="chat__avatar" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16h11"/></svg></span>
            <div>
                <h2 id="chat-title">{{ $chatName }}</h2>
                <p><i class="chat__dot"></i>Online · replies in seconds</p>
            </div>
            <div class="chat__head-btns">
                <button type="button" class="chat__icon-btn" id="chat-new" title="New conversation" aria-label="Start a new conversation"><svg class="icon"><use href="#i-plus"/></svg></button>
                <button type="button" class="chat__icon-btn" id="chat-close" title="Close" aria-label="Close chat"><svg class="icon"><use href="#i-x"/></svg></button>
            </div>
        </header>

        <div class="chat__log" id="chat-log" aria-live="polite" aria-relevant="additions"></div>

        <div class="chat__chips" id="chat-chips">
            <button type="button" data-ask="What services do you offer?">Services</button>
            <button type="button" data-ask="How much does a project cost?">Pricing</button>
            <button type="button" data-ask="How fast can you start?">Timeline</button>
            <a href="{{ route('meeting.create') }}">Book a call</a>
            <button type="button" data-open-lead>Call me back</button>
        </div>

        {{-- Callback form --}}
        <form class="chat__lead" id="chat-lead" hidden novalidate>
            <p class="chat__lead-title">Leave your details — we’ll call you back.</p>
            <label class="sr-only" for="chat-lead-name">Name</label>
            <input id="chat-lead-name" name="name" type="text" placeholder="Your name" autocomplete="name" required>
            <label class="sr-only" for="chat-lead-phone">Phone</label>
            <input id="chat-lead-phone" name="phone" type="tel" placeholder="Phone / WhatsApp" autocomplete="tel" inputmode="numeric" required>
            <label class="sr-only" for="chat-lead-email">Email (optional)</label>
            <input id="chat-lead-email" name="email" type="email" placeholder="Email (optional)" autocomplete="email">
            <div class="hp" aria-hidden="true"><label for="chat-lead-web">Website</label><input id="chat-lead-web" name="website" type="text" tabindex="-1" autocomplete="off"></div>
            <p class="chat__err" id="chat-lead-err" role="alert"></p>
            <div class="chat__lead-btns">
                <button type="button" class="btn btn--ghost btn--sm" data-close-lead>Cancel</button>
                <button type="submit" class="btn btn--primary btn--sm">Request callback</button>
            </div>
        </form>

        <form class="chat__form" id="chat-form">
            <label class="sr-only" for="chat-input">Type your message</label>
            <textarea id="chat-input" rows="1" maxlength="{{ (int) config('chatbot.max_message_chars', 1000) }}" placeholder="Type your question…" autocomplete="off"></textarea>
            <button type="submit" class="chat__send" aria-label="Send message"><svg class="icon"><use href="#i-arrow"/></svg></button>
        </form>
        <p class="chat__foot">
            {{ \App\Support\Chatbot\ClaudeAssistant::available() ? 'AI assistant — answers may be imperfect.' : 'Automated assistant.' }}
            @if($waDigits)
                Prefer a human? <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener">WhatsApp us</a>
            @endif
        </p>
    </section>
</div>
