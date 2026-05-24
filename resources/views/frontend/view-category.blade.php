@extends('layouts.master')

@section('meta_title'){{ $categories->meta_title }}@stop

@section('meta_description'){{ $categories->meta_description }}@stop

@section('meta_keywords'){{ $categories->keywords }}@stop

@section('content')

<style>
    .about-banner {
        background: url('<?php echo url('assets/image/room-1.jpg'); ?>') center center / cover no-repeat;
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
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Luxury {{ $categories->name }}</h1>
    <!-- <p class="text-center ">
        {{ $categories->short_description }}
    </p> -->
</section>




<div class="container-xxl py-5 px-0 wow zoomIn" data-wow-delay="0.1s">

    <div class="row g-0 ">
        <div class="col-md-6" style="border-radius: 10px 0px 0px 10px;">
            <div class="video">
                <img src="{{ url('storage/'.$categories->banner) }}" alt="{{ $categories->image_alt }}" class="img-fluid mx-auto d-block"
                    style=" border-radius: 10px 0px 0px 10px; height: 100%;">
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center"
            style="background: #0f172b; border-radius: 0px 10px 10px 0px;">
            <div class="p-5">
                <h6 class="section-title text-start text-white text-uppercase mb-3">Luxury Living</h6>
                <h1 class="text-white mb-4">Reserve Your Luxurious Stay at Karinya Villas Today</h1>
                <div class="text-white mb-4">{!! $categories->description !!} </div>
                <!-- <a href="" class="btn btn-primary py-md-3 px-md-5 me-3">Our Rooms</a> -->
                <a href="{{ config('app.book_now_url') }}" target="_blank" class="btn btn-primary py-md-3 px-md-5">Book A Room</a>
            </div>
        </div>
    </div>
</div>

<!-- Room Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-color text-uppercase">Our {{ $categories->name }}</h6>
            <h1 class="mb-5">Explore Our <span class="text-color text-uppercase">{{ $categories->name }}</span></h1>
        </div>
        <div class="row g-4">
            @foreach(\App\Models\Subcategory::with('categories')->where('status',1)->where('cid',$categories->id)->get() as $key => $row)

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{ url('storage/'.$row->banner) }}" style="height:295px !important;" width="100%" alt="{{ $row->image_alt }}">
                        <a href="{{ url($row->categories->slug.'/'.$row->slug) }}">
                            <small class="position-absolute top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-30" style="left: 32%; bottom:-20%; transform: translateX(-50%);">
                                {{ $row->name }}
                            </small>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>





<!-- Services Section -->
<section class="container my-5">
    <h2 class="text-center mb-4" style="font-size: 32px; font-weight: 700;">Our Services</h2>
    <div class="row">
        <div class="col-md-4 service-box text-center">
            <i class="fas fa-bed"></i>
            <h5>Luxury Accommodations</h5>
            <p>Experience the comfort of our well-furnished rooms and suites, designed to offer a relaxing and luxurious stay.</p>
        </div>
        <div class="col-md-4 service-box text-center">
            <i class="fas fa-utensils"></i>
            <h5>Dining Options</h5>
            <p>Savor delicious meals at our in-house restaurant, offering a variety of cuisines to delight your taste buds.</p>
        </div>
        <div class="col-md-4 service-box text-center">
            <i class="fas fa-concierge-bell"></i>
            <h5>24/7 Concierge Service</h5>
            <p>Our dedicated staff is available round-the-clock to assist you with any requests or services you may need during your stay.</p>
        </div>
    </div>
</section>

<!-- Our Work Section -->
<section class="container my-5">
    <h2 class="text-center mb-4" style="font-size: 32px; font-weight: 700;">Our Offerings</h2>
    <div class="row">
        <div class="col-md-4 work-box text-center service-box p-4 border rounded">
            <h5>Elegant Rooms</h5>
            <p>Each room at Karinya Villas is thoughtfully designed to provide modern amenities, comfort, and a serene environment.</p>
        </div>
        <div class="col-md-4 work-box text-center service-box p-4 border rounded">
            <h5>Event Hosting</h5>
            <p>From intimate gatherings to large-scale celebrations, our event spaces and planning services cater to all occasions.</p>
        </div>
        <div class="col-md-4 work-box text-center service-box p-4 border rounded">
            <h5>Guest Experiences</h5>
            <p>Our guests consistently praise our exceptional hospitality, cleanliness, and the personalized attention they receive.</p>
        </div>
    </div>
</section>



@endsection