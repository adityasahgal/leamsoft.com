<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Responsive Gallery | Karinya Villas - One, Two, and Three-Bedroom Villas in Nainital";
$meta_description = "Explore the responsive gallery of Karinya Villas, showcasing our luxurious one, two, and three-bedroom villas in Nainital. View stunning images of the villas, interiors, and breathtaking landscapes that make your stay unforgettable.";
$keywords = "Karinya Villas gallery, responsive gallery, one-bedroom villa images, two-bedroom villa gallery, three-bedroom villa photos, Nainital villa images, luxury villa photos, hill station villa gallery, Karinya Villas Nainital";

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

    @media (max-width: 768px) {
        .about-banner h1 {
            font-size: 2rem;
        }
    }

    @keyframes zoomin {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .gallery-item {
        display: block;
    }

    .gallery-item img {
        height: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.2s;
        border-radius: 5px;
    }

    .gallery-item:hover img {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .lightbox-modal .modal-content {
        background-color: var(--lightbox);
    }

    .lightbox-modal .btn-close {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        font-size: 1.25rem;
        z-index: 10;
        filter: invert(1) grayscale(100);
    }

    .lightbox-modal .modal-body {
        display: flex;
        align-items: center;
        padding: 0;
    }

    .lightbox-modal .lightbox-content {
        width: 100%;
    }

    .lightbox-modal .carousel-indicators {
        margin-bottom: 0;
    }

    .lightbox-modal .carousel-indicators [data-bs-target] {
        background-color: var(--carousel-text) !important;
    }

    .lightbox-modal .carousel-inner {
        width: 75%;
    }

    .lightbox-modal .carousel-inner img {
        animation: zoomin 10s linear infinite;
        /* height: 80%; */
        border-radius: 5px;
    }

    .lightbox-modal .carousel-item .carousel-caption {
        right: 0;
        bottom: 0;
        left: 0;
        padding-bottom: 2rem;
        background-color: var(--lightbox);
        color: var(--carousel-text) !important;
    }

    .lightbox-modal .carousel-control-prev,
    .lightbox-modal .carousel-control-next {
        width: auto;
    }

    .lightbox-modal .carousel-control-prev {
        left: 1.25rem;
    }

    .lightbox-modal .carousel-control-next {
        right: 1.25rem;
    }

    @media (min-width: 1400px) {
        .lightbox-modal .carousel-inner {
            max-width: 60%;
        }
    }

    [data-bs-theme="dark"] .lightbox-modal .carousel-control-next-icon,
    [data-bs-theme="dark"] .lightbox-modal .carousel-control-prev-icon {
        filter: none;
    }

    .btn-fullscreen-enlarge,
    .btn-fullscreen-exit {
        position: absolute;
        top: 1.5rem;
        right: 3.5rem;
        z-index: 10;
        border: 0;
        background: transparent;
        opacity: .6;
        font-size: 1.25rem;
    }

    .bi {
        display: inline-block;
        width: 1em;
        height: 1em;
        vertical-align: -0.035em;
        fill: #fff !important;
    }
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Gallery</h1>
</section>



<svg class="d-none" xmlns="http://www.w3.org/2000/svg">
    <symbol id="enlarge" viewBox="0 0 16 16">
        <path
            d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1h-4zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zM.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5z" />
    </symbol>
    <symbol id="exit" viewBox="0 0 16 16">
        <path
            d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5zM0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zm10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z" />
    </symbol>
</svg>


<section class="photo-gallery py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 gallery-grid">
            @foreach(\App\Models\Gallery::where('status', 1)->orderBy('created_at', 'desc')->get() as $key => $photo)
            <div class="col">
                <a class="gallery-item" href="{{ url('storage/'.$photo->photo) }}">
                    <img src="{{ url('storage/'.$photo->photo) }}" class="img-fluid"
                        style="font-size: 32px; color: #fff !important; text-shadow: 2px 2px black; font-weight: 700;" alt="{{ $photo->name }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <button type="button" class="btn-fullscreen-enlarge" aria-label="Enlarge fullscreen">
                <svg class="bi">
                    <use href="#enlarge"></use>
                </svg>
            </button>
            <button type="button" class="btn-fullscreen-exit d-none" aria-label="Exit fullscreen">
                <svg class="bi">
                    <use href="#exit"></use>
                </svg>
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="lightbox-content">
                    <!-- JS content here -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

<script>
    const html = document.querySelector('html');
    html.setAttribute('data-bs-theme', 'dark');

    document.addEventListener('DOMContentLoaded', () => {
        // --- Create LightBox
        const galleryGrid = document.querySelector(".gallery-grid");
        const links = galleryGrid.querySelectorAll("a");
        const imgs = galleryGrid.querySelectorAll("img");
        const lightboxModal = document.getElementById("lightbox-modal");
        const bsModal = new bootstrap.Modal(lightboxModal);
        const modalBody = lightboxModal.querySelector(".lightbox-content");

        function createCaption(caption) {
            return `<div class="carousel-caption d-none d-md-block">
        <h4 class="m-0">${caption}</h4>
      </div>`;
        }

        function createIndicators(img) {
            let markup = "",
                i, len;

            const countSlides = links.length;
            const parentCol = img.closest('.col');
            const curIndex = [...parentCol.parentElement.children].indexOf(parentCol);

            for (i = 0, len = countSlides; i < len; i++) {
                markup += `
        <button type="button" data-bs-target="#lightboxCarousel"
          data-bs-slide-to="${i}"
          ${i === curIndex ? 'class="active" aria-current="true"' : ''}
          aria-label="Slide ${i + 1}">
        </button>`;
            }

            return markup;
        }

        function createSlides(img) {
            let markup = "";
            const currentImgSrc = img.closest('.gallery-item').getAttribute("href");

            for (const img of imgs) {
                const imgSrc = img.closest('.gallery-item').getAttribute("href");
                const imgAlt = img.getAttribute("alt");

                markup += `
        <div class="carousel-item${currentImgSrc === imgSrc ? " active" : ""}">
          <img class="d-block img-fluid w-100" src=${imgSrc} alt="${imgAlt}">
          ${imgAlt ? createCaption(imgAlt) : ""}
        </div>`;
            }

            return markup;
        }

        function createCarousel(img) {
            const markup = `
      <!-- Lightbox Carousel -->
      <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
          ${createIndicators(img)}
        </div>
        <!-- Wrapper for Slides -->
        <div class="carousel-inner justify-content-center mx-auto">
          ${createSlides(img)}
        </div>
        <!-- Controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      `;

            modalBody.innerHTML = markup;
            const lightboxCarousel = document.getElementById("lightboxCarousel");
            new bootstrap.Carousel(lightboxCarousel); // Initialize the carousel
        }

        for (const link of links) {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const currentImg = link.querySelector("img");
                const lightboxCarousel = document.getElementById("lightboxCarousel");

                if (lightboxCarousel) {
                    const parentCol = link.closest('.col');
                    const index = [...parentCol.parentElement.children].indexOf(parentCol);

                    const bsCarousel = new bootstrap.Carousel(lightboxCarousel);
                    bsCarousel.to(index);
                } else {
                    createCarousel(currentImg);
                }

                bsModal.show();
            });
        }

        // --- Support Fullscreen
        const fsEnlarge = document.querySelector(".btn-fullscreen-enlarge");
        const fsExit = document.querySelector(".btn-fullscreen-exit");

        function enterFS() {
            lightboxModal.requestFullscreen().then({}).catch(err => {
                alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
            });
            fsEnlarge.classList.toggle("d-none");
            fsExit.classList.toggle("d-none");
        }

        function exitFS() {
            document.exitFullscreen();
            fsExit.classList.toggle("d-none");
            fsEnlarge.classList.toggle("d-none");
        }

        fsEnlarge.addEventListener("click", (e) => {
            e.preventDefault();
            enterFS();
        });

        fsExit.addEventListener("click", (e) => {
            e.preventDefault();
            exitFS();
        });
    })
</script>

@endsection