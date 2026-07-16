<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Logo</th>
            <th>Name</th>
            <th>Company</th>
            <th>Website</th>
            <th>Update By</th>
            @can('client-publish')
            <th>Status</th>
            @endcan
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <th>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</th>
            <td>
                @if(file_exists('storage/' . $row->logo) && !empty($row->logo))
                <img src="{{ url('storage/'.$row->logo) }}" alt="{{ $row->image_alt }}" style="width: 60px;height: 48px;object-fit:contain;">
                @endif
            </td>
            <td>{{ $row->name }}<br><small class="text-muted">{{ $row->designation }}</small></td>
            <td>{{ $row->company }}</td>
            <td>
                @if(!empty($row->website))
                <a href="{{ $row->website }}" target="_blank" rel="noopener">Visit</a>
                @endif
            </td>
            <td>{{ optional($row->users)->name }}</td>
            @can('client-publish')
            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->status == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            <td>
                <div class="btn-group">
                    @can('client-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getclientDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan
                    @can('client-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteclientData("<?= $row->id ?>")'>
                        <i class="far fa-trash-alt"></i>
                    </button>
                    @endcan
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
<div class="modal fade" id="clientUpdateModel">
    <div class="modal-dialog modal-default">
        <div class="modal-content card-primary card-outline" id="clientData">
        </div>
    </div>
</div>
<!-- /.modal -->

<script>
    function getclientDetails(id) {
        $.ajax({
            url: "{{ route('client.edit') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#clientData").html(result);
                $('#clientUpdateModel').modal('show');
            }
        });
    }

    function deleteclientData(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('client.destroy') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    type: 'POST',
                    success: function(results) {
                        if (results.status == "success") {
                            Swal.fire('Deleted!', results.message, results.status).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', results.message, results.status);
                        }
                    }
                });
            }
        })
    }

    function update_status(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: "{{ route('client.status') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': el.value,
                'status': status
            },
            type: 'POST',
            success: function(results) {
                if (results.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "Client Status Successfully Changed !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Client Status Not Changed !."
                    });
                }
            }
        });
    }
</script>
