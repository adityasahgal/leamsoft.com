@php
    $badge = ['pending' => 'warning', 'confirmed' => 'primary', 'completed' => 'success', 'cancelled' => 'secondary'];
    $today = \Illuminate\Support\Carbon::now(config('meetings.timezone'))->toDateString();
@endphp
<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Meeting time (IST)</th>
            <th>Name</th>
            <th>Company</th>
            <th>Contact</th>
            <th>Mode</th>
            <th>Topic</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $row)
        <tr>
            <th>{{ ($key + 1) + ($data->currentPage() - 1) * $data->perPage() }}</th>
            <td>
                <strong>{{ $row->startsAt()->format('D, j M Y') }}</strong><br>
                {{ $row->startsAt()->format('g:i A') }}
                @if($row->meeting_date->toDateString() === $today && $row->status !== 'cancelled')
                    <span class="badge badge-success ml-1">Today</span>
                @endif
            </td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->company ?: '—' }}</td>
            <td>
                <a href="mailto:{{ $row->email }}">{{ $row->email }}</a><br>
                <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a>
            </td>
            <td>{{ $row->mode_label }}</td>
            <td>{{ $row->topic ?: '—' }}</td>
            <td><span class="badge badge-{{ $badge[$row->status] ?? 'secondary' }}">{{ $row->status_label }}</span></td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" title="View" onclick='getMeetingDetails({{ (int) $row->id }})'>
                        <i class="fas fa-eye"></i>
                    </button>
                    @if($row->status === 'pending')
                        <button type="button" class="btn btn-success btn-sm" title="Confirm" onclick='setMeetingStatus({{ (int) $row->id }}, "confirmed")'>
                            <i class="fas fa-check"></i>
                        </button>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center text-muted py-4">No meetings found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col-md-3" style="margin-top:10px;">
        <p class="text-sm text-gray-700 leading-5">
            Showing <span class="font-medium">{{ $data->firstItem() ?? 0 }}</span>
            to <span class="font-medium">{{ $data->lastItem() ?? 0 }}</span>
            of <span class="font-medium">{{ $data->total() }}</span> results
        </p>
    </div>
    <div class="col-md-9">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>
<input type="hidden" value="{{ $data->url($data->currentPage()) }}" id="pageUrl">
