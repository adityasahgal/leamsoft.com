@extends('layouts.master')

@section('content')
@php
    $start = $meeting->startsAt();
    $end   = $meeting->endsAt();
    $gcal  = $meeting->googleCalendarUrl();
@endphp

<section class="section--tight" style="padding-top:64px">
    <div class="container">
        <div class="confirm">
            <div class="confirm__head">
                <span class="ok"><svg class="icon"><use href="#i-check"/></svg></span>
                <h1>You’re booked in, {{ \Illuminate\Support\Str::of($meeting->name)->explode(' ')->first() }}.</h1>
                <p>
                    @if($meeting->client_notified_at)
                        We’ve emailed the details{{ $meeting->meeting_link ? ' and your meeting link' : '' }} to {{ $meeting->email }}.
                    @else
                        We’ve received your request and will confirm by email or phone shortly.
                    @endif
                </p>
            </div>
            <dl>
                <dt>When</dt>
                <dd>{{ $start->format('l, j F Y') }}<br>{{ $start->format('g:i A') }} – {{ $end->format('g:i A') }} IST</dd>
                <dt>How</dt>
                <dd>
                    {{ $meeting->mode_label }}
                    @if($meeting->mode === 'video' && $meeting->meeting_link)
                        <br><a href="{{ $meeting->meeting_link }}" target="_blank" rel="noopener" style="color:var(--brand);word-break:break-all">{{ $meeting->meeting_link }}</a>
                    @elseif($meeting->mode === 'in_person')
                        <br><span style="color:var(--muted);font-weight:400">{{ $meeting->locationText() }}</span>
                    @endif
                </dd>
                @if($meeting->topic)
                    <dt>Topic</dt>
                    <dd>{{ $meeting->topic }}</dd>
                @endif
                <dt>Contact</dt>
                <dd>{{ $meeting->email }}<br>{{ $meeting->phone }}</dd>
            </dl>
            <div class="confirm__foot">
                @if($meeting->mode === 'video' && $meeting->meeting_link)
                    <a href="{{ $meeting->meeting_link }}" target="_blank" rel="noopener" class="btn btn--primary"><svg class="icon"><use href="#i-monitor"/></svg>Open meeting link</a>
                    <a href="{{ $gcal }}" target="_blank" rel="noopener" class="btn btn--ghost"><svg class="icon"><use href="#i-cal"/></svg>Add to Google Calendar</a>
                @else
                    <a href="{{ $gcal }}" target="_blank" rel="noopener" class="btn btn--primary"><svg class="icon"><use href="#i-cal"/></svg>Add to Google Calendar</a>
                    <a href="{{ url('/') }}" class="btn btn--ghost">Back to home</a>
                @endif
            </div>
        </div>
        <p style="text-align:center;color:var(--muted);font-size:14px;margin-top:24px">
            Need to change the time? Reply to our confirmation or
            @if(!empty($genSetting['phone']))
                call <a href="tel:{{ $genSetting['phone'] }}" style="color:var(--ink);font-weight:550">{{ $genSetting['phone'] }}</a>.
            @else
                <a href="{{ url('contact-us') }}" style="color:var(--ink);font-weight:550">contact us</a>.
            @endif
        </p>
    </div>
</section>
@endsection
