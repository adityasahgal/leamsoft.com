@php
    $badge = ['pending' => 'warning', 'confirmed' => 'primary', 'completed' => 'success', 'cancelled' => 'secondary'];
@endphp
<div class="modal-header">
    <h4 class="modal-title">
        Meeting with {{ $row->name }}
        <span class="badge badge-{{ $badge[$row->status] ?? 'secondary' }} ml-2" style="font-size:12px;vertical-align:middle">{{ $row->status_label }}</span>
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <table class="table table-borderless table-sm mb-3">
        <tbody>
            <tr>
                <th style="width:140px">When (IST)</th>
                <td>{{ $row->startsAt()->format('l, j F Y') }}, {{ $row->startsAt()->format('g:i A') }} – {{ $row->endsAt()->format('g:i A') }}</td>
            </tr>
            <tr>
                <th>Mode</th>
                <td>{{ $row->mode_label }}@if($row->mode !== 'video') · {{ $row->locationText() }}@endif</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $row->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>
                    <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a>
                    · <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->phone) }}" target="_blank" rel="noopener">WhatsApp</a>
                </td>
            </tr>
            <tr>
                <th>Company</th>
                <td>{{ $row->company ?: '—' }}</td>
            </tr>
            <tr>
                <th>Topic</th>
                <td>{{ $row->topic ?: '—' }}</td>
            </tr>
            <tr>
                <th>Notes</th>
                <td>{!! $row->notes ? nl2br(e($row->notes)) : '—' !!}</td>
            </tr>
            <tr>
                <th>Booked on</th>
                <td>{{ $row->created_at->format('j F Y, g:i A') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="form-group">
        <label for="meeting_link">Meeting link</label>
        <div class="input-group">
            <input type="url" id="meeting_link" class="form-control" value="{{ $row->meeting_link }}" placeholder="https://meet.google.com/… or https://meet.jit.si/…">
            <div class="input-group-append">
                @if($row->meeting_link)
                    <a href="{{ $row->meeting_link }}" target="_blank" rel="noopener" class="btn btn-outline-secondary" title="Open link"><i class="fas fa-external-link-alt"></i></a>
                @endif
                <button type="button" class="btn btn-outline-secondary" onclick='newMeetingLink({{ (int) $row->id }})' title="Generate a new video link">New video link</button>
            </div>
        </div>
        <small class="form-text text-muted">
            Paste a Google Meet / Zoom link, or generate a free video link. Use “Save &amp; email client” to send the updated details.
            @if($row->client_notified_at)
                Client last emailed {{ $row->client_notified_at->timezone(config('meetings.timezone'))->format('j M, g:i A') }}.
            @else
                <span class="text-danger">Client has not been emailed yet.</span>
            @endif
        </small>
    </div>

    <div class="form-group">
        <label for="admin_note">Internal note</label>
        <textarea id="admin_note" class="form-control" rows="3" placeholder="Who's attending, follow-up…">{{ $row->admin_note }}</textarea>
    </div>

    <div class="form-group mb-0">
        <label for="meeting_status">Status</label>
        <select id="meeting_status" class="form-control" style="max-width:220px">
            @foreach(config('meetings.statuses') as $value => $label)
                <option value="{{ $value }}" @selected($value === $row->status)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <a href="{{ $row->googleCalendarUrl('Leamsoft call with ' . $row->name) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
        <i class="far fa-calendar-plus"></i> Add to my calendar
    </a>
    <div>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick='saveMeeting({{ (int) $row->id }}, false)'>Save</button>
        <button type="button" class="btn btn-sm btn-primary" onclick='saveMeeting({{ (int) $row->id }}, true)'>
            <i class="fas fa-paper-plane"></i> Save &amp; email client
        </button>
    </div>
</div>
