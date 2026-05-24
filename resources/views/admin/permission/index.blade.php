@extends('layouts.admin')
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
              <h3 class="card-title">Manage Permission</h3>

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
                  @can('permission-create')
                  <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#addModel">Add Permission</button>
                  @endcan
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive" id="tag_container">
              @include('admin.permission.dataTable')
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
        <h4 class="modal-title">Add New Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('permission.store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Permission Name</label>
              <input type="text" class="form-control" name="name" value="{{ old('name') }}">
              @error('name')
              <div class="error-text">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Add Records</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
      url: "{{ route('permission.index') }}",
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
@endsection