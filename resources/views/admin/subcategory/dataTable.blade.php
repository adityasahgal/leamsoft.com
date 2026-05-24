<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Name</th>
            <th>Banner</th>
            <th>Icon</th>
            <th>Update Date</th>
            <th>Update By</th>
            @can('subcategory-publish')
            <th>Featured</th>
            <th>Top</th>
            <th>Status</th>
            @endcan
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>

            <th>{{ ($key+1) + ($data->currentPage() - 1)*$data->perPage() }}</th>
            <td>{{ $row->categories->name }}</td>
            <td>{{ $row->name }}</td>
            <td>
                @if(file_exists('storage/' . $row->banner) && !empty($row->banner))
                <img class="img-md" src="{{ url('storage/'.$row->banner) }}" alt="banner">
                @endif
            </td>
            <td>
                @if(file_exists('storage/' . $row->icon) && !empty($row->icon))
                <img class="img-xs" src="{{ url('storage/'.$row->icon) }}" alt="icon">
                @endif
            </td>
            <td>{{ $row->updated_at->format('j F, Y') }}</td>
            <td>{{ $row->users->name }}</td>
            @can('subcategory-publish')
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
            <td>
                <div class="btn-group">
                    @can('subcategory-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getSubcategoryDetails("<?= $row->id ?>")'>
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan

                    @can('subcategory-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteSubcategoryData("<?= $row->id ?>")'>
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
<div class="modal fade" id="subcategoryUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="subcategoryData">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    function getSubcategoryDetails(id) {
        $.ajax({
            url: "{{ route('subcategory.edit') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            type: 'POST',
            success: function(result) {
                $("#subcategoryData").html(result);
                $('#subcategoryUpdateModel').modal('show');
            }
        });
    }


    function deleteSubcategoryData(id) {
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
                    url: "{{ route('subcategory.destroy') }}",
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
            url: "{{ route('subcategory.status') }}",
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
                        text: "Subcategory Status Successfully Changed !."
                    });
                } else {
                    Swal.fire({
                        icon: 'danger',
                        title: 'Danger!',
                        text: "Subcategory Status Not Changed !."
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
            url: "{{ route('subcategory.status') }}",
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
                        text: "Featured subcategories updated successfully !."
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
            url: "{{ route('subcategory.status') }}",
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
                        text: "Top subcategories updated successfully !."
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