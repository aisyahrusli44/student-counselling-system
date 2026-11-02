<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Counselling Appointment System</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- NAVIGATION -->
    <header class="landing-header">
        <div class="container">
            <nav class="landing-nav">

                <a href="{{ url('/') }}" class="brand">
                    <span class="brand-icon" aria-hidden="true">✦</span>

                    <span class="brand-text">
                        <strong>Student Counselling</strong>
                        <small>APPOINTMENT SYSTEM</small>
                    </span>
                </a>

                <div class="nav-links">
                    <a href="{{ url('/') }}">Home</a>
                    <a href="#about">About</a>
                    <a href="#services">Services</a>
                    <a href="#faq">FAQ</a>
                    <a href="#contact">Contact</a>
                </div>

                <div class="landing-actions">
                    <a href="{{ url('/login') }}"
                       class="login-nav-link">
                        Log in
                    </a>

                    <a href="{{ url('/login') }}" class="btn">
                        Book an Appointment
                    </a>
                </div>

            </nav>
        </div>
    </header>


    <!-- HERO SECTION -->
    <main>

        <section class="hero" id="about">
            <div class="container">

                <div class="hero-content">

                    <div class="hero-text">

                        <span class="eyebrow">
                            YOUR WELL-BEING MATTERS
                        </span>

                        <h1>
                            A Safe Space for a Brighter Tomorrow
                        </h1>

                        <p>
                            Everyone deserves a safe space to be heard
                            and understood. Our Student Counselling
                            Appointment System helps you take the first
                            step towards emotional well-being through
                            accessible counselling support.
                        </p>

                        <div class="hero-actions">
                            <a href="{{ url('/login') }}"
                               class="btn btn-gold">
                                Book a Session
                            </a>

                            <a href="#services"
                               class="btn btn-outline">
                                Learn More
                            </a>
                        </div>

                    </div>


                    <!-- COUNSELLING ROOM ILLUSTRATION -->
                    <div class="hero-visual"
                         role="img"
                         aria-label="Illustration of a calm counselling room">

                        <div class="illustration-window"></div>

                        <div class="illustration-chair">
                            <div class="chair-back"></div>
                            <div class="chair-seat"></div>
                            <div class="chair-leg chair-leg-left"></div>
                            <div class="chair-leg chair-leg-right"></div>
                        </div>

                        <div class="illustration-table">
                            <div class="table-top"></div>
                            <div class="table-leg"></div>
                        </div>

                        <div class="illustration-plant">
                            <div class="plant-stem"></div>
                            <div class="plant-leaf leaf-one"></div>
                            <div class="plant-leaf leaf-two"></div>
                            <div class="plant-leaf leaf-three"></div>
                            <div class="plant-leaf leaf-four"></div>
                            <div class="plant-pot"></div>
                        </div>

                        <div class="illustration-message">
                            <span class="message-star"
                                  aria-hidden="true">✦</span>

                            <p>
                                Listen.<br>
                                Support.<br>
                                Grow.
                            </p>
                        </div>

                    </div>

                </div>


                <!-- BENEFITS -->
                <div class="feature-grid"
                     id="services">

                    <article class="feature-card">
                        <div class="feature-icon"
                             aria-hidden="true">♡</div>

                        <div>
                            <h3>Confidential</h3>
                            <p>
                                A safe and respectful space to share
                                your concerns.
                            </p>
                        </div>
                    </article>


                    <article class="feature-card">
                        <div class="feature-icon"
                             aria-hidden="true">✧</div>

                        <div>
                            <h3>Professional Support</h3>
                            <p>
                                Access counselling support to help
                                navigate life's challenges.
                            </p>
                        </div>
                    </article>


                    <article class="feature-card">
                        <div class="feature-icon"
                             aria-hidden="true">◷</div>

                        <div>
                            <h3>Flexible Sessions</h3>
                            <p>
                                Request an appointment at a time
                                that suits your needs.
                            </p>
                        </div>
                    </article>

                </div>

            </div>
        </section>

    </main>


    <!-- FOOTER -->
    <footer class="landing-footer" id="contact">
        <div class="container">
            <p>
                &copy; {{ date('Y') }}
                Student Counselling Appointment System.
                All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>