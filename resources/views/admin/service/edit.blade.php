@extends('layouts.admin')
@push('style')
<link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
<style>
    .img-upload-preview {
        border: 2px dashed #ddd;
        height: 200px;
        border-radius: 3px;
        cursor: pointer;
        text-align: center;
        overflow: hidden;
        padding: 5px;
        margin-top: 5px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        margin: auto;
        justify-content: center;
        position: relative;
        margin-bottom: 20px;
    }

    .img-upload-preview .close-btn {
        right: 3px;
        top: 3px;
        background: rgb(237, 60, 32);
        border-radius: 3px;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        text-decoration: none;
        color: rgb(255, 255, 255);
        position: absolute;
        padding: 0;
    }
</style>
@endpush

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->

        <div class="row">

            <div class="col-md-12">
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
                        <h4 class="modal-title">Update Property</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive" id="tag_container">
                        <!-- form start -->
                        <form role="form" action="{{ route('service.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ Crypt::encrypt($product->id) }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">{{__('Thumbnail Image')}} </label>
                                    <div class="col-lg-10">
                                        <div class="row" id="thumbnail_img">

                                            @if ($product->thumbnail_img != null)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy" src="{{ asset('storage/'.$product->thumbnail_img) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_thumbnail_img" value="{{ $product->thumbnail_img }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 control-label">{{__('Main Images')}}</label>
                                    <div class="col-lg-10">
                                        <div class="row" id="photos">
                                            @if(is_array(json_decode($product->photos)))
                                            @foreach (json_decode($product->photos) as $key => $photo)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="img-upload-preview">
                                                    <img loading="lazy" src="{{ asset('storage/'.$photo) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="mrp_price">M.R.P. Price</label>
                                        <input type="number" class="form-control" name="mrp_price" value="{{ $product->mrp_price }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="discount">Discount ( % )</label>
                                        <input type="number" class="form-control" name="discount" value="{{ $product->discount }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gst">GST ( % )</label>
                                        <input type="number" class="form-control" name="gst" value="{{ $product->gst }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tax">Tax ( % )</label>
                                        <input type="number" class="form-control" name="tax" value="{{ $product->tax }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="short_description">Short Description</label>
                                        <textarea class="form-control" name="short_description">{{ $product->short_description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea id="textarea" name="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $product->description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control" name="slug" value="{{ $product->slug }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="image_alt">Image Alt</label>
                                        <input type="text" class="form-control" name="image_alt" value="{{ $product->image_alt }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="h1_tag">H1 Tag</label>
                                        <input type="text" class="form-control" name="h1_tag" value="{{ $product->h1_tag }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control" name="meta_description">{{ $product->meta_description }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="keywords">Keywords</label>
                                        <textarea class="form-control" name="keywords">{{ $product->keywords }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Update Records</button>
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
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ url('admin/js/multi-image-picker-min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#photos").spartanMultiImagePicker({
            fieldName: 'photos[]',
            maxCount: 10,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
            maxFileSize: '',
            dropFileLabel: "Drop Here",
            onExtensionErr: function(index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function(index, file) {
                console.log(index, file, 'file size too big');
                alert('File size too big');
            }
        });
        $("#thumbnail_img").spartanMultiImagePicker({
            fieldName: 'thumbnail_img',
            maxCount: 1,
            rowHeight: '200px',
            groupClassName: 'col-md-4 col-sm-4 col-xs-6',
            maxFileSize: '',
            dropFileLabel: "Drop Here",
            onExtensionErr: function(index, file) {
                console.log(index, file, 'extension err');
                alert('Please only input png or jpg type file')
            },
            onSizeErr: function(index, file) {
                console.log(index, file, 'file size too big');
                alert('File size too big');
            }
        });


        $('.remove-files').on('click', function() {
            $(this).parents(".col-md-4").remove();
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        // Summernote
        $('#textarea').summernote()
    });

    $(document).ready(function() {
        $(".submitBtn").click(function() {
            $(".submitBtn").attr("disabled", true);
            return true;
        });
    });
</script>

@endpush