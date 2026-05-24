<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Explore Luxurious Villas in Nainital | Karinya Villas Latest Blogs";
$meta_description = "Stay updated with the latest blogs from Karinya Villas. Discover insights, travel tips, and the luxury of one, two, and three-bedroom villas in Nainital.";
$keywords = "Karinya Villas blog, luxury villas Nainital, latest villa updates, Nainital travel tips, one-bedroom villa, two-bedroom villa, three-bedroom villa, luxury stay, Nainital retreat, Karinya Villas updates";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta_keywords'){{ $keywords }}@stop
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

    /* Centering the image inside the card */
    .image-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px;

    }

    .card-img-top {
        width: 90%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-box {
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-box i {
        font-size: 3rem;
        color: #b10a0a;
    }


    .service-box h5 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 10px;
    }

    .service-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .about-banner h1 {
            font-size: 2rem;
        }

        .team-member img {
            width: 120px;
            height: 120px;
        }

        .service-box i {
            font-size: 2rem;
        }
    }

    .value-card {
        transition: all 0.3s ease-in-out;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .shadow-sm {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Team Member Card Styles */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-description {
        color: #555;
    }

    /* Styling for the "Read More" button */
    .btn-link {
        font-weight: bold;
        transition: color 0.2s ease;
    }

    .text-set:hover {
        color: #b10a3a;
        /* Change color on hover */
        /* text-decoration: underline; */
    }

    .text-set {
        color: #b10a0a;
    }

    .text-justify {
        text-align: justify;
    }
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Our Blogs</h1>
</section>

<!-- About Section -->
<!-- <section class="container my-5">
    <h2 class="text-center mb-4" style=" font-size: 32px; font-weight: 700;">Welcome to Karinya Villas</h2>
    <p class="text-center ">
        Welcome to Karinya Villas, Nainital's top choice for luxury stays. Enjoy elegant villas, modern amenities, and stunning views for an unforgettable experience. Perfect for getaways and retreats!
    </p>
</section> -->

<!-- Blog Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-color text-uppercase">Our Blogs</h6>
            <h1 class="mb-5">Explore Our <span class="text-color text-uppercase">Blogs</span></h1>
        </div>
        <div class="row g-4">

            @foreach (\App\Models\Blog::orderBy('id','DESC')->where('status', 1)->get() as $key => $row)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{ url('storage/'.$row->banner) }}" alt="{{ $row->image_alt }}">

                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0" style="font-weight: bold !important;">{{ $row->name }}</h5>

                        </div>

                        <p class="text-body mb-3">{{ $row->short_description }}</p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="{{ url('blog/'.$row->slug) }}">Read More</a>
                            <!-- <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Book Now</a> -->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!-- <div class="row g-4 mt-2">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{url('assets/image/room-3.jpg') }}" alt="">
                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0">Junior Suite</h5>
                        </div>

                        <p class="text-body mb-3">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem
                            sed diam stet diam sed stet lorem.</p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="#">View Detail</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{url('assets/image/room-1.jpg') }}" alt="">

                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0">Executive Suite</h5>

                        </div>

                        <p class="text-body mb-3">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem
                            sed diam stet diam sed stet lorem.</p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="#">View Detail</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{url('assets/image/room-2.jpg') }}" alt="">

                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0">Super Deluxe</h5>

                        </div>

                        <p class="text-body mb-3">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem
                            sed diam stet diam sed stet lorem.</p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">View Detail</a>
                            <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection