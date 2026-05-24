@extends('layouts.master')
@php
$meta_title = "Explore Nearby Places in Nainital";
$meta_description = "Discover the best nearby places in Nainital, including Neem Karoli Baba Ashram and CAMP KURIA. Experience spirituality, adventure, and natural beauty.";
$keywords = "Neem Karoli Baba Ashram, CAMP KURIA Nainital, nearby places in Nainital, travel Nainital";
@endphp
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta_keywords'){{ $keywords }}@stop
@section('content')

<style>
    .about-banner {
        background: url('assets/image/kk.jpg') center center / cover no-repeat;
        height: 400px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
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

        .about-banner {
            height: 300px;
        }
    }
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1>Explore Nearby Places</h1>
</section>

<!-- Mission Statement -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="assets/image/Coming.jpg" alt="Nainital" class="img-fluid rounded-3">
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">Why Visit Nainital?</h2>
                <p class="lead">Nainital, the picturesque hill station in Uttarakhand, is known for its serene lakes, lush greenery, and spiritual retreats. Whether you're seeking adventure or peace, Nainital has something for everyone.</p>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="value-counter">100+</div>
                            <p>Years of History</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-box">
                            <div class="value-counter">50+</div>
                            <p>Tourist Attractions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<!-- <section class="timeline-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6 fw-bold" style="color: #002142;">Our Journey Through Nainital</h2>
                <p class="lead">Milestones that define our commitment to showcasing the best of Nainital</p>
            </div>
        </div>

        <div class="timeline position-relative">
            <div class="timeline-line position-absolute top-0 bottom-0 start-50 translate-middle-x bg-primary d-none d-md-block" style="width: 4px;"></div>
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0" style="color: #002142;">Neem Karoli Baba Ashram</h5>
                                <span class="badge bg-primary">Spiritual Retreat</span>
                            </div>
                            <p class="card-text">A peaceful sanctuary dedicated to Neem Karoli Baba, offering a spiritual escape amidst the natural beauty of Nainital.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2" style="color: #002142;"></i>Located in Nainital, Uttarakhand</li>
                                <li><i class="fas fa-heart me-2" style="color: #002142;"></i>Perfect for meditation and self-discovery</li>
                                <li><i class="fas fa-users me-2" style="color: #002142;"></i>Welcomes visitors from all walks of life</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div> 
            </div>

            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div> 
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0" style="color: #28a745;">CAMP KURIA Nainital</h5>
                                <span class="badge bg-success">Adventure</span>
                            </div>
                            <p class="card-text">A thrilling camping experience near Nainital, offering adventure activities and a chance to connect with nature.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2" style="color: #28a745;"></i>Located near Nainital, Uttarakhand</li>
                                <li><i class="fas fa-hiking me-2" style="color: #28a745;"></i>Trekking and outdoor adventures</li>
                                <li><i class="fas fa-fire me-2" style="color: #28a745;"></i>Bonfire and stargazing under the open sky</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0" style="color: #002142;">Naini Lake</h5>
                                <span class="badge bg-info">Natural Beauty</span>
                            </div>
                            <p class="card-text">A serene freshwater lake in the heart of Nainital, offering boating and breathtaking views of the surrounding hills.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2" style="color: #002142;"></i>Located in the center of Nainital</li>
                                <li><i class="fas fa-water me-2" style="color: #002142;"></i>Perfect for boating and photography</li>
                                <li><i class="fas fa-tree me-2" style="color: #002142;"></i>Surrounded by lush greenery</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div> 
            </div>

            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div> 
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0" style="color: #dc3545;">Tiffin Top</h5>
                                <span class="badge bg-danger">Scenic Viewpoint</span>
                            </div>
                            <p class="card-text">A popular viewpoint offering panoramic views of Nainital and the surrounding Himalayan ranges.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2" style="color: #dc3545;"></i>Located on Ayarpatta Hill</li>
                                <li><i class="fas fa-mountain me-2" style="color: #dc3545;"></i>Ideal for photography and nature walks</li>
                                <li><i class="fas fa-binoculars me-2" style="color: #dc3545;"></i>Perfect for a peaceful retreat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0" style="color: #6f42c1;">Snow View Point</h5>
                                <span class="badge bg-danger">Snowy Peaks</span>
                            </div>
                            <p class="card-text">A famous viewpoint offering stunning views of the snow-clad Himalayan peaks.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2" style="color: #6f42c1;"></i>Located at an altitude of 2,270 meters</li>
                                <li><i class="fas fa-snowflake me-2" style="color: #6f42c1;"></i>Perfect for snow lovers</li>
                                <li><i class="fas fa-camera me-2" style="color: #6f42c1;"></i>Ideal for photography</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
            </div>
        </div>
    </div>
