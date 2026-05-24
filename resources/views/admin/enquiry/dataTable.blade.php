<table class="table table-hover table-sm tabel-border">
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
        @foreach($data as $key => $row)
        <tr>
            <th>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</th>
            <td>{{ $row->created_at->format('j F, Y g:i A'); }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->phone }}</td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" onclick='getEnquiryDetails("<?= $row->id ?>")'>
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>
<hr>
<div class="row">
    <div class="col-md-3" style="margin-top:10px;">
        <p class="text-sm text-gray-700 leading-5">
            Showing
            <span class="font-medium">{{ $data->firstItem() }}</span>
            to
            <span class="font-medium">{{ $data->lastItem() }}</span>
            of
            <span class="font-medium">{{ $data->total() }}</span>
            results
        </p>

    </div>
    <div class="col-md-9">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>
<input type="hidden" value="{{ $data->path()."?page=".$data->currentPage() }}" id="pageUrl">
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