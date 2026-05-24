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

            <div class="col-8 offset-md-2">
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
                        <h3 class="card-title">Manage General Setting</h3>
                    </div>
                    <!-- /.card-header -->
                    <form role="form" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Site Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $generalsetting->site_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="logo" accept="image/*" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose Logo</label>
                                    </div>
                                    @if(file_exists('storage/' . $generalsetting->logo) && !empty($generalsetting->logo))
                                    <img loading="lazy" class="general-img" src="{{ url('storage/'.$generalsetting->logo) }}" alt="{{__('banner')}}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="favicon">Favicon</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="favicon" accept="image/*" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose Favicon</label>
                                    </div>
                                    @if(file_exists('storage/' . $generalsetting->favicon) && !empty($generalsetting->favicon))
                                    <img loading="lazy" class="general-img" src="{{ url('storage/'.$generalsetting->favicon) }}" alt="{{__('banner')}}">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="add">Address</label>
                                <textarea name="address" class="form-control" placeholder="Text Here">{{ $generalsetting->address }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="text">Footer Text</label>
                                <textarea name="description" class="form-control" placeholder="Text Here">{{$generalsetting->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="phone">{{__('Phone')}}</label>
                                <input type="text" id="phone" name="phone" value="{{ $generalsetting->phone }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">{{__('Email')}}</label>
                                <input type="text" id="email" name="email" value="{{ $generalsetting->email }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="facebook">{{__('Facebook')}}</label>
                                <input type="text" id="facebook" name="facebook" value="{{ $generalsetting->facebook }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="instagram">{{__('Instagram')}}</label>
                                <input type="text" id="instagram" name="instagram" value="{{ $generalsetting->instagram }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="linkedin">{{__('LinkedIn')}}</label>
                                <input type="text" id="linkedin" name="linkedin" value="{{ $generalsetting->linkedin }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="twitter">{{__('Twitter')}}</label>
                                <input type="text" id="twitter" name="twitter" value="{{ $generalsetting->twitter }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="youtube">{{__('Youtube')}}</label>
                                <input type="text" id="youtube" name="youtube" value="{{ $generalsetting->youtube }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="google_plus">{{__('Google Plus')}}</label>
                                <input type="text" id="google_plus" name="google_plus" value="{{ $generalsetting->google_plus }}" class="form-control">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection

@push('script')
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        // Summernote
        $('#textarea').summernote()
    });
</script>
@endpush