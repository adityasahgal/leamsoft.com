<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')

@section('meta_title'){{ $blogDetail->meta_title }}@stop

@section('meta_description'){{ $blogDetail->meta_description }}@stop

@section('meta_keywords'){{ $blogDetail->keywords }}@stop

@section('content')
<style>
    .about-banner {
        background: url('<?php echo url('assets/image/kk.jpg'); ?>') center center / cover no-repeat;
        height: 400px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .about-banner h1 {
        font-size: 3rem;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .about-banner h1 {
            font-size: 2rem;
        }
    }
</style>
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">{{ $blogDetail->name }}</h1>
</section>


<div class="site-main">
    <div class="container py-5">
        <div class="row">
            <!-- Blog Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <img src="{{ url('storage/'.$blogDetail->banner) }}" class="card-img-top rounded" alt="{{ $blogDetail->image_alt }}">
                    <div class="card-body">
                        <h1 class="card-title mb-3">{{ $blogDetail->name }}</h1>
                        <div class="d-flex align-items-center text-muted mb-3">
                            <i class="fa fa-calendar me-2"></i>
                            <time datetime="{{ $blogDetail->created_at }}">{{ $blogDetail->created_at }}</time>
                        </div>
                        <p class="card-text">{{ $blogDetail->short_description }}</p>
                        <div>{!! $blogDetail->description !!}</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach(\App\Models\Category::where('status',1)->get() as $category)
                        <li class="list-group-item">
                            <a href="{{ url($category->slug) }}" class="text-decoration-none text-dark">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Posts Widget -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Recent Posts</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach (\App\Models\Blog::orderBy('id','DESC')->where('status', 1)->limit(3)->get() as $blog)
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ url('storage/'.$blog->banner) }}" class="img-fluid rounded me-3" alt="{{ $blog->image_alt }}" style="width: 50px; height: 50px;">
                            <div>
                                <a href="{{ url('blog/'.$blog->slug) }}" class="text-decoration-none text-dark">{{ $blog->name }}</a>
                                <div class="small text-muted">{{ $blog->created_at }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Widget -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Get in Touch</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                {{ $genSetting['address'] }}
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                {{ $genSetting['email'] }}
                            </li>
                            <li class="mb-2">
                                <i class="fa fa-phone text-primary me-2"></i>
                                {{ $genSetting['phone'] }}
                            </li>
                            <li>
                                <i class="fa fa-clock text-primary me-2"></i>
                                Mon to Fri - 9:00am to 6:00pm
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection