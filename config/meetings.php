<?php

/*
|--------------------------------------------------------------------------
| Meeting scheduler
|--------------------------------------------------------------------------
| Bookable discovery-call slots shown on /schedule-meeting. All times are
| in the timezone below; visitors see them labelled as IST.
*/

return [

    'timezone' => 'Asia/Kolkata',

    // How many days ahead visitors can book
    'days_ahead' => 14,

    // ISO weekday numbers that are open: 1 = Monday ... 7 = Sunday
    'working_days' => [1, 2, 3, 4, 5, 6],

    // First and last slot start, and slot length
    'day_start'    => '10:00',
    'day_end'      => '18:00',
    'slot_minutes' => 30,

    // Minimum notice before a same-day slot
    'min_notice_hours' => 2,

    // How the call can happen: value => label
    'modes' => [
        'video'     => 'Video call',
        'phone'     => 'Phone call',
        'in_person' => 'In person (Delhi NCR)',
    ],

    // Video calls get a link generated at booking time. Jitsi Meet needs no
    // account or API key, so the link works immediately. The team can swap
    // it for a Google Meet / Zoom link from admin > Meetings and re-send.
    'video_base_url' => env('MEETING_VIDEO_BASE_URL', 'https://meet.jit.si'),

    'statuses' => [
        'pending'   => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],
];
