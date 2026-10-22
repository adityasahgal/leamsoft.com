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
                <td>{{ $row->mode_label }}</td>
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
        <label for="admin_note">Internal note</label>
        <textarea id="admin_note" class="form-control" rows="3" placeholder="Meeting link, who's attending, follow-up…">{{ $row->admin_note }}</textarea>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div>
        @foreach(config('meetings.statuses') as $value => $label)
            @if($value !== $row->status)
                <button type="button" class="btn btn-sm btn-outline-{{ $badge[$value] ?? 'secondary' }}" onclick='setMeetingStatus({{ (int) $row->id }}, @json($value))'>
                    Mark {{ strtolower($label) }}
                </button>
            @endif
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-primary" onclick='setMeetingStatus({{ (int) $row->id }}, @json($row->status))'>Save note</button>
</div>
