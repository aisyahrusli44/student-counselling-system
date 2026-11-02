
@extends('layouts.app')

@section('title', 'Login | Student Counselling System')

@section('content')
<main class="login-container login-page">

    <!-- LEFT PANEL -->
    <section class="login-welcome-panel">

        <div class="logo">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="UniCare Counselling Appointment System"
                class="landing-logo">

            <h1>Student Counselling</h1>
            <p>APPOINTMENT SYSTEM</p>
        </div>

    </section>
    
    <!-- RIGHT PANEL: EXISTING LOGIN FORM -->
    <section class="login-card">

        <form id="loginForm" method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="login-heading">
                <h2>Log In</h2>
                <p>Enter your credentials to access your account.</p>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" id="rememberMe" name="remember">
                    Remember me
                </label>

                <a href="#" id="forgotPassword">Forgot password?</a>
            </div>

            <button type="submit" class="login-button">
                Sign In
            </button>

            @if ($errors->any())
                <p class="message">{{ $errors->first() }}</p>
            @endif

        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Create an account</a>
        </div>

        <div class="login-footer">
            Student Counselling Appointment System
        </div>

    </section>

</main>
@endsection
