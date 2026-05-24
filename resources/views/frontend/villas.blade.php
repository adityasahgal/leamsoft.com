@extends('layouts.master')



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
        transform: translateY(-5px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
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
        transform: translateY(-5px);
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
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Luxury Villas</h1>
    <!-- <p class="text-center ">
        
    </p> -->
</section>


<!-- Room Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-color text-uppercase">Our Villas</h6>
            <h1 class="mb-5">Explore Our <span class="text-color text-uppercase">Villas</span></h1>
        </div>
        <div class="row g-4">
            @foreach(\App\Models\Service::where('status',1)->get() as $key => $row)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="{{ url('storage/'.$row->thumbnail_img) }}" style="height:295px !important;" width="100%" alt="{{ $row->image_alt }}">
                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0">{{ $row->name }}</h5>
                        </div>
                        <div class="d-flex mb-3">
                            <small class="border-end me-3 pe-3"><i class="fas fa-house-user text-color me-2"></i>Room service</small>
                            <small><i class="fa fa-wifi text-color me-2"></i> Free Wifi</small>
                        </div>
                        <div class="d-flex mb-3">
                            <small class="border-end me-3 pe-3"><i class="fas fa-users text-color me-2"></i>Family Room</small>
                            <small><i class="fas fa-smoking-ban text-color me-2"></i> Non-smoking rooms</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="{{ url($row->slug) }}">View Detail</a>
                            <a class="btn btn-sm btn-dark rounded py-2 px-4" href="{{ config('app.book_now_url') }}" target="_blank">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Room End -->

<!-- <section class="promotion-banner mt-5">
    <div class="container custom-gutter-x p-0 shadow-lg rounded-3">
        <div id="carouselPromotion" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner rounded-3">
                <div class="carousel-item">
                    <img rel="preload"
                        src="{{ url('assets/img/IMG-20241116-WA0079.jpg') }}"
                        class="d-block w-100 rounded-3" alt="Promotional_Banner_1">
                    <div class="carousel-caption d-flex flex-column align-items-center mb-3">
                        <h2 class="text-white">Escape to Luxury Amidst Nature</h2>
                        <p class="text-white">Experience serene stays in our exclusive villas in Nainital, designed for ultimate comfort and relaxation.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img loading="lazy"
                        src="{{ url('assets/img/IMG-20241116-WA0080.jpg') }}"
                        class="d-block w-100 rounded-3" alt="Promotional_Banner_Second">
                    <div class="carousel-caption d-flex flex-column align-items-center mb-3">
                        <h2 class="text-white">Your Perfect Getaway Awaits</h2>
                        <p class="text-white">Choose from one, two, or three-bedroom villas with modern amenities and breathtaking views. </p>
                       </div>
                </div>
                <div class="carousel-item active">
                    <img loading="lazy"
                        src="{{ url('assets/img/IMG-20241116-WA0032.jpg') }}"
                        class="d-block w-100 rounded-3" alt="Promotional_Banner_Third">
                    <div class="carousel-caption d-flex flex-column align-items-center mb-3">
                        <h2 class="text-white">Charm of Karinya Villas</h2>
                        <p class="text-white">Where elegance meets tranquility – make unforgettable memories in the heart of Nainital. </p>
                       </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromotion"
                data-bs-slide="prev" fdprocessedid="o2w7rf">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPromotion"
                data-bs-slide="next" fdprocessedid="4s2t9">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section> -->






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