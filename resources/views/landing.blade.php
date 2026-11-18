@extends('layouts.app')

@section('title', 'UniCare | Student Counselling Appointment System')

@section('content')

{{-- Navigation --}}
<header class="site-header">
    <div class="container site-nav">
        <a href="#home" class="site-brand">
                       <img src="{{ asset('images/unicare-logo.png') }}?v={{ filemtime(public_path('images/unicare-logo.png')) }}" alt="">
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

{{-- HOME --}}
<section class="hero land-sec" id="home">
    <div class="container hero-inner">
        <div class="hero-copy">
            <span class="eyebrow">STUDENT COUNSELLING SERVICES</span>
            <h1 class="hero-title">A safe space for a brighter tomorrow</h1>
            <p class="hero-lead">
                <strong>Confidential, professional counselling</strong> to help you navigate life's
                challenges and look after your wellbeing.
            </p>
            <div class="hero-cta">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                    Book an appointment
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a href="#about" class="btn btn-outline btn-lg">Learn more</a>
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

{{-- ABOUT --}}
<section class="land-sec" id="about">
    <div class="container section">
        <div class="about-grid">
            <div class="about-copy">
                <span class="eyebrow">ABOUT US</span>
                <h2 class="section-title">About UniCare</h2>
                <p class="about-lead">
                    UniCare is the university's <strong>online counselling appointment system</strong>.
                    It lets students request a session with the counselling office without queues,
                    phone calls or paperwork.
                </p>
                <p class="about-lead">
                    Every request is reviewed by the <strong>counselling team</strong>, and you can follow
                    its status (pending, approved or rejected) from your own dashboard.
                </p>
                <ul class="about-points">
                    <li><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A6A2E" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg><span><strong>Private</strong> — only you and the counselling office see your requests</span></li>
                    <li><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A6A2E" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg><span><strong>Simple</strong> — book in a few clicks, on any device</span></li>
                    <li><svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A6A2E" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg><span><strong>Free</strong> — for all enrolled students</span></li>
                </ul>
            </div>

            <div class="about-card">
                <h3>What we can help with</h3>
                <div class="about-topics">
                    <div><strong>Academic Issues</strong><span>Exams, workload, grades</span></div>
                    <div><strong>Personal Issues</strong><span>Relationships, wellbeing</span></div>
                    <div><strong>Career Guidance</strong><span>Future plans, decisions</span></div>
                    <div><strong>Family Issues</strong><span>Home and family matters</span></div>
                </div>
                <p>Something else on your mind? Choose <strong>Other</strong> and tell us in your own words.</p>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="section-alt land-sec" id="services">
    <div class="container section">
        <div class="section-head">
            <span class="eyebrow">SERVICES</span>
            <h2 class="section-title">Support designed around you</h2>
            <p class="section-lead">Whatever you're going through, our counsellors are here to help you find a way forward.</p>
        </div>

        <div class="features">
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></div>
                <h3>Confidential</h3>
                <p>A safe space to be heard. What you share is handled with <strong>care and respect</strong>.</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg></div>
                <h3>Professional support</h3>
                <p><strong>Qualified counsellors</strong> for academic, personal and career concerns.</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></div>
                <h3>Flexible sessions</h3>
                <p>Choose a <strong>date and time</strong> that fits around your classes.</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
                <h3>Easy booking</h3>
                <p>Request a session online and <strong>track its status</strong> from your dashboard.</p>
            </article>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="land-sec" id="how">
    <div class="container section">
        <div class="section-head">
            <span class="eyebrow">HOW IT WORKS</span>
            <h2 class="section-title">Three simple steps</h2>
            <p class="section-lead">From sign-up to your first session in just a few minutes.</p>
        </div>
        <div class="steps">
            <div class="card step">
                <span class="step-num">1</span>
                <div><h3>Create your account</h3><p>Register with your <strong>student ID and email</strong>.</p></div>
            </div>
            <div class="card step">
                <span class="step-num">2</span>
                <div><h3>Request a session</h3><p>Pick a <strong>purpose, date and time</strong> that suits you.</p></div>
            </div>
            <div class="card step">
                <span class="step-num">3</span>
                <div><h3>Get confirmation</h3><p>The counselling office <strong>reviews and approves</strong> your request.</p></div>
            </div>
        </div>
        <div style="display: flex; justify-content: center">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                Get started
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section class="hero land-sec" id="contact">
    <div class="container section">
        <div class="section-head">
            <span class="eyebrow">CONTACT</span>
            <h2 class="section-title">Get in touch</h2>
            <p class="section-lead">Have a question before booking? Reach the <strong>counselling office</strong> any of these ways.</p>
        </div>

        {{-- TODO: replace the [ ... ] placeholders with your real details --}}
        <div class="contact-grid">
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></div>
                <h3>Email</h3>
                <p><strong>[COUNSELLING EMAIL]</strong><br>Replies within 1 working day</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></div>
                <h3>Phone</h3>
                <p><strong>[OFFICE PHONE]</strong><br>During office hours</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></div>
                <h3>Visit us</h3>
                <p><strong>[COUNSELLING CENTRE]</strong><br>[BUILDING, CAMPUS]</p>
            </article>
            <article class="card feature">
                <div class="feature-icon"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
                <h3>Office hours</h3>
                <p><strong>Mon – Fri</strong><br>[8:30 AM – 5:00 PM]</p>
            </article>
        </div>

        <div class="cta-band">
            <div>
                <h2>Ready to talk to someone?</h2>
                <p>Taking the first step is often the hardest. We're here when you're ready.</p>
            </div>
            <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Create an account</a>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="site-footer">
    <div class="container">
        <span>&copy; {{ date('Y') }} UniCare Student Counselling Appointment System</span>
        <span>Private and confidential</span>
    </div>
</footer>

@endsection

@push('scripts')
<script>
    // Keep each section exactly one screen tall below the sticky menu bar.
    (function () {
        var header = document.querySelector('.site-header');
        function setHeaderHeight() {
            document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
        }
        setHeaderHeight();
        window.addEventListener('resize', setHeaderHeight);
    })();
</script>
@endpush