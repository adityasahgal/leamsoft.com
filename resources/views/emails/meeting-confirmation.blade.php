@php
    $m = $meeting;
    $start = $m->startsAt();
    $end = $m->endsAt();
    $first = \Illuminate\Support\Str::of($m->name)->explode(' ')->first();
    $setting = \App\Models\Setting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your meeting with Leamsoft</title>
</head>
<body style="margin:0;padding:0;background:#f6f8fb;font-family:Arial,Helvetica,sans-serif;color:#3c4257;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f8fb;padding:32px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#ffffff;border:1px solid #e6e8ee;border-radius:14px;">
                <tr>
                    <td style="padding:28px 32px 8px;">
                        <div style="font-size:20px;font-weight:bold;color:#0a0d14;">Leamsoft</div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 32px 0;">
                        <h1 style="margin:0;font-size:24px;line-height:1.25;color:#0a0d14;">
                            @if($updated)
                                Your meeting details were updated, {{ $first }}.
                            @else
                                You’re booked in, {{ $first }}.
                            @endif
                        </h1>
                        <p style="margin:12px 0 0;font-size:15px;line-height:1.6;color:#6b7385;">
                            Thanks for scheduling a call with Leamsoft. Here are the details — the calendar invite is attached.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 32px 0;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef1fe;border-radius:12px;">
                            <tr>
                                <td style="padding:20px 22px;">
                                    <div style="font-size:12px;letter-spacing:.06em;text-transform:uppercase;color:#2447f5;font-weight:bold;">Date &amp; time</div>
                                    <div style="font-size:20px;font-weight:bold;color:#0a0d14;margin-top:6px;">{{ $start->format('l, j F Y') }}</div>
                                    <div style="font-size:16px;color:#0a0d14;margin-top:2px;">{{ $start->format('g:i A') }} – {{ $end->format('g:i A') }} IST</div>
                                    <div style="font-size:14px;color:#6b7385;margin-top:10px;">{{ $m->mode_label }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 32px 0;">
                        @if($m->mode === 'video' && $m->meeting_link)
                            <a href="{{ $m->meeting_link }}" style="display:inline-block;background:#0a0d14;color:#ffffff;text-decoration:none;font-weight:bold;font-size:15px;padding:13px 22px;border-radius:10px;">Join the meeting</a>
                            <p style="margin:12px 0 0;font-size:13px;color:#6b7385;line-height:1.6;">
                                Or open this link in your browser at the meeting time:<br>
                                <a href="{{ $m->meeting_link }}" style="color:#2447f5;word-break:break-all;">{{ $m->meeting_link }}</a>
                            </p>
                        @elseif($m->mode === 'phone')
                            <p style="margin:0;font-size:15px;line-height:1.6;">We’ll call you on <strong style="color:#0a0d14;">{{ $m->phone }}</strong> at the time above.</p>
                        @elseif($m->mode === 'in_person')
                            <p style="margin:0;font-size:15px;line-height:1.6;">We’ll meet at:<br><strong style="color:#0a0d14;">{{ $m->locationText() }}</strong></p>
                        @endif
                        <p style="margin:18px 0 0;">
                            <a href="{{ $m->googleCalendarUrl() }}" style="color:#2447f5;font-weight:bold;font-size:14px;text-decoration:none;">+ Add to Google Calendar</a>
                        </p>
                    </td>
                </tr>

                @if($m->topic || $m->notes)
                <tr>
                    <td style="padding:20px 32px 0;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #e6e8ee;">
                            @if($m->topic)
                            <tr>
                                <td style="padding:12px 0 0;font-size:13px;color:#6b7385;width:90px;" valign="top">Topic</td>
                                <td style="padding:12px 0 0;font-size:14px;color:#0a0d14;">{{ $m->topic }}</td>
                            </tr>
                            @endif
                            @if($m->notes)
                            <tr>
                                <td style="padding:12px 0 0;font-size:13px;color:#6b7385;" valign="top">Your notes</td>
                                <td style="padding:12px 0 0;font-size:14px;color:#0a0d14;">{!! nl2br(e($m->notes)) !!}</td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                @endif

                <tr>
                    <td style="padding:24px 32px 28px;">
                        <p style="margin:0;font-size:14px;line-height:1.6;color:#6b7385;">
                            Need to reschedule? Just reply to this email
                            @if(!empty($setting->phone)) or call/WhatsApp us on <strong style="color:#0a0d14;">{{ $setting->phone }}</strong>@endif.
                        </p>
                        <p style="margin:16px 0 0;font-size:14px;color:#3c4257;">— Team Leamsoft</p>
                    </td>
                </tr>
            </table>
            <p style="font-size:12px;color:#9aa1b1;margin:16px 0 0;">Leamsoft Pvt Ltd. · {{ url('/') }}</p>
        </td>
    </tr>
</table>
</body>
</html>
