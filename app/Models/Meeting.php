<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Meeting extends Model
{
    protected $table = 'meetings';

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'topic', 'mode',
        'meeting_date', 'meeting_time', 'notes', 'status', 'admin_note', 'ip',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

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
