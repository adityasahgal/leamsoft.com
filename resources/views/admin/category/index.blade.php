@extends('layouts.admin')
@push('style')
<link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
<style>
  .img-md {
    width: 64px;
    height: 32px;
}

.img-xs {
    width: 32px;
    height: 32px;
}
</style>
@endpush
@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- /.row -->

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
            <h3 class="card-title">Manage Category</h3>

            <div class="row card-tools">
              <div class="col-md-6 input-group input-group-sm">
                <input type="text" name="search" id="search" class="form-control float-right" placeholder="Search" onkeyup="search_func(this.value);">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default" style="height: 31px;">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-6">
                @can('category-create')
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#addModel">Add Category</button>
                @endcan
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive" id="tag_container">
            @include('admin.category.dataTable')
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div>
</section>



<!-- .modal -->
<div class="modal fade" id="addModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card-primary card-outline">
      <div class="modal-header">
        <h4 class="modal-title">Add New Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Category Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
              <label for="baner">Banner</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="banner" accept="image/*" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose Banner</label>
                </div>

              </div>
            </div>
            <div class="form-group">
              <label for="icon">Icon</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="icon" accept="image/*" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose Icon</label>
                </div>

              </div>
            </div>

            <div class="form-group">
              <label>Short Description</label>
              <textarea name="short_description" class="form-control"></textarea>
            </div>
            <div class="form-group">
             <label for="description">Description</label>
             <textarea id="textarea" name="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Image Alt</label>
              <input type="text" name="image_alt" class="form-control">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Meta Title</label>
              <input type="text" name="meta_title" class="form-control">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Meta Description</label>
              <textarea name="meta_description" class="form-control" placeholder="Text Here"></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Keywords</label>
              <textarea name="keywords" class="form-control" placeholder="Text Here"></textarea>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@push('script')
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script type="text/javascript">
  $(function() {
    // Summernote
    $('#textarea').summernote()
  });

  $(document).ready(function() {
    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      $('li').removeClass('active');
      $(this).parent('li').addClass('active');

      var myurl = $(this).attr('href');
      // var page=$(this).attr('href').split('page=')[1];
      getData(myurl);
    });

  });

  function getData(url) {
    var value = document.getElementById("search").value;
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        'search': value
      },
      success: function(data) {
        $('#tag_container').html(data);
      },
      error: function(err) {
        alert("No response from server");
      }
    });
  }

  function search_func(value) {
    $.ajax({
      type: "GET",
      url: "{{ route('category.index') }}",
      data: {
        'search': value
      },
      success: function(data) {
        $('#tag_container').html(data);
      },
      error: function(err) {
        alert("No response from server");
      }
    });
  }
</script>
@endpush