@extends('layouts.admin')
@push('style')

@endpush
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Services</span>
                        <span class="info-box-number">{{ $serviceCounts }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Blogs</span>
                        <span class="info-box-number">{{ $blogCounts }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Enquiries</span>
                        <span class="info-box-number">{{ $enquiryCounts }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{ route('meetings.index') }}" class="info-box mb-3 text-dark">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Upcoming meetings</span>
                        <span class="info-box-number">{{ $meetingCounts }}</span>
                    </div>
                </a>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Upcoming Meetings</h3>
                        <div class="card-tools">
                            <a href="{{ route('meetings.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>When (IST)</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Phone</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $mBadge = ['pending' => 'warning', 'confirmed' => 'primary', 'completed' => 'success', 'cancelled' => 'secondary']; @endphp
                                @forelse($upcomingMeetings as $m)
                                <tr>
                                    <td>{{ $m->startsAt()->format('D, j M · g:i A') }}</td>
                                    <td>{{ $m->name }}</td>
                                    <td>{{ $m->company ?: '—' }}</td>
                                    <td><a href="tel:{{ $m->phone }}">{{ $m->phone }}</a></td>
                                    <td>
                                        {{ $m->mode_label }}
                                        @if($m->meeting_link)
                                            · <a href="{{ $m->meeting_link }}" target="_blank" rel="noopener"><i class="fas fa-video"></i> Join</a>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-{{ $mBadge[$m->status] ?? 'secondary' }}">{{ $m->status_label }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No upcoming meetings.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Latest Enquiries</h3>
                        <div class="card-tools">
                            <a href="{{ route('enquiry.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestEnquiries as $key => $row)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $row->created_at->format('j F, Y g:i A') }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick='getEnquiryDetails("{{ $row->id }}")'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No enquiries yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>

<!-- .modal -->
<div class="modal fade" id="enquiryDetailsModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="enquiryData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
@push('script')
<script>
    function getEnquiryDetails(id) {
        $.ajax({
            url: "{{ route('enquiry.show') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#enquiryData").html(result);
                $('#enquiryDetailsModel').modal('show');
            }
        });
    }
</script>
@endpush
