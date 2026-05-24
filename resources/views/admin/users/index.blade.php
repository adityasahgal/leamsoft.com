@extends('layouts.admin')
@push('style')
<link rel="stylesheet" href="{{asset('admin/css/user.css')}}">
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
              <div class="row card-tools" style="width: 100%;">
                <div class="col-md-2 input-group input-group-sm" style="margin-left: -17px;">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default" style="height: 31px;">
                      Records
                    </button>
                  </div>
                  <select class="form-control float-right page-box" id="records" onchange="filterData()">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                  </select>
                </div>

                <div class="col-md-10">
                  <ul class="nav nav-pills nav-right" style="margin-right: 45px;">
                    <li>
                      <div class="input-group input-group-sm" style="margin-top: 0px; margin-left:2px;">
                        <input type="text" name="search" id="search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default" style="height: 31px;" onclick="filterData()">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </li>

                    <li class="ml-5">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" style="height: 31px;padding: 3px 10px;" onclick="downloadCsvData()">
                          <b>Export</b> <i class="fas fa-arrow-down"></i>
                        </button>
                      </div>
                    </li>
                    @can('user-create')
                    <li class="ml-5">
                      <div class="input-group-append">
                        <a href="{{ route('users.create') }}">
                          <button type="submit" class="btn btn-primary" style="height: 31px;padding: 3px 10px;">
                            <b>Add User</b>
                          </button>
                        </a>
                      </div>
                    </li>
                    @endcan

                  </ul>
                  <button type="button" class="btn btn-default btn-ftr" data-toggle="modal" data-target="#ftrModel"><b>Filter</b> <i class="fas fa-filter"></i></button>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive" id="tag_container">
              @include('admin.users.dataTable')
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->



      <!-- .modal -->
      <div class="ftr-modal modal fade" id="ftrModel">
        <div class="modal-dialog modal-default">
          <div class="modal-content card-primary card-outline">
            <form id="filterForm">
              <div class="modal-header" style="background: #e2e4e5;">
                <h4 class="modal-title">Filter By</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearFilter()">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>
              <div class="modal-body scroll" style="background: #efefef;">
                <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">
                      <label for="status">
                        Status
                      </label>
                      <select class="form-control" name="status" id="status">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">De-active</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="role">
                        User Role
                      </label>
                      <select multiple class="form-control select2" name="role" id="role">
                        @foreach(Spatie\Permission\Models\Role::get() as $row)
                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-12 text-center">
                    <button type="button" class="btn btn-danger" onclick="clearFilter()">Reset</button>
                    <button type="button" class="btn btn-primary" onclick="filterData()">Submit</button>
                  </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal" id="spinnerModal">
        <div class="modal-dialog spinner-model modal-lg">

          <div class="text-center">
            <div class="lds-spinner">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

@endsection

@push('script')

<script type="text/javascript">
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });



  function clearFilter() {
    document.getElementById("filterForm").reset();
    $('#status > option').prop("selected", false);
    $('#role > option').prop("selected", false);
    $("li.select2-selection__choice").remove();
    $("#search").val('');
    filterData();
  }

  function filterData() {
    var search = $("#search").val();
    var records = $("#records").val();
    var status = $("#status").val();
    var role = $("#role").val();

    $.ajax({
      type: "GET",
      url: "{{ route('users.index') }}",
      data: {
        'search': search,
        'records': records,
        'status': status,
        'role': role
      },
      beforeSend: function() {
        $("#spinnerModal").show();
      },
      success: function(data) {
        $('#tag_container').html(data);
      },
      complete: function(data) {
        $("#spinnerModal").hide();
        $("#ftrModel").hide();
      },
      error: function(err) {
        console.log("No response from server");
      }
    });
  }

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
    var search = $("#search").val();
    var records = $("#records").val();
    var status = $("#status").val();
    var role = $("#role").val();
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        'search': search,
        'records': records,
        'status': status,
        'role': role
      },
      beforeSend: function() {
        $("#spinnerModal").show();
      },
      success: function(data) {
        $('#tag_container').html(data);
      },
      complete: function(data) {
        $("#spinnerModal").hide();
        $("#ftrModel").hide();
      },
      error: function(err) {
        console.log("No response from server");
      }
    });
  }

  function downloadCsvData() {
    var search = $("#search").val();
    var status = $("#status").val();
    var role = $("#role").val();
    window.open("{{ url('admin/users/userExports?search=') }}" + search + '&status=' + status + '&role=' + role);
  }
</script>
@endpush