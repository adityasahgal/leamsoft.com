<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>Roles Name</th>
            <th>Guard Name</th>
            <th>Create Date</th>
            @can('role-publish')
            <th>Grant Permission</th>
            @endcan
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->guard_name }}</td>
            <td>{{ $row->created_at->format('j F, Y') }}</td>
            @can('role-publish')
            <td>
                <div class="btn-group text-center">
                    <button type="button" class="btn btn-success btn-sm" onclick='grantPermisionDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </td>
            @endcan
            <td>
                <div class="btn-group">
                    @can('role-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getRolesDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan

                    @can('role-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteRolesData("<?= $row->id ?>")'>
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
<div class="modal fade" id="grantUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="grantData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- .modal -->
<div class="modal fade" id="RolesUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="RolesData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    function grantPermisionDetails(id) {
        $.ajax({
            url: "{{ route('roles.grant') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#grantData").html(result);
                $('#grantUpdateModel').modal('show');
            }
        });
    }

    function getRolesDetails(id) {
        $.ajax({
            url: "{{ route('roles.edit') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#RolesData").html(result);
                $('#RolesUpdateModel').modal('show');
            }
        });
    }


    function deleteRolesData(id) {
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
                    url: "{{ route('roles.destroy') }}",
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
</script>