</section> -->

<!-- Timeline Section -->
<section class="timeline-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6 fw-bold" style="color: #002142;">Our Journey Through Nainital</h2>
                <p class="lead">Milestones that define our commitment to showcasing the best of Nainital</p>
            </div>
        </div>

        <div class="timeline position-relative">
            <div class="timeline-line position-absolute top-0 bottom-0 start-50 translate-middle-x bg-primary d-none d-md-block" style="width: 4px;"></div>

            <!-- Neem Karoli Baba Ashram -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #002142;">Neem Karoli Baba Ashram</h5>
                            <span class="badge bg-primary">Spiritual Retreat</span>
                            <p>A peaceful sanctuary dedicated to Neem Karoli Baba.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
            </div>

            <!-- Naina Devi Temple (New Spiritual Retreat) -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div>
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #002142;">Naina Devi Temple</h5>
                            <span class="badge bg-primary">Spiritual Retreat</span>
                            <p>A revered Hindu temple dedicated to Goddess Naina Devi, located on the banks of Naini Lake.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CAMP KURIA -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #28a745;">CAMP KURIA Nainital</h5>
                            <span class="badge bg-success">Adventure</span>
                            <p>A thrilling camping experience near Nainital.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
            </div>

            <!-- Paragliding (New Adventure) -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div>
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #28a745;">Paragliding in Nainital</h5>
                            <span class="badge bg-success">Adventure</span>
                            <p>Experience the thrill of flying over the beautiful landscapes of Nainital.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jim Corbett National Park (New Adventure) -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #28a745;">Jim Corbett National Park</h5>
                            <span class="badge bg-success">Adventure</span>
                            <p>India’s oldest national park, home to tigers and diverse wildlife.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
            </div>

            <!-- Naini Lake -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div>
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #002142;">Naini Lake</h5>
                            <span class="badge bg-info">Natural Beauty</span>
                            <p>A serene freshwater lake in the heart of Nainital.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tiffin Top -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #dc3545;">Tiffin Top</h5>
                            <span class="badge bg-danger">Scenic Viewpoint</span>
                            <p>A popular viewpoint offering panoramic views of Nainital.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block"></div>
            </div>

            <!-- Snow View Point -->
            <div class="timeline-item row g-0 position-relative mb-4">
                <div class="col-md-6 d-none d-md-block"></div>
                <div class="col-md-6">
                    <div class="timeline-content card shadow-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #6f42c1;">Snow View Point</h5>
                            <span class="badge bg-danger">Snowy Peaks</span>
                            <p>A famous viewpoint offering stunning views of the snow-clad Himalayan peaks.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Meet Our Team -->
<!-- <section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6 fw-bold" style="color: #002142;">Meet Our Guides</h2>
                <p class="lead">Our expert guides ensure you have the best experience</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="team-card">
                    <img src="assets/image/testimonial-3.jpg" class="img-fluid imagess mb-3" alt="Guide 1">
                    <h4>Rajesh Kumar</h4>
                    <p class="text-muted">Spiritual Guide</p>
                    <p>10+ years of experience</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="team-card">
                    <img src="assets/image/testimonial-1.jpg" class="img-fluid imagess mb-3" alt="Guide 2">
                    <h4>Anita Sharma</h4>
                    <p class="text-muted">Adventure Guide</p>
                    <p>Expert in trekking and camping</p>
                </div>
            </div>
            
        </div>
    </div>
</section> -->

@endsection