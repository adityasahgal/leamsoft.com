<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Enquiry</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color: #333;">
    <h2 style="margin-bottom: 4px;">New Enquiry Received</h2>
    <p style="color: #777; margin-top: 0;">{{ $enquiry->created_at->format('j F, Y g:i A') }}</p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 640px;">
        @if(!empty($enquiry->pname))
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee; width: 140px;">Product / Service</th>
            <td style="border-bottom: 1px solid #eee;">{{ $enquiry->pname }}</td>
        </tr>
        @endif
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee; width: 140px;">Name</th>
            <td style="border-bottom: 1px solid #eee;">{{ $enquiry->name }}</td>
        </tr>
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Email</th>
            <td style="border-bottom: 1px solid #eee;">{{ $enquiry->email }}</td>
        </tr>
        <tr>
            <th align="left" style="border-bottom: 1px solid #eee;">Phone</th>
            <td style="border-bottom: 1px solid #eee;">{{ $enquiry->phone }}</td>
        </tr>
        <tr>
            <th align="left" valign="top" style="border-bottom: 1px solid #eee;">Message</th>
            <td style="border-bottom: 1px solid #eee;">{!! nl2br(e($enquiry->message)) !!}</td>
        </tr>
    </table>

    <p style="color: #777; font-size: 12px;">Sent from {{ config('app.name') }}.</p>
</body>

</html>
