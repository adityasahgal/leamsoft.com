<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "FAQs | Karinya Villas - One, Two, and Three-Bedroom Villas in Nainital";
$meta_description = "Find answers to frequently asked questions about Karinya Villas, including details about our one, two, and three-bedroom villas in Nainital, booking policies, amenities, and more.";
$keywords = "Karinya Villas FAQ, one-bedroom villa FAQs, two-bedroom villa FAQs, three-bedroom villa questions, Nainital villa booking FAQs, luxury villa questions, Karinya Villas policies, villa amenities, booking process";
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
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Frequently Asked Questions</h1>
</section>

<div class="container my-5">
    <!-- Header Section -->
    <header class="text-center mb-5">
        <h1 class="display-5 " style=" font-size: 32px;">Your questions about Karinya Villas answered</h1>
        <!-- <p class="text-muted">Your questions about Karinya Villas answered</p> -->
    </header>

    <!-- FAQ Section -->
    <div class="accordion" id="faqAccordion">
        <!-- FAQ 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    What amenities are available at Karinya Villas?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Karinya Villas offers luxurious amenities such as private pools, fitness centers, landscaped gardens, 24/7 security, and high-speed internet.
                </div>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Are Karinya Villas pet-friendly?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Yes, Karinya Villas is pet-friendly. However, we request all pet owners to adhere to the guidelines provided for the comfort of all residents.
                </div>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    What is the rental policy for Karinya Villas?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Rentals are available for both short-term and long-term stays. A security deposit and agreement are required for all rentals.
                </div>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    How can I book a villa at Karinya Villas?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Booking a villa is simple! Visit our website, fill out the booking form, or contact us directly for personalized assistance.
                </div>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    Is there 24/7 customer support available?
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Yes, our customer support team is available 24/7 to assist with any inquiries or concerns.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection