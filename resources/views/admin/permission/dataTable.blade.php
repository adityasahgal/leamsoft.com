<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>Permission Name</th>
            <th>Create Date</th>
            @can('permission-publish')
            <th>Status</th>
            @endcan
            @canany(['permission-edit','permission-delete'])
            <th>Action</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->created_at->format('j F, Y') }}</td>
            @can('permission-publish')
            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->status == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            @canany(['permission-edit','permission-delete'])
            <td>
                <div class="btn-group">
                    @can('permission-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getPermissionDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan

                    @can('permission-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deletePermissionData("<?= $row->id ?>")'>
                        <i class="far fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </td>
            @endcanany
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
<div class="modal fade" id="permissionUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="permissionData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    function getPermissionDetails(id) {
        $.ajax({
            url: "{{ route('permission.edit') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#permissionData").html(result);
                $('#permissionUpdateModel').modal('show');
            }
        });
    }


    function deletePermissionData(id) {
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
                    url: "{{ route('permission.destroy') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    type: 'POST',
                    success: function(results) {

                        if (results.status == "success") {
                            Swal.fire(
                                'Deleted!',
                                results.message,
                                results.status
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                results.message,
                                results.status
                            );
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
            url: "{{ route('permission.status') }}",
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
                        text: "Permission Status Successfully Changed !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Permission Status Not Changed !."
                    });
                }
            }
        });
    }
</script>