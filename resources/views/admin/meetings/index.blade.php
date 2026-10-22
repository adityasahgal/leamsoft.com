@extends('layouts.admin')

@section('content')
<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-alt"></i></span>
          <div class="info-box-content"><span class="info-box-text">Upcoming</span><span class="info-box-number">{{ $counts['upcoming'] }}</span></div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hourglass-half"></i></span>
          <div class="info-box-content"><span class="info-box-text">Pending confirmation</span><span class="info-box-number">{{ $counts['pending'] }}</span></div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-day"></i></span>
          <div class="info-box-content"><span class="info-box-text">Today</span><span class="info-box-number">{{ $counts['today'] }}</span></div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
          <div class="info-box-content"><span class="info-box-text">All time</span><span class="info-box-number">{{ $counts['total'] }}</span></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Scheduled Meetings</h3>
            <div class="card-tools d-flex" style="gap:8px">
              <select id="filter-when" class="form-control form-control-sm" style="width:auto">
                <option value="upcoming" selected>Upcoming</option>
                <option value="past">Past</option>
                <option value="all">All (newest booked)</option>
              </select>
              <select id="filter-status" class="form-control form-control-sm" style="width:auto">
                <option value="">Any status</option>
                @foreach(config('meetings.statuses') as $value => $label)
                  <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
              </select>
              <div class="input-group input-group-sm" style="width:220px">
                <input type="text" id="search" class="form-control" placeholder="Name, email, phone, company">
                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive" id="tag_container">
            @include('admin.meetings.dataTable')
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<div class="modal fade" id="meetingModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card-primary card-outline" id="meetingData"></div>
  </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
  var meetingsUrl = "{{ route('meetings.index') }}";
  var searchTimer;

  function currentFilters() {
    return {
      search: $('#search').val(),
      status: $('#filter-status').val(),
      when: $('#filter-when').val()
    };
  }

  function loadMeetings(url) {
    $.ajax({
      url: url || meetingsUrl,
      type: 'GET',
      data: currentFilters(),
      success: function(html) { $('#tag_container').html(html); },
      error: function() { alert('No response from server'); }
    });
  }

  $(document).on('click', '#tag_container .pagination a', function(e) {
    e.preventDefault();
    loadMeetings($(this).attr('href'));
  });
  $('#filter-status, #filter-when').on('change', function() { loadMeetings(); });
  $('#search').on('keyup', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() { loadMeetings(); }, 250);
  });

  function getMeetingDetails(id) {
    $.ajax({
      url: "{{ route('meetings.show') }}",
      type: 'POST',
      data: { _token: "{{ csrf_token() }}", id: id },
      success: function(html) {
        $('#meetingData').html(html);
        $('#meetingModal').modal('show');
      }
    });
  }

  function postMeeting(payload, closeModal) {
    payload._token = "{{ csrf_token() }}";
    $.ajax({
      url: "{{ route('meetings.status') }}",
      type: 'POST',
      data: payload,
      success: function(res) {
        if (closeModal) $('#meetingModal').modal('hide');
        Swal.fire({ icon: 'success', title: 'Saved', text: res.message });
        loadMeetings($('#pageUrl').val());
      },
      error: function(xhr) {
        var msg = 'Could not update the meeting.';
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          msg = Object.values(xhr.responseJSON.errors).map(function(e) { return e[0]; }).join(' ');
        }
        Swal.fire({ icon: 'error', title: 'Error', text: msg });
      }
    });
  }

  // Quick action from the table (e.g. Confirm) -- keeps link and note as they are
  function setMeetingStatus(id, status) {
    postMeeting({ id: id, status: status }, false);
  }

  // Save from the details modal; notify = also email the client the details
  function saveMeeting(id, notify) {
    var link = $.trim($('#meeting_link').val());
    if (notify && !link && !confirm('There is no meeting link. Email the client anyway?')) return;
    postMeeting({
      id: id,
      status: $('#meeting_status').val(),
      admin_note: $('#admin_note').val(),
      meeting_link: link,
      notify: notify ? 1 : 0
    }, true);
  }

  function newMeetingLink(id) {
    $.post("{{ route('meetings.newLink') }}", { _token: "{{ csrf_token() }}", id: id }, function(res) {
      $('#meeting_link').val(res.link).trigger('focus');
    });
  }
</script>
@endpush
