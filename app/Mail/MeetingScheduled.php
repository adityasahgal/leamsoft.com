<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Tells the team a visitor booked a call: date, time, join link and an
 * .ics invite so the slot can be added to a calendar in one click.
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
        $summary = 'Leamsoft call with ' . $m->name . ($m->company ? ' (' . $m->company . ')' : '');

        return $this->subject('Meeting booked: ' . $m->name . ' — ' . $m->startsAt()->format('D j M, g:i A') . ' IST')
            ->replyTo($m->email, $m->name)
            ->view('emails.meeting')
            ->attachData($m->toIcs($summary), 'meeting.ics', ['mime' => 'text/calendar; charset=UTF-8; method=PUBLISH']);
    }
}
