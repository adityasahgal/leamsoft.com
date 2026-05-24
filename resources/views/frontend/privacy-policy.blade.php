<?php
$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Privacy Policy | Karinya Villas - One, Two, and Three-Bedroom Villas in Nainital";
$meta_description = "Read the privacy policy of Karinya Villas to understand how we protect your personal information when booking one, two, or three-bedroom villas in Nainital. Your privacy is our priority.";
$keywords = "Karinya Villas privacy policy, privacy practices, villa booking privacy, one-bedroom villa privacy, two-bedroom villa privacy, three-bedroom villa privacy, data protection, Nainital villa privacy, Karinya Villas policies";
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

    .page-title-row {
        background: url('assets/images/img5.jpg') no-repeat center center;
        background-size: cover;
        padding: 60px 0;
        color: #fff;
    }

    .bg-darkgrey {
        background-color: #333;
    }

    .info-item {
        height: 200px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Initial shadow */
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .info-item:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        /* Shadow on hover */
        transform: translateY(-5px);
        /* Slight lift on hover */
    }

    .text-red {
        color: red;
    }

    .link-unstyled {
        text-decoration: none;
    }

    .icon-style {
        color: red;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 50%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Banner Section -->
<section class="about-banner home-banner">
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Privacy Policy</h1>
</section>


<!-- Main Content Start -->
<div class="site-main py-5">

    <!-- Services Section Start -->
    <section class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="lead text-center">Our values your
                        privacy and is committed to safeguarding the personal information you share with
                        us. This Privacy Policy explains how we collect, use, disclose, and protect your
                        information when you visit our website or use our services.</p>

                    <div class="mb-4">
                        <h4>1. Information We Collect</h4>
                        <p>We may collect personal information about you in the following ways:</p>
                        <ul>
                            <li><strong>Personal Information:</strong> This includes information such as
                                your name, email address, phone number, and other details you provide
                                when filling out forms on our website or contacting us.</li>
                            <li><strong>Automatically Collected Information:</strong> We automatically
                                collect information when you visit our website, such as your IP address,
                                browser type, access times, pages visited, and referring website.</li>
                            <li><strong>Cookies and Tracking Technologies:</strong> We use cookies to
                                enhance user experience, track visitor traffic, and analyze site usage.
                                You can adjust your browser settings to refuse cookies.</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>2. How We Use Your Information</h4>
                        <p>We use the information we collect for the following purposes:</p>
                        <ul>
                            <li>To respond to your inquiries, process requests, and provide customer
                                service.</li>
                            <li>To improve and personalize your experience on our website.</li>
                            <li>To communicate with you about new services, promotions, or updates.</li>
                            <li>For analytics, including monitoring trends and traffic to better
                                understand user behavior.</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>3. Information Sharing and Disclosure</h4>
                        <p>We do not sell, rent, or share your personal information with third parties
                            except in the following circumstances:</p>
                        <ul>
                            <li><strong>With Your Consent:</strong> We may share your information with
                                third parties if you provide explicit consent.</li>
                            <li><strong>Service Providers:</strong> We may employ third-party service
                                providers to assist in operating our website and conducting business
                                operations.</li>
                            <li><strong>Legal Compliance:</strong> We may disclose information if
                                required by law or to protect the rights, property, or safety of our
                                company and others.</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>4. Data Security</h4>
                        <p>We implement security measures to protect your personal information from
                            unauthorized access, alteration, or disclosure. However, no internet-based
                            system can be entirely secure. While we strive to use commercially
                            acceptable methods to protect your personal information, we cannot guarantee
                            its absolute security.</p>
                    </div>

                    <div class="mb-4">
                        <h4>5. Third-Party Links</h4>
                        <p>Our website may contain links to external sites operated by third parties. We
                            are not responsible for the privacy practices or content of these
                            third-party websites. We recommend reviewing the privacy policies of any
                            external websites you visit.</p>
                    </div>

                    <div class="mb-4">
                        <h4>6. Children’s Privacy</h4>
                        <p>Our website and services are not intended for children under the age of 13.
                            We do not knowingly collect personal information from children. If we become
                            aware of any information collected from children, we will take steps to
                            delete it promptly.</p>
                    </div>

                    <div class="mb-4">
                        <h4>7. Changes to This Privacy Policy</h4>
                        <p>We may update this Privacy Policy from time to time. Changes will be posted
                            on this page, and the effective date will be updated. We encourage you to
                            review this Privacy Policy periodically.</p>
                    </div>

                    <div class="mb-4">
                        <div class="more-info reservation-info py-5">
                            <p>If you have any questions about this Privacy Policy or your personal
                                information, please contact us at:</p>
                            <div class="more-info reservation-info py-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 mb-4">
                                            <div class="info-item text-center p-3 border rounded shadow">
                                                <i class="fa fa-phone icon-style fs-3 mb-3"></i>
                                                <h4>Contact Us Now</h4>
                                                <a href="tel:{{ $genSetting['phone'] }}" class="text-red link-unstyled">{{ $genSetting['phone'] }}</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 text-center mb-4">
                                            <div class="info-item">
                                                <i class="fa fa-envelope icon-style fs-3 mb-3"></i>
                                                <h4>Contact Us via Email</h4>
                                                <a href="mailto:{{ $genSetting['email'] }}" class="text-red link-unstyled">{{ $genSetting['email'] }}</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 text-center mb-4">
                                            <div class="info-item">
                                                <i class="fa fa-map-marker icon-style fs-3 mb-3"></i>
                                                <h4>Visit Our Offices</h4>
                                                <a href="#" class="text-red link-unstyled">{{ $genSetting['address'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</div>
</section>
<!-- Services Section End -->

</div>

@endsection