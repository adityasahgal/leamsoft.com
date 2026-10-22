<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Meeting Request</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color: #333;">
    <h2 style="margin-bottom: 4px;">New Meeting Scheduled</h2>
    <p style="color: #777; margin-top: 0;">Booked {{ $meeting->created_at->format('j F, Y g:i A') }}</p>

    <p style="font-size: 18px; margin: 16px 0;">
        <strong>{{ $meeting->startsAt()->format('l, j F Y') }}</strong><br>
        {{ $meeting->startsAt()->format('g:i A') }} – {{ $meeting->endsAt()->format('g:i A') }} IST · {{ $meeting->mode_label }}
    </p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 640px;">
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee; width: 140px;">Name</th>
            <td style="border-bottom: 1px solid #eee;">{{ $meeting->name }}</td>
        </tr>
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Email</th>
            <td style="border-bottom: 1px solid #eee;">{{ $meeting->email }}</td>
        </tr>
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Phone</th>
            <td style="border-bottom: 1px solid #eee;">{{ $meeting->phone }}</td>
        </tr>
        @if($meeting->company)
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Company</th>
            <td style="border-bottom: 1px solid #eee;">{{ $meeting->company }}</td>
        </tr>
        @endif
        @if($meeting->topic)
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Topic</th>
            <td style="border-bottom: 1px solid #eee;">{{ $meeting->topic }}</td>
        </tr>
        @endif
        @if($meeting->notes)
        <tr>
            <th align="left" valign="top" style="border-bottom: 1px solid #eee;">Notes</th>
            <td style="border-bottom: 1px solid #eee;">{!! nl2br(e($meeting->notes)) !!}</td>
        </tr>
        @endif
    </table>

    <p style="margin-top: 20px;">The calendar invite is attached. Manage it in the admin panel under <strong>Meetings</strong>.</p>
    <p style="color: #777; font-size: 12px;">Sent from {{ config('app.name') }}.</p>
</body>

</html>
