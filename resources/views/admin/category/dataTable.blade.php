<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Icon</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Thumbnail</th>
            <th>Subs</th>
            <th>Services</th>
            <th>Sort</th>
            <th>Updated</th>
            <th>By</th>
            @can('category-publish')
                <th>Featured</th>
                <th>Status</th>
            @endcan
            @canany(['category-edit','category-delete'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $row)
        <tr>
            <th>{{ ($key+1) + ($data->currentPage() - 1) * $data->perPage() }}</th>
            <td class="icon-cell">{{ $row->icon }}</td>
            <td>{{ $row->name }}</td>
            <td><code>{{ $row->slug }}</code></td>
            <td>
                @if(!empty($row->thumbnail_img) && file_exists('storage/' . $row->thumbnail_img))
                    <img src="{{ url('storage/' . $row->thumbnail_img) }}" alt="{{ $row->name }}" class="img-md">
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>
            <td>{{ $row->subcategories_count }}</td>
            <td>{{ $row->services_count }}</td>
            <td>{{ $row->sort_order }}</td>
            <td>{{ $row->updated_at?->format('j M, Y') }}</td>
            <td>{{ $row->users->name ?? '-' }}</td>
            @can('category-publish')
            <td>
                <label class="switch">
                    <input onchange="update_featured(this)" value="{{ $row->id }}" type="checkbox" @if($row->featured == 1) checked @endif>
                    <span class="slider round"></span>
                </label>
            </td>
            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" @if($row->status == 1) checked @endif>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            @canany(['category-edit','category-delete'])
            <td>
                <div class="btn-group">
                    @can('category-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getCategoryDetails("{{ $row->id }}")' title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan
                    @can('category-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteCategoryData("{{ $row->id }}")' title="Delete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </td>
            @endcanany
        </tr>
        @empty
        <tr><td colspan="13" class="text-center text-muted py-4">No categories yet. Click <strong>Add Category</strong> to create your first.</td></tr>
        @endforelse
    </tbody>
</table>
<hr>
<div class="row">
    <div class="col-md-3" style="margin-top:10px;">
        <p class="text-sm text-gray-700 leading-5">
            Showing <span class="font-medium">{{ $data->firstItem() }}</span>
            to <span class="font-medium">{{ $data->lastItem() }}</span>
            of <span class="font-medium">{{ $data->total() }}</span> results
        </p>
    </div>
    <div class="col-md-9">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="categoryUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="categoryData"></div>
    </div>
</div>

<script>
    function getCategoryDetails(id) {
        $.ajax({
            url: "{{ route('category.edit') }}",
            data: { '_token': "{{ csrf_token() }}", 'id': id },
            type: 'POST',
            success: function(result) {
                $("#categoryData").html(result);
                $('#categoryUpdateModel').modal('show');
            }
        });
    }

    function deleteCategoryData(id) {
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
                    url: "{{ route('category.destroy') }}",
                    data: { '_token': "{{ csrf_token() }}", 'id': id },
                    type: 'POST',
                    success: function(results) {
                        Swal.fire(results.status === 'success' ? 'Deleted!' : 'Error!', results.message, results.status)
                            .then(() => { if (results.status === 'success') location.reload(); });
                    }
                });
            }
        });
    }

    function update_status(el) {
        var status = el.checked ? 1 : 0;
        $.ajax({
            url: "{{ route('category.status') }}",
            data: { '_token': "{{ csrf_token() }}", 'id': el.value, 'status': status, 'type': 'status' },
            type: 'POST',
            success: function(results) {
                Swal.fire({
                    icon: results.status === 'success' ? 'success' : 'error',
                    title: results.status === 'success' ? 'Success!' : 'Error!',
                    text: results.status === 'success' ? 'Category status updated.' : 'Status not changed.'
                });
            }
        });
    }

    function update_featured(el) {
        var status = el.checked ? 1 : 0;
        $.ajax({
            url: "{{ route('category.status') }}",
            data: { '_token': "{{ csrf_token() }}", 'id': el.value, 'status': status, 'type': 'featured' },
            type: 'POST',
            success: function(results) {
                Swal.fire({
                    icon: results.status === 'success' ? 'success' : 'error',
                    title: results.status === 'success' ? 'Success!' : 'Error!',
                    text: results.status === 'success' ? 'Featured flag updated.' : 'Something went wrong.'
                });
            }
        });
    }
</script>
