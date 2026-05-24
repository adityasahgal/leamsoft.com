<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Help | Karinya Villas - One, Two, and Three-Bedroom Villas in Nainital";
$meta_description = "Get assistance and support for your stay at Karinya Villas. Find helpful information about booking one, two, or three-bedroom villas in Nainital, along with our services and amenities.";
$keywords = "Karinya Villas help, one-bedroom villa support, two-bedroom villa assistance, three-bedroom villa help, Nainital villa booking support, Karinya Villas services, villa amenities help, Nainital travel assistance, booking inquiries";
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

    .hero-section {
        background: #6c757d;
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .hero-section p {
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .faq-section .accordion-button {
        font-weight: bold;
        color: #6c757d;
    }

    .faq-section .accordion-item {
        border: none;
        border-bottom: 1px solid #e9ecef;
    }

    .contact-section {
        background-color: #f8f9fa;
        padding: 50px 0;
    }

    .contact-section h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .contact-section p {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .contact-form {
        padding: 30px;
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .section-content {
        margin-bottom: 2rem;
    }

    .contact-info {
        font-size: 1.2rem;
    }

    .list-group-item {
        font-size: 1.1rem;
    }

    .section-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 1.5rem;
    }
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Help & Support</h1>
</section>




<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2>Need More Help?</h2>
                <p>If you have further questions or require assistance with your booking, our team is here to help.
                    Get in touch with us through the contact details below.</p>
                <p><strong>Email:</strong href="tel:{{ $genSetting['email'] }}">{{ $genSetting['email'] }}</p>
                <p><strong>Phone:</strong href="tel:{{ $genSetting['phone'] }}">+91 {{ $genSetting['phone'] }}</p>

            </div>
            <div class="col-lg-6">
                <div class="contact-form">
                    <h4>Contact Us</h4>
                    <form action="{{ url('/enquiry') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5"
                                    placeholder="Your Message"></textarea>
                                @error('message')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="recaptcha" id="recaptcha">
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                    @error('recaptcha')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection