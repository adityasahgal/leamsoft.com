@extends('layouts.admin')
@push('style')
<link rel="stylesheet" href="{{asset('admin/css/user.css')}}">
<style>
    .img-md { width: 64px; height: 32px; object-fit: cover; }
    .img-xs { width: 32px; height: 32px; object-fit: cover; }
    .icon-cell { font-size: 22px; }
</style>
@endpush
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(Session('status'))
                <script>
                    Swal.fire({
                        icon: '<?= Session('status') ?>',
                        title: '<?= Session('status') ?>',
                        text: '<?= Session('message') ?>',
                    })
                </script>
                @endif

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Manage Subcategories</h3>
                        <div class="row card-tools" style="width:100%;">
                            <div class="col-md-3 input-group input-group-sm">
                                <select id="category_id" class="form-control" onchange="filterData()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 input-group input-group-sm">
                                <select id="status" class="form-control" onchange="filterData()">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">De-active</option>
                                </select>
                            </div>
                            <div class="col-md-4 input-group input-group-sm">
                                <input type="text" id="search" class="form-control" placeholder="Search" onkeyup="filterData()">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default" style="height:31px;" onclick="filterData()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                @can('subcategory-create')
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModel">
                                    <i class="fas fa-plus"></i> Add Subcategory
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive" id="tag_container">
                        @include('admin.subcategory.dataTable')
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="spinnerModal">
            <div class="modal-dialog spinner-model modal-lg">
                <div class="text-center">
                    <div class="lds-spinner">
                        <div></div><div></div><div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div><div></div><div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ADD SUBCATEGORY MODAL --}}
<div class="modal fade" id="addModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-primary card-outline">
            <div class="modal-header">
                <h4 class="modal-title">Add New Subcategory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Subcategory Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Slug <small class="text-muted">(optional)</small></label>
                            <input type="text" class="form-control" name="slug" placeholder="auto-generated-from-name">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label>Icon <small class="text-muted">(emoji or icon class)</small></label>
                                <input type="text" class="form-control" name="icon" placeholder="•">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail Image</label>
                            <input type="file" class="form-control-file" name="thumbnail_img" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <textarea name="keywords" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    function filterData() {
        var search = $("#search").val();
        var status = $("#status").val();
        var category_id = $("#category_id").val();
        $.ajax({
            type: "GET",
            url: "{{ route('subcategory.index') }}",
            data: { search: search, status: status, category_id: category_id },
            beforeSend: function() { $("#spinnerModal").show(); },
            success: function(data) { $('#tag_container').html(data); },
            complete: function() { $("#spinnerModal").hide(); }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            getData($(this).attr('href'));
        });
    });

    function getData(url) {
        var search = $("#search").val();
        var status = $("#status").val();
        var category_id = $("#category_id").val();
        $.ajax({
            url: url, type: 'GET',
            data: { search: search, status: status, category_id: category_id },
            beforeSend: function() { $("#spinnerModal").show(); },
            success: function(data) { $('#tag_container').html(data); },
            complete: function() { $("#spinnerModal").hide(); }
        });
    }
</script>
@endpush
