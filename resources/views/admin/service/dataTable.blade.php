<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Property Name</th>
            <th>Thumbnail Images</th>
            <th>Update Date</th>
            <th>Update By</th>
            @can('service-publish')
            <th>Featured</th>
            <th>Top</th>
            <th>Status</th>
            @endcan
            @canany(['service-edit','service-delete'])
            <th>Action</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <th>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</th>
            <td>{{ $row->name }}</td>
            <td>
                @if(file_exists('storage/' . $row->thumbnail_img) && !empty($row->thumbnail_img))
                <img src="{{ url('storage/'.$row->thumbnail_img) }}" alt="{{ $row->image_alt }}" style="width: 130px;height: 65px;">
                @endif
            </td>
            <td>{{ $row->updated_at->format('j F, Y') }}</td>
            <td>{{ $row->users->name }}</td>
            @can('service-publish')
            <td>
                <label class="switch">
                    <input onchange="update_featured(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->featured == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>
            <td>
                <label class="switch">
                    <input onchange="update_top(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->top == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>

            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" <?php if ($row->status == 1) echo "checked"; ?>>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            @canany(['service-edit','service-delete'])
            <td>
                <div class="btn-group">
                    @can('service-edit')
                    <a href="{{ route('service.edit', Crypt::encrypt($row->id)) }}" type="button" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i></a>
                    @endcan

                    @can('service-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteServiceData("<?= $row->id ?>")'>
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


<script>
    function deleteServiceData(id) {
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
                    url: "{{ route('service.destroy') }}",
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
            url: "{{ route('service.status') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': el.value,
                'status': status,
                'type': 'status'
            },
            type: 'POST',
            success: function(results) {
                if (results.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "Service Status Successfully Changed !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Service Status Not Changed !."
                    });
                }
            }
        });
    }

    function update_featured(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: "{{ route('service.status') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': el.value,
                'status': status,
                'type': 'featured'
            },
            type: 'POST',
            success: function(results) {
                if (results.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "Featured service updated successfully !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Something went wrong !."
                    });
                }
            }
        });
    }

    function update_top(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: "{{ route('service.status') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': el.value,
                'status': status,
                'type': 'top'
            },
            type: 'POST',
            success: function(results) {
                if (results.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "Top service updated successfully !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Something went wrong !."
                    });
                }
            }
        });
    }
</script>