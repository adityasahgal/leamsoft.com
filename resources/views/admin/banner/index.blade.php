@extends('layouts.admin')
@push('style')

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
            <h3 class="card-title">Manage Banner</h3>

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
                @can('banner-create')
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#addModel">Add Banner</button>
                @endcan
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive" id="tag_container">
            @include('admin.banner.dataTable')
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
  <div class="modal-dialog modal-default">
    <div class="modal-content card-primary card-outline">
      <div class="modal-header">
        <h4 class="modal-title">Add New Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="position">Position</label>
              <select class="form-control" name="position" required>
                <option hidden>Select Banner Position</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div class="form-group">
              <label for="link">URL Link</label>
              <input type="text" class="form-control" name="url_link" required>
            </div>
            <div class="form-group">
              <label for="title">Banner Title</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
              <label for="banner">Banner</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="banner" accept="image/*" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose Banner</label>
                </div>

              </div>
            </div>

            <div class="form-group">
              <label for="image_alt">Image Alt</label>
              <input type="text" name="image_alt" class="form-control">
            </div>

            <div class="form-group">
              <label for="tag_line">Tag Line</label>
              <textarea name="tag_line" class="form-control"></textarea>
            </div>

          </div>
          <!-- /.card-body -->

          <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">Add Banner</button>
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
<script type="text/javascript">
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
      url: "{{ route('banner.index') }}",
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