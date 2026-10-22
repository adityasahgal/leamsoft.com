<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class MeetingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:meeting-read');
    }

    public function index(Request $request)
    {
        $data = $this->query($request)->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.meetings.dataTable', compact('data'))->render();
        }

        $counts = [
            'upcoming' => Meeting::upcoming()->count(),
            'pending'  => Meeting::where('status', 'pending')->count(),
            'today'    => Meeting::active()->whereDate('meeting_date', Carbon::now(config('meetings.timezone'))->toDateString())->count(),
            'total'    => Meeting::count(),
        ];

        return view('admin.meetings.index', compact('data', 'counts'));
    }

    public function show(Request $request)
    {
        $row = Meeting::findOrFail($request->id);

        return view('admin.meetings.show', compact('row'))->render();
    }

    public function status(Request $request)
    {
        $request->validate([
            'id'           => 'required|integer|exists:meetings,id',
            'status'       => ['required', Rule::in(array_keys(config('meetings.statuses')))],
            'admin_note'   => 'nullable|string|max:2000',
            'meeting_link' => 'nullable|url|max:500',
            'notify'       => 'nullable|boolean',
        ]);

        $meeting = Meeting::findOrFail($request->id);
        $linkChanged = $request->has('meeting_link') && $request->meeting_link !== $meeting->meeting_link;

        $meeting->status = $request->status;
        if ($request->has('admin_note')) {
            $meeting->admin_note = $request->admin_note;
        }
        if ($request->has('meeting_link')) {
            $meeting->meeting_link = $request->meeting_link ?: null;
        }
        $meeting->save();

        $message = 'Meeting saved as ' . strtolower($meeting->status_label) . '.';

        if ($request->boolean('notify')) {
            $sent = \App\Http\Controllers\MeetingController::sendClientConfirmation($meeting, true);
            $message .= $sent
                ? ' Updated details emailed to ' . $meeting->email . '.'
                : ' But the email to the client could not be sent — check the mail settings.';
        } elseif ($linkChanged) {
            $message .= ' The client has not been emailed the new link yet.';
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    /** Fresh video link for a meeting (not saved until "Save"). */
    public function newLink(Request $request)
    {
        $meeting = Meeting::findOrFail($request->id);

        return response()->json([
            'link' => Meeting::newVideoLink($meeting->meeting_date->format('Y-m-d'), $meeting->meeting_time),
        ]);
    }

    /**
     * Listing query. Upcoming meetings come first by default (soonest at
     * the top); "past" and "all" are ordered newest first.
     */
    private function query(Request $request)
    {
        $today = Carbon::now(config('meetings.timezone'))->toDateString();
        $when = $request->input('when', 'upcoming');

        $q = Meeting::query();

        if ($search = trim((string) $request->search)) {
            $q->where(function ($w) use ($search) {
                $w->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        if ($when === 'upcoming') {
            $q->whereDate('meeting_date', '>=', $today)->orderBy('meeting_date')->orderBy('meeting_time');
        } elseif ($when === 'past') {
            $q->whereDate('meeting_date', '<', $today)->orderByDesc('meeting_date')->orderByDesc('meeting_time');
        } else {
            $q->orderByDesc('created_at');
        }

        return $q;
    }
}
