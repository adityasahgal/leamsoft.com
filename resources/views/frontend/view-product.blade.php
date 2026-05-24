<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')

@section('meta_title'){{ $productrow->meta_title }}@stop

@section('meta_description'){{ $productrow->meta_description }}@stop

@section('meta_keywords'){{ $productrow->keywords }}@stop

@section('content')

<style>
    .section-heading {
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .facilities-flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        /* Adds space between columns */
    }

    .facility-section {
        flex: 1;
        min-width: 300px;
        /* Ensures the columns don't shrink too much */
        margin-bottom: 30px;
    }

    .facility-section h3 {
        margin-bottom: 10px;
    }

    .area-info-col {
        margin-bottom: 20px;
    }

    .about-banner {
        background: url('<?php echo url('assets/image/kk.jpg'); ?>') center center / cover no-repeat;
        height: 400px;
        object-fit: fill;
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

    .amenities-list li {
        list-style: none;
        margin-bottom: 10px;
    }

    .amenities-list li::before {
        content: "✔️ ";
        color: green;
        margin-right: 10px;
    }
</style>
<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">{{ $productrow->name }}</h1>
</section>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">
        <!-- Property Images -->
        <div class="col-lg-6">
            <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img rel="preload" src="{{ url('storage/' . $productrow->thumbnail_img) }}" class="d-block " style="height: 400px; width: 700px;"
                            alt="{{ $productrow->image_alt }}">
                    </div>
                    @foreach (json_decode($productrow->photos) as $photo)
                    <div class="carousel-item">
                        <img loading="lazy" src="{{ url('storage/' . $photo) }}" class="d-block" style="height: 400px; width: 700px;"
                            alt="{{ $productrow->imgage_alt }}">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Property Details -->
        <div class="col-lg-6">
            <!-- <ul class="list-unstyled">
                <li><strong>Price:</strong> ₹{{ $productrow->price }} / Night</li>
            </ul> -->
            <!-- Detailed Description -->
            <div class="row mt-2">
                <div class="col-12">
                    <h3>Description</h3>
                    <div style="text-align: justify;">{!! $productrow->description !!}</div>
                </div>
            </div>
            <a href="{{ config('app.book_now_url') }}" target="_blank"><button class="btn btn-danger mt-2">Book Now</button></a>
        </div>
    </div>




</div>

<section class="text-muted body-font border-top border-gray-200 py-5">
    <div class="container py-5">
        <div class="text-center w-100 mb-5">
            <h1 class="display-6 fw-medium mb-3 text-dark">Facilities & Amenities</h1>
            <p class="lead mx-auto" style="max-width: 700px;">
                Experience luxury and comfort at Karinya Villas. We offer world-class facilities and amenities to ensure a memorable stay.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/nearby.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">What's Nearby</h5>
                        <!-- <p class="text-muted mb-0">UI Designer</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/food.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Restaurants & Cafes</h5>
                        <!-- <p class="text-muted mb-0">CTO</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/flite2.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Closest Airports</h5>
                        <!-- <p class="text-muted mb-0">Founder</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/parking.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Parking</h5>
                        <!-- <p class="text-muted mb-0">DevOps</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/wifi.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Internet</h5>
                        <!-- <p class="text-muted mb-0">Software Engineer</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/kitchen.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Kitchen</h5>
                        <!-- <p class="text-muted mb-0">UX Researcher</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/bathroom.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Bathroom</h5>
                        <!-- <p class="text-muted mb-0">QA Engineer</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/media.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Media & Technology</h5>
                        <!-- <p class="text-muted mb-0">System</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/room.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Room Amenities</h5>
                        <!-- <p class="text-muted mb-0">Product Manager</p> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center border border-gray-200 p-3 rounded shadow-sm">
                    <img alt="team" class="rounded-circle flex-shrink-0 me-3"
                        src="{{ url('assets/image/room.jpg') }}" width="50" height="50">
                    <div>
                        <h5 class="text-dark fw-medium mb-1">Living Area</h5>
                        <!-- <p class="text-muted mb-0">Product Manager</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection