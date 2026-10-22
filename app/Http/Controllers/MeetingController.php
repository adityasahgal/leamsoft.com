<?php

namespace App\Http\Controllers;

use App\Mail\MeetingConfirmation;
use App\Mail\MeetingScheduled;
use App\Models\Meeting;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        if (! Meeting::isAvailable($date, $time)) {
            return $this->slotGone();
        }

        try {
            // Row-lock the slot inside a transaction so two people can't
            // book it at once. Needs only the meetings table -- no cache
            // store or cache_locks table involved.
            $meeting = DB::transaction(function () use ($request, $date, $time) {
                $taken = Meeting::active()
                    ->whereDate('meeting_date', $date)
                    ->where('meeting_time', $time)
                    ->lockForUpdate()
                    ->exists();

                if ($taken) {
                    return null;
                }

                return Meeting::create([
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone'        => $request->phone,
                    'company'      => $request->company,
                    'topic'        => $request->topic,
                    'mode'         => $request->mode,
                    'meeting_link' => $request->mode === 'video' ? Meeting::newVideoLink($date, $time) : null,
                    'meeting_date' => $date,
                    'meeting_time' => $time,
                    'notes'        => $request->notes,
                    'status'       => 'pending',
                    'ip'           => $request->ip(),
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Meeting booking failed: ' . $e->getMessage(), ['exception' => $e]);

            return back()
                ->withErrors(['slot' => 'We couldn’t save your booking just now. Please try again, or call/WhatsApp us and we’ll set it up for you.'])
                ->withInput();
        }

        if (! $meeting) {
            return $this->slotGone();
        }

        // Visitor first, so the admin email can say whether it went out
        self::sendClientConfirmation($meeting);

        try {
            Mail::to(config('mail.enquiry_to'))->send(new MeetingScheduled($meeting));
        } catch (\Throwable $e) {
            Log::error('Meeting admin mail failed: ' . $e->getMessage());
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

    /**
     * Email the visitor their date, time and join link. Records when it
     * went out; failures are logged, never shown to the visitor.
     */
    public static function sendClientConfirmation(Meeting $meeting, bool $updated = false): bool
    {
        try {
            Mail::to($meeting->email, $meeting->name)->send(new MeetingConfirmation($meeting, $updated));
            $meeting->forceFill(['client_notified_at' => now()])->save();

            return true;
        } catch (\Throwable $e) {
            Log::error('Meeting client mail failed: ' . $e->getMessage());

            return false;
        }
    }

    private function slotGone()
    {
        return back()
            ->withErrors(['slot' => 'Sorry, that slot was just taken. Please pick another time.'])
            ->withInput();
    }
}
