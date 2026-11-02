
@extends('layouts.app')

@section('title', 'SCA | Student Counselling Appointment System')

@section('content')

{{-- Navigation --}}
<header class="landing-header" id="home">
    <div class="container landing-nav">

        <a href="{{ route('home') }}" class="brand">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Student Counselling Appointment System"
            class="brand-logo"
        >
    </a>

        <nav class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#faq">FAQ</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="landing-actions">
            <a href="{{ route('login') }}" class="login-nav-link">Log in</a>
            <a href="{{ route('login') }}" class="btn btn-gold">
                Book an Appointment
            </a>
        </div>

    </div>
</header>

{{-- Hero --}}
<section class="hero">
    <div class="container hero-content">

        <div class="hero-text" id="about">
            <span class="eyebrow">STUDENT COUNSELLING SERVICES</span>

            <h1>A Safe Space<br>for a Brighter<br>Tomorrow</h1>

            <p>
                Confidential, professional counselling support to help you
                navigate life's challenges with a healthier and happier you.
            </p>

            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn btn-gold">
                    Book an Appointment &rarr;
                </a>

                <a href="#services" class="btn btn-outline">
                    Learn More
                </a>
            </div>
        </div>

        {{-- Counselling room illustration --}}
        <div class="hero-visual" aria-label="Illustration of a welcoming counselling room">

            <div class="illustration-window"></div>

            <div class="illustration-plant">
                <span class="plant-leaf leaf-one"></span>
                <span class="plant-leaf leaf-two"></span>
                <span class="plant-leaf leaf-three"></span>
                <span class="plant-leaf leaf-four"></span>
                <span class="plant-stem"></span>
                <span class="plant-pot"></span>
            </div>

            <div class="illustration-chair">
                <span class="chair-back"></span>
                <span class="chair-seat"></span>
                <span class="chair-leg chair-leg-left"></span>
                <span class="chair-leg chair-leg-right"></span>
            </div>

            <div class="illustration-table">
                <span class="table-top"></span>
                <span class="table-leg"></span>
            </div>

            <div class="illustration-message">
                <span class="message-star">✦</span>
                <p>Listen.<br>Support.<br>Grow.</p>
            </div>

        </div>

    </div>

    {{-- Key benefits --}}
    <div class="container">
        <div class="feature-grid" id="services">

            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    ♧
                </div>

                <div>
                    <h3>Confidential</h3>
                    <p>A safe space to be heard.</p>
                </div>
            </article>

            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    ♧
                </div>

                <div>
                    <h3>Professional Support</h3>
                    <p>Qualified and caring counsellors.</p>
                </div>
            </article>

            <article class="feature-card">
                <div class="feature-icon" aria-hidden="true">
                    ▣
                </div>

                <div>
                    <h3>Flexible Sessions</h3>
                    <p>Appointments at your convenience.</p>
                </div>
            </article>

            <article class="feature-card">
            <div class="feature-icon" aria-hidden="true">
                ✓
            </div>

            <div>
                <h3>Easy Booking</h3>
                <p>Book counselling sessions with ease.</p>
            </div>
        </article>

        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="landing-footer" id="contact">
    <div class="container">
        <p>
            &copy; {{ date('Y') }} Student Counselling Appointment System
        </p>
    </div>
</footer>

@endsection
