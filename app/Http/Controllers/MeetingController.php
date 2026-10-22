<?php

namespace App\Http\Controllers;

use App\Mail\MeetingScheduled;
use App\Models\Meeting;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Public "schedule a meeting" flow: pick a slot, leave details, get a
 * confirmation. Bookings land in admin > Meetings.
 */
class MeetingController extends Controller
{
    public function create()
    {
        return view('frontend.meeting', [
            'days' => Meeting::availableDays(),
            'seo'  => Seo::page('meeting'),
        ]);
    }

    public function store(Request $request)
    {
        $recaptchaEnabled = config('recaptcha.enabled') && config('recaptcha.secret_key');

        $rules = [
            'slot'         => 'required|date_format:Y-m-d H:i',
            'mode'         => ['required', Rule::in(array_keys(config('meetings.modes')))],
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|numeric|digits_between:10,15',
            'company'      => 'nullable|string|max:255',
            'topic'        => 'nullable|string|max:150',
            'notes'        => 'nullable|string|max:2000',
            'website'      => 'prohibited', // honeypot -- humans never see it
        ];
        if ($recaptchaEnabled) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, [
            'slot.required'                 => 'Please pick a day and time for the meeting.',
            'slot.date_format'              => 'Please pick a day and time for the meeting.',
            'phone.numeric'                 => 'The phone must be a valid number.',
            'phone.digits_between'          => 'The phone number must be between 10 and 15 digits.',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA to proceed.',
            'website.prohibited'            => 'Something went wrong. Please try again.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($recaptchaEnabled) {
            $body = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
            ])->json();

            if (! ($body['success'] ?? false)) {
                return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
            }
        }

        [$date, $time] = explode(' ', $request->slot);

        // Hold the slot while we check and write, so two people can't take it at once
        $lock = Cache::lock("meeting-slot:{$date}:{$time}", 10);
        if (! $lock->get()) {
            return $this->slotGone();
        }

        try {
            if (! Meeting::isAvailable($date, $time)) {
                return $this->slotGone();
            }

            $meeting = Meeting::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'company'      => $request->company,
                'topic'        => $request->topic,
                'mode'         => $request->mode,
                'meeting_date' => $date,
                'meeting_time' => $time,
                'notes'        => $request->notes,
                'status'       => 'pending',
                'ip'           => $request->ip(),
            ]);
        } finally {
            $lock->release();
        }

        try {
            Mail::to(config('mail.enquiry_to'))->send(new MeetingScheduled($meeting));
        } catch (\Exception $e) {
            Log::error('Meeting mail failed: ' . $e->getMessage());
        }

        // Remember which booking this browser may view on the thank-you page
        session()->flash('meeting_booked', $meeting->id);

        return redirect()->route('meeting.thanks');
    }

    public function thanks()
    {
        $id = session('meeting_booked');
        $meeting = $id ? Meeting::find($id) : null;

        if (! $meeting) {
            return redirect()->route('meeting.create');
        }

        return view('frontend.meeting-thanks', [
            'meeting' => $meeting,
            'seo'     => Seo::page('meeting', ['robots' => 'noindex, follow', 'title' => 'Meeting scheduled']),
        ]);
    }

    private function slotGone()
    {
        return back()
            ->withErrors(['slot' => 'Sorry, that slot was just taken. Please pick another time.'])
            ->withInput();
    }
}
