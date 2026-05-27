<table class="table table-hover table-sm tabel-border">
    <thead>
        <tr>
            <th>#</th>
            <th>Icon</th>
            <th>Name</th>
            <th>Category</th>
            <th>Slug</th>
            <th>Thumbnail</th>
            <th>Services</th>
            <th>Sort</th>
            <th>Updated</th>
            <th>By</th>
            @can('subcategory-publish')
                <th>Status</th>
            @endcan
            @canany(['subcategory-edit','subcategory-delete'])
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
            <td>{{ $row->category->name ?? '-' }}</td>
            <td><code>{{ $row->slug }}</code></td>
            <td>
                @if(!empty($row->thumbnail_img) && file_exists('storage/' . $row->thumbnail_img))
                    <img src="{{ url('storage/' . $row->thumbnail_img) }}" alt="{{ $row->name }}" class="img-md">
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>
            <td>{{ $row->services_count }}</td>
            <td>{{ $row->sort_order }}</td>
            <td>{{ $row->updated_at?->format('j M, Y') }}</td>
            <td>{{ $row->users->name ?? '-' }}</td>
            @can('subcategory-publish')
            <td>
                <label class="switch">
                    <input onchange="update_status(this)" value="{{ $row->id }}" type="checkbox" @if($row->status == 1) checked @endif>
                    <span class="slider round"></span>
                </label>
            </td>
            @endcan
            @canany(['subcategory-edit','subcategory-delete'])
            <td>
                <div class="btn-group">
                    @can('subcategory-edit')
                    <button type="button" class="btn btn-primary btn-sm" onclick='getSubcategoryDetails("{{ $row->id }}")' title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    @endcan
                    @can('subcategory-delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick='deleteSubcategoryData("{{ $row->id }}")' title="Delete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </td>
            @endcanany
        </tr>
        @empty
        <tr><td colspan="12" class="text-center text-muted py-4">No subcategories yet. Click <strong>Add Subcategory</strong> to create one.</td></tr>
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
<div class="modal fade" id="subcategoryUpdateModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline" id="subcategoryData"></div>
    </div>
</div>

<script>
    function getSubcategoryDetails(id) {
        $.ajax({
            url: "{{ route('subcategory.edit') }}",
            data: { '_token': "{{ csrf_token() }}", 'id': id },
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
            url: "{{ route('subcategory.status') }}",
            data: { '_token': "{{ csrf_token() }}", 'id': el.value, 'status': status },
            type: 'POST',
            success: function(results) {
                Swal.fire({
                    icon: results.status === 'success' ? 'success' : 'error',
                    title: results.status === 'success' ? 'Success!' : 'Error!',
                    text: results.status === 'success' ? 'Subcategory status updated.' : 'Status not changed.'
                });
            }
        });
    }
</script>
