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
                                        <div class="input-group input-group-sm" style="margin-top: 0px; margin-right:5px;">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark" style="height: 31px;">
                                                    Status
                                                </button>
                                            </div>
                                            <select name="status" id="status" class="form-control float-right" onchange="filterData()">
                                                <option value="">All</option>
                                                <option value="1">Active</option>
                                                <option value="0">De-active</option>
                                            </select>
                                        </div>
                                    </li>
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

                                    @can('service-create')
                                    <li class="ml-5">
                                        <div class="input-group-append">
                                            <a href="{{ route('service.create') }}">
                                                <button type="submit" class="btn btn-primary" style="height: 31px;padding: 3px 10px;">
                                                    <b>Add Property</b>
                                                </button>
                                            </a>
                                        </div>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive" id="tag_container">
                        @include('admin.service.dataTable')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->



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
        $("li.select2-selection__choice").remove();
        $("#search").val('');
        filterData();
    }

    function filterData() {
        var search = $("#search").val();
        var records = $("#records").val();
        var status = $("#status").val();

        $.ajax({
            type: "GET",
            url: "{{ route('service.index') }}",
            data: {
                'search': search,
                'records': records,
                'status': status,
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
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                'search': search,
                'records': records,
                'status': status,
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
</script>
@endpush