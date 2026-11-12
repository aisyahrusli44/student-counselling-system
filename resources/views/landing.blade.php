@extends('layouts.app')

@section('title', 'UniCare | Student Counselling Appointment System')

@section('content')

{{-- Navigation --}}
<header class="site-header" id="home">
    <div class="container site-nav">
        <a href="{{ route('home') }}" class="site-brand">
            <img src="{{ asset('images/unicare-logo.png') }}" alt="">
            <span>
                <span class="site-brand-name">UniCare</span>
                <span class="site-brand-sub">Student Counselling</span>
            </span>
        </a>

        <nav class="site-links" aria-label="Main">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#how">How it works</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="site-actions">
            @auth
                <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'student.dashboard') }}" class="btn btn-gold">Go to dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Log in</a>
                <a href="{{ route('login') }}" class="btn btn-gold">Book an appointment</a>
            @endauth
        </div>
    </div>
</header>

{{-- Hero --}}
<section class="hero" id="about">
    <div class="container hero-inner">
        <div class="hero-copy">
            <span class="eyebrow">STUDENT COUNSELLING SERVICES</span>
            <h1 class="hero-title">A safe space for a brighter tomorrow</h1>
            <p class="hero-lead">
                Confidential, professional counselling support to help you navigate life's
                challenges and look after your wellbeing.
            </p>
            <div class="hero-cta">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    Book an appointment
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a href="#services" class="btn btn-outline btn-lg">Learn more</a>
            </div>
            <div class="hero-checks">
                <span><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A6A2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>Confidential</span>
                <span><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A6A2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>Book online in minutes</span>
            </div>
        </div>

        {{-- Counselling room illustration --}}
        <div class="hero-art" role="img" aria-label="Illustration of a welcoming counselling room">
            <span class="art-window"></span>
            <span class="art-floor"></span>
            <span class="art-chair-back"></span>
            <span class="art-chair-seat"></span>
            <span class="art-leg-l"></span>
            <span class="art-leg-r"></span>
            <span class="art-pot"></span>
            <span class="art-leaf-1"></span>
            <span class="art-leaf-2"></span>
            <span class="art-leaf-3"></span>
            <div class="art-note">
                <div class="art-note-icon">
                    <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.8 0-3 .5-4.5 2-1.5-1.5-2.7-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4 3 5.5l7 7z"/></svg>
                </div>
                <p>Listen.<br>Support.<br>Grow.</p>
            </div>
        </div>
    </div>
</section>

{{-- Services --}}
<section class="container section" id="services">
    <div class="section-head">
        <h2 class="section-title">Support designed around you</h2>
        <p class="section-lead">Whatever you're going through, our counsellors are here to help you find a way forward.</p>
    </div>

    <div class="features">
        <article class="card feature">
            <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></div>
            <h3>Confidential</h3>
            <p>A safe space to be heard. What you share is handled with care and respect.</p>
        </article>
        <article class="card feature">
            <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg></div>
            <h3>Professional support</h3>
            <p>Qualified and caring counsellors for academic, personal and career concerns.</p>
        </article>
        <article class="card feature">
            <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></div>
            <h3>Flexible sessions</h3>
            <p>Choose a date and time that fits around your classes.</p>
        </article>
        <article class="card feature">
            <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
            <h3>Easy booking</h3>
            <p>Request a session online and track its status from your dashboard.</p>
        </article>
    </div>
</section>

{{-- How it works --}}
<section class="section-alt" id="how">
    <div class="container section">
        <h2 class="section-title" style="text-align: center">How it works</h2>
        <div class="steps">
            <div class="step">
                <span class="step-num">1</span>
                <div><h3>Create your account</h3><p>Register with your student ID and email.</p></div>
            </div>
            <div class="step">
                <span class="step-num">2</span>
                <div><h3>Request a session</h3><p>Pick a purpose, a date and a time that suits you.</p></div>
            </div>
            <div class="step">
                <span class="step-num">3</span>
                <div><h3>Get confirmation</h3><p>The counselling office reviews and approves your request.</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Call to action --}}
<section class="container section">
    <div class="cta-band">
        <div>
            <h2>Ready to talk to someone?</h2>
            <p>Taking the first step is often the hardest. We're here when you're ready.</p>
        </div>
        <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Create an account</a>
    </div>
</section>

{{-- Footer --}}
<footer class="site-footer" id="contact">
    <div class="container">
        <span>&copy; {{ date('Y') }} UniCare Student Counselling Appointment System</span>
        <span>[COUNSELLING CENTRE EMAIL] · [PHONE NUMBER]</span>
    </div>
</footer>

@endsection