<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the visitor who booked: when, how to join, calendar invite.
 * Also used when the team updates the link and re-sends from admin.
 */
class MeetingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $updated;

    /**
     * @param  bool  $updated  true when re-sent from admin after a change
     */
    public function __construct(Meeting $meeting, bool $updated = false)
    {
        $this->meeting = $meeting;
        $this->updated = $updated;
    }

    public function build()
    {
        $m = $this->meeting;
        $when = $m->startsAt()->format('D j M, g:i A') . ' IST';
        $replyTo = config('mail.enquiry_to');

        $mail = $this->subject(($this->updated ? 'Updated: ' : '') . 'Your meeting with Leamsoft — ' . $when)
            ->view('emails.meeting-confirmation')
            ->attachData(
                $m->toIcs('Call with Leamsoft', $this->updated ? (int) now()->timestamp % 100000 : 0),
                'leamsoft-meeting.ics',
                ['mime' => 'text/calendar; charset=UTF-8; method=PUBLISH']
            );

        if ($replyTo) {
            $mail->replyTo($replyTo, 'Leamsoft');
        }

        return $mail;
    }
}
