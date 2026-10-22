<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Meeting extends Model
{
    protected $table = 'meetings';

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'topic', 'mode', 'meeting_link',
        'meeting_date', 'meeting_time', 'notes', 'status', 'admin_note', 'ip',
        'client_notified_at',
    ];

    protected $casts = [
        'meeting_date'       => 'date',
        'client_notified_at' => 'datetime',
    ];

    /**
     * A fresh, unguessable video room URL for this meeting, e.g.
     * https://meet.jit.si/Leamsoft-20261024-1430-k3v9q2mz7a
     */
    public static function newVideoLink(string $date, string $time): string
    {
        $room = 'Leamsoft-' . str_replace('-', '', $date) . '-' . str_replace(':', '', $time) . '-' . strtolower(\Illuminate\Support\Str::random(10));

        return rtrim(config('meetings.video_base_url', 'https://meet.jit.si'), '/') . '/' . $room;
    }

    /** Where the meeting happens, in one line, for emails and calendars. */
    public function locationText(): string
    {
        return match ($this->mode) {
            'video'     => $this->meeting_link ?: 'Video call (link to follow)',
            'phone'     => 'Phone call to ' . $this->phone,
            'in_person' => self::officeAddress() ?: 'Leamsoft office, Delhi NCR',
            default     => (string) $this->mode_label,
        };
    }

    public static function officeAddress(): ?string
    {
        $a = config('seo.address');

        return !empty($a['street'])
            ? implode(', ', array_filter([$a['street'], $a['locality'], $a['region'], $a['postcode']]))
            : null;
    }

    /** One-click "add to Google Calendar" URL. */
    public function googleCalendarUrl(string $title = 'Call with Leamsoft'): string
    {
        return 'https://calendar.google.com/calendar/render?' . http_build_query([
            'action'   => 'TEMPLATE',
            'text'     => $title,
            'dates'    => $this->startsAt()->copy()->utc()->format('Ymd\THis\Z') . '/' . $this->endsAt()->copy()->utc()->format('Ymd\THis\Z'),
            'details'  => trim(($this->meeting_link ? 'Join: ' . $this->meeting_link . "\n\n" : '') . 'Discovery call with the Leamsoft team (' . $this->mode_label . ').'),
            'location' => $this->locationText(),
        ]);
    }

    /**
     * iCalendar invite. The sequence number lets a re-sent invite (e.g.
     * after the link changes) update the same calendar entry.
     */
    public function toIcs(string $summary, int $sequence = 0): string
    {
        $fmt = fn ($c) => $c->copy()->utc()->format('Ymd\THis\Z');
        $esc = fn ($s) => str_replace(["\\", ';', ',', "\r\n", "\n"], ["\\\\", '\;', '\,', '\n', '\n'], (string) $s);

        $desc = implode("\n", array_filter([
            $this->meeting_link ? 'Join: ' . $this->meeting_link : null,
            'Name: ' . $this->name,
            'Email: ' . $this->email,
            'Phone: ' . $this->phone,
            $this->company ? 'Company: ' . $this->company : null,
            $this->topic ? 'Topic: ' . $this->topic : null,
            'Mode: ' . $this->mode_label,
            $this->notes ? 'Notes: ' . $this->notes : null,
        ]));

        $lines = array_filter([
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Leamsoft//Meetings//EN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:meeting-' . $this->id . '@' . (parse_url(config('app.url'), PHP_URL_HOST) ?: 'leamsoft.com'),
            'SEQUENCE:' . $sequence,
            'DTSTAMP:' . $fmt(now()),
            'DTSTART:' . $fmt($this->startsAt()),
            'DTEND:' . $fmt($this->endsAt()),
            'SUMMARY:' . $esc($summary),
            'DESCRIPTION:' . $esc($desc),
            'LOCATION:' . $esc($this->locationText()),
            $this->meeting_link ? 'URL:' . $this->meeting_link : null,
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        return implode("\r\n", $lines) . "\r\n";
    }

    /** Meetings that still occupy their slot. */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }

    /** Upcoming, not cancelled, soonest first. */
    public function scopeUpcoming($query)
    {
        return $query->active()
            ->whereDate('meeting_date', '>=', Carbon::now(config('meetings.timezone'))->toDateString())
            ->orderBy('meeting_date')
            ->orderBy('meeting_time');
    }

    public function startsAt(): Carbon
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->meeting_date->format('Y-m-d') . ' ' . $this->meeting_time,
            config('meetings.timezone')
        );
    }

    public function endsAt(): Carbon
    {
        return $this->startsAt()->addMinutes(config('meetings.slot_minutes', 30));
    }

    public function getModeLabelAttribute(): string
    {
        return config('meetings.modes.' . $this->mode, ucfirst(str_replace('_', ' ', (string) $this->mode)));
    }

    public function getStatusLabelAttribute(): string
    {
        return config('meetings.statuses.' . $this->status, ucfirst((string) $this->status));
    }

    /**
     * Bookable days with their free slots:
     *   [['date' => 'Y-m-d', 'weekday' => 'Mon', 'day' => '24', 'month' => 'Oct', 'slots' => ['10:00', ...]], ...]
     * Days with no free slot are left out.
     */
    public static function availableDays(): array
    {
        $cfg = config('meetings');
        $tz = $cfg['timezone'];
        $now = Carbon::now($tz);
        $earliest = $now->copy()->addHours($cfg['min_notice_hours']);
        $lastDay = $now->copy()->startOfDay()->addDays($cfg['days_ahead']);

        $taken = self::active()
            ->whereDate('meeting_date', '>=', $now->toDateString())
            ->whereDate('meeting_date', '<=', $lastDay->toDateString())
            ->get(['meeting_date', 'meeting_time'])
            ->map(fn ($m) => $m->meeting_date->format('Y-m-d') . ' ' . $m->meeting_time)
            ->flip();

        $days = [];
        for ($d = $now->copy()->startOfDay(); $d->lte($lastDay); $d->addDay()) {
            if (! in_array($d->isoWeekday(), $cfg['working_days'], true)) {
                continue;
            }

            $slots = [];
            $slot = Carbon::createFromFormat('Y-m-d H:i', $d->format('Y-m-d') . ' ' . $cfg['day_start'], $tz);
            $end = Carbon::createFromFormat('Y-m-d H:i', $d->format('Y-m-d') . ' ' . $cfg['day_end'], $tz);

            while ($slot->lt($end)) {
                $key = $slot->format('Y-m-d H:i');
                if ($slot->gte($earliest) && ! isset($taken[$key])) {
                    $slots[] = $slot->format('H:i');
                }
                $slot->addMinutes($cfg['slot_minutes']);
            }

            if ($slots) {
                $days[] = [
                    'date'    => $d->format('Y-m-d'),
                    'weekday' => $d->format('D'),
                    'day'     => $d->format('j'),
                    'month'   => $d->format('M'),
                    'long'    => $d->format('l, j F'),
                    'slots'   => $slots,
                ];
            }
        }

        return $days;
    }

    /** Whether a date + time is currently bookable. */
    public static function isAvailable(string $date, string $time): bool
    {
        foreach (self::availableDays() as $day) {
            if ($day['date'] === $date) {
                return in_array($time, $day['slots'], true);
            }
        }

        return false;
    }

    /** "2:30 PM" from "14:30" */
    public static function timeLabel(string $time): string
    {
        return Carbon::createFromFormat('H:i', $time)->format('g:i A');
    }
}
