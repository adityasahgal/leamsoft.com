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
            <div class="col-md-8 offset-md-2">
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
                    <h4 class="modal-title">Add New Users</h4>
                    </div>
                    <div class="card-body table-responsive" id="tag_container">
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="card-body">

                                <fieldset>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="role">User Role</label>
                                            <select class="form-control" name="role" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                            @error('name')
                                            <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                            @error('email')
                                            <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" name="designation">
                                            @error('designation')
                                            <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone">Contact No</label>
                                            <input type="number" class="form-control" name="phone">
                                            @error('phone')
                                            <div class="error-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="ipbtn">Add Records</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection

@push('script')

<script type="text/javascript">
    $(document).ready(function() {
        $(".submitBtn").click(function() {
            $(".submitBtn").attr("disabled", true);
            return true;
        });
    });
</script>
@endpush