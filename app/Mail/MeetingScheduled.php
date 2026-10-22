<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Tells the team a visitor booked a call. Carries an .ics invite so the
 * slot can be added to a calendar in one click.
 */
class MeetingScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    public function build()
    {
        $m = $this->meeting;

        return $this->subject('Meeting request: ' . $m->name . ' — ' . $m->startsAt()->format('D j M, g:i A') . ' IST')
            ->replyTo($m->email, $m->name)
            ->view('emails.meeting')
            ->attachData($this->ics(), 'meeting.ics', ['mime' => 'text/calendar; charset=UTF-8; method=PUBLISH']);
    }

    private function ics(): string
    {
        $m = $this->meeting;
        $fmt = fn ($c) => $c->copy()->utc()->format('Ymd\THis\Z');
        $esc = fn ($s) => str_replace(["\\", ';', ',', "\r\n", "\n"], ["\\\\", '\;', '\,', '\n', '\n'], (string) $s);

        $desc = implode("\n", array_filter([
            'Name: ' . $m->name,
            'Email: ' . $m->email,
            'Phone: ' . $m->phone,
            $m->company ? 'Company: ' . $m->company : null,
            $m->topic ? 'Topic: ' . $m->topic : null,
            'Mode: ' . $m->mode_label,
            $m->notes ? 'Notes: ' . $m->notes : null,
        ]));

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Leamsoft//Meetings//EN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:meeting-' . $m->id . '@' . parse_url(config('app.url'), PHP_URL_HOST),
            'DTSTAMP:' . $fmt(now()),
            'DTSTART:' . $fmt($m->startsAt()),
            'DTEND:' . $fmt($m->endsAt()),
            'SUMMARY:' . $esc('Leamsoft call with ' . $m->name . ($m->company ? ' (' . $m->company . ')' : '')),
            'DESCRIPTION:' . $esc($desc),
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return implode("\r\n", $lines) . "\r\n";
    }
}
