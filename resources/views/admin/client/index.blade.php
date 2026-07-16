@extends('layouts.admin')
@push('style')

@endpush
@section('content')
<!-- Main content -->
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
            <h3 class="card-title">Manage Clients</h3>

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
                @can('client-create')
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#addModel">Add Client</button>
                @endcan
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive" id="tag_container">
            @include('admin.client.dataTable')
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<!-- .modal -->
<div class="modal fade" id="addModel">
  <div class="modal-dialog modal-default">
    <div class="modal-content card-primary card-outline">
      <div class="modal-header">
        <h4 class="modal-title">Add New Client</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Client Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
              <label for="designation">Designation</label>
              <input type="text" class="form-control" name="designation" placeholder="e.g. CEO, Founder">
            </div>
            <div class="form-group">
              <label for="company">Company</label>
              <input type="text" class="form-control" name="company">
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" name="website" placeholder="https://example.com">
            </div>
            <div class="form-group">
              <label for="logo">Logo / Photo</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="logo" accept="image/*" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose Logo</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="image_alt">Image Alt</label>
              <input type="text" name="image_alt" class="form-control">
            </div>
            <div class="form-group">
              <label for="testimonial">Testimonial</label>
              <textarea name="testimonial" class="form-control" placeholder="What the client said about you"></textarea>
            </div>
            <div class="form-group">
              <label for="sort_order">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="addFeatured" name="featured" value="1">
                <label class="custom-control-label" for="addFeatured">Featured</label>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary">Add Client</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
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
      url: "{{ route('client.index') }}",
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
