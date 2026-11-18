@extends('layouts.app')

@section('title', 'Register | UniCare Student Counselling')

@section('content')
<div class="auth">

    @include('auth.partials.brand-panel', ['variant' => 'register'])

    <div class="auth-form-col">
        <form id="registerForm" method="POST" action="{{ route('register.store') }}" class="card auth-card">
            @csrf

            <div class="card-header">
                <h1>Create your account</h1>
                <p>Join to access confidential counselling support and services.</p>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-error" role="alert" id="registerMessage">{{ $errors->first() }}</div>
                @endif

                <div class="field-group">
                    <label class="field-label" for="fullName">Full name</label>
                    <div class="input {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                        <input type="text" id="fullName" name="full_name" placeholder="Enter your full name"
                               value="{{ old('full_name') }}" autocomplete="name" required>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="studentId">Student ID</label>
                        <div class="input {{ $errors->has('student_id') ? 'has-error' : '' }}">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="12" r="2.5"/><path d="M14 10h4M14 14h3"/></svg>
                            <input type="text" id="studentId" name="student_id" placeholder="Your student ID"
                                   value="{{ old('student_id') }}" required>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="email">Email address</label>
                        <div class="input {{ $errors->has('email') ? 'has-error' : '' }}">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                            <input type="email" id="email" name="email" placeholder="you@student.edu"
                                   value="{{ old('email') }}" autocomplete="email" required>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <div class="input {{ $errors->has('password') ? 'has-error' : '' }}">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                                                        <input type="password" id="password" name="password" placeholder="Create password"
                                   minlength="6" autocomplete="new-password" required>
                            <button type="button" class="icon-btn" data-toggle-password="password" aria-label="Show password">
                                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="confirmPassword">Confirm password</label>
                        <div class="input">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                                                        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Re-enter password"
                                   minlength="6" autocomplete="new-password" required>
                            <button type="button" class="icon-btn" data-toggle-password="confirmPassword" aria-label="Show password">
                                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <span class="field-hint" style="margin-top: -8px">At least 6 characters.</span>

                <button type="submit" class="btn btn-gold btn-lg btn-block">Create account</button>

                <p class="auth-switch">
                    Already have an account? <a href="{{ route('login') }}">Log in here</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    @include('auth.partials.password-toggle')
@endpush