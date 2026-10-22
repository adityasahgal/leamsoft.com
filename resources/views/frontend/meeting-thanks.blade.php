@extends('layouts.master')

@section('content')
@php
    $start = $meeting->startsAt();
    $end   = $meeting->endsAt();
    // One-click "add to Google Calendar" for the visitor
    $gcal = 'https://calendar.google.com/calendar/render?' . http_build_query([
        'action'  => 'TEMPLATE',
        'text'    => 'Call with Leamsoft',
        'dates'   => $start->copy()->utc()->format('Ymd\THis\Z') . '/' . $end->copy()->utc()->format('Ymd\THis\Z'),
        'details' => 'Discovery call with the Leamsoft team (' . $meeting->mode_label . '). We will confirm the details by email or phone.',
    ]);
@endphp

<section class="section--tight" style="padding-top:64px">
    <div class="container">
        <div class="confirm">
            <div class="confirm__head">
                <span class="ok"><svg class="icon"><use href="#i-check"/></svg></span>
                <h1>You’re booked in, {{ \Illuminate\Support\Str::of($meeting->name)->explode(' ')->first() }}.</h1>
                <p>We’ve received your request and will confirm by email or phone shortly.</p>
            </div>
            <dl>
                <dt>When</dt>
                <dd>{{ $start->format('l, j F Y') }}<br>{{ $start->format('g:i A') }} – {{ $end->format('g:i A') }} IST</dd>
                <dt>How</dt>
                <dd>{{ $meeting->mode_label }}</dd>
                @if($meeting->topic)
                    <dt>Topic</dt>
                    <dd>{{ $meeting->topic }}</dd>
                @endif
                <dt>Contact</dt>
                <dd>{{ $meeting->email }}<br>{{ $meeting->phone }}</dd>
            </dl>
            <div class="confirm__foot">
                <a href="{{ $gcal }}" target="_blank" rel="noopener" class="btn btn--primary"><svg class="icon"><use href="#i-cal"/></svg>Add to Google Calendar</a>
                <a href="{{ url('/') }}" class="btn btn--ghost">Back to home</a>
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
