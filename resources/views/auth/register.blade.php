@extends('layouts.app')

@section('title', 'Register | Student Counselling System')

@section('content')

<main class="login-container register-page">

    <!-- LEFT PANEL -->
    <section class="login-welcome-panel">

        <div class="logo">
            <img src="{{ asset('images/logo.png') }}"
                alt="UniCare Counselling Appointment System"
                class="landing-logo">

            <h1>Student Counselling</h1>
            <p>APPOINTMENT SYSTEM</p>
        </div>

    </section>

    <!-- RIGHT PANEL: REGISTRATION FORM -->
    <section class="login-card">

        <form id="registerForm" method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="register-heading">
                <h2>Create Your Account</h2>
                <p>Join us to access confidential counselling support and services.</p>
            </div>

            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input
                    type="text"
                    id="fullName"
                    name="full_name"
                    placeholder="Enter your full name"
                    value="{{ old('full_name') }}"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="studentId">Student ID</label>
                <input
                    type="text"
                    id="studentId"
                    name="student_id"
                    placeholder="Enter your student ID"
                    value="{{ old('student_id') }}"
                    required
                >
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
                    placeholder="Create a password"
                    minlength="6"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input
                    type="password"
                    id="confirmPassword"
                    name="password_confirmation"
                    placeholder="Re-enter your password"
                    minlength="6"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Create Account
            </button>

            @if ($errors->any())
                <p id="registerMessage" class="message">
                    {{ $errors->first() }}
                </p>
            @else
                <p id="registerMessage" class="message"></p>
            @endif

        </form>

        <div class="register-link">
            Already have an account?
            <a href="{{ route('login') }}">Sign in</a>
        </div>

        <div class="login-footer">
            Student Counselling Appointment System
        </div>

    </section>
</main>

@endsection