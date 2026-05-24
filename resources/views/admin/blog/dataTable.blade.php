<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Banner</th>
            <th>Update Date</th>
            <th>Update By</th>
            @can('blog-publish')
            <th>Status</th>
            @endcan
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <th>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</th>
            <td>{{ $row->name }}</td>
            <td>
                @if(file_exists('storage/' . $row->banner) && !empty($row->banner))
                <img src="{{ url('storage/'.$row->banner) }}" alt="{{ $row->image_alt }}" style="width: 84px;height: 48px;">
                @endif
            </td>
            <td>{{ $row->updated_at->format('j F, Y') }}</td>
            <td>
                @if(!empty($row->users->name))
                {{ $row->users->name }}
                @endif
            </td>
            @can('blog-publish')
            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->status == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            <td>
                <div class="btn-group">
                    @can('blog-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getblogDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan

                    @can('blog-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteblogData("<?= $row->id ?>")'>
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
<div class="modal fade" id="blogUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="blogData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    function getblogDetails(id) {
        $.ajax({
            url: "{{ route('blog.edit') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#blogData").html(result);
                $('#blogUpdateModel').modal('show');
            }
        });
    }


    function deleteblogData(id) {
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
                    url: "{{ route('blog.destroy') }}",
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
            url: "{{ route('blog.status') }}",
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
                        text: "Blog Status Successfully Changed !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Blog Status Not Changed !."
                    });
                }
            }
        });
    }
</script>