<?php

use function Termwind\style;

$genSetting = \App\Models\Setting::first();
?>
@extends('layouts.master')
@php
$meta_title = "Terms and Conditions | Karinya Villas - One, Two, and Three-Bedroom Villas in Nainital";
$meta_description = "Read the terms and conditions of Karinya Villas for booking one, two, or three-bedroom villas in Nainital. Understand the policies and guidelines for a smooth and hassle-free stay.";
$keywords = "Karinya Villas terms and conditions, villa booking policies, one-bedroom villa terms, two-bedroom villa terms, three-bedroom villa terms, Nainital villa booking conditions, villa stay guidelines, Karinya Villas rules";
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
    <h1 style=" font-size: 32px; color: #fff; text-shadow: 2px 2px black; font-weight: 700;">Terms and Conditions</h1>
</section>


<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-black text-white">
            <h1 class="h3">Terms and Conditions</h1>
        </div>
        <div class="card-body">
            <section class="mb-4">
                <h2 class="h4">Welcome to Karinya Villas!</h2>
                <p>These Terms and Conditions outline the rules and regulations for the use of our website. By accessing or using this site, you accept these terms in full. If you disagree with any part of these terms, please refrain from using the site.</p>
            </section>

            <section class="mb-4">
                <h2 class="h4">Eligibility to Use the Site</h2>
                <h3 class="h5">Legally Binding Contracts</h3>
                <ul>
                    <li>You are of legal age to enter into binding contracts.</li>
                    <li>You accept responsibility for any liability arising from your use of this site.</li>
                    <li>You are legally authorized to make travel reservations and/or purchases for yourself or for another person on whose behalf you are authorized to act.</li>
                </ul>
                <h3 class="h5">Prohibited Users</h3>
                <p>The services of this site are not available to minors or individuals who are otherwise legally prohibited from using our services.</p>
            </section>

            <section class="mb-4">
                <h2 class="h4">Permitted Uses</h2>
                <h3 class="h5">Legitimate Transactions</h3>
                <ul>
                    <li>You may use this site only to make legitimate reservations or purchases.</li>
                    <li>Speculative, false, or fraudulent reservations or reservations made in anticipation of demand are strictly prohibited.</li>
                </ul>
                <h3 class="h5">Personal Use Only</h3>
                <p>This site is for personal, non-commercial use unless prior written consent is obtained. Unauthorized commercial use of this site is strictly prohibited.</p>
            </section>

            <section class="mb-4">
                <h2 class="h4">Prohibited Activities</h2>
                <ul>
                    <li><strong>Engage in Unlawful Behavior:</strong> Sending chain letters, junk mail, or engaging in 'spamming.' Distributing bulk communications of any kind without specific permission.</li>
                    <li><strong>Unauthorized Linking:</strong> Creating hypertext links to this site from websites you control or otherwise, without obtaining prior written permission.</li>
                </ul>
            </section>

            <section class="mb-4">
                <h2 class="h4">Acceptance of Terms</h2>
                <p>By accessing, using, viewing, transmitting, caching, or storing this site or any of its services, functions, or content, you agree to abide by all terms, conditions, and notices provided herein without modification. If you do not agree to these terms, you are advised to immediately cease using the site.</p>
            </section>

            <section class="mb-4">
                <h2 class="h4">Modifications to Terms</h2>
                <p>We reserve the right to revise these Terms and Conditions at any time without prior notice. By continuing to use the site, you agree to be bound by the updated terms.</p>
            </section>

            <section>
                <h2 class="h4">Contact Us</h2>
                <p>For more details, please contact us at <a href="tel:{{ $genSetting['phone'] }}">+91 {{ $genSetting['phone'] }}</a>.</p>
            </section>
        </div>
    </div>
</div>

@endsection