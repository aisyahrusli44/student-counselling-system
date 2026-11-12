@extends('layouts.app')

@section('title', 'Log in | UniCare Student Counselling')

@section('content')
<div class="auth">

    @include('auth.partials.brand-panel', ['variant' => 'login'])

    <div class="auth-form-col">
        <form id="loginForm" method="POST" action="{{ route('login.store') }}" class="card auth-card">
            @csrf

            <div class="card-header">
                <h1>Log in</h1>
                <p>Enter your credentials to access your account.</p>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">{{ $errors->first() }}</div>
                @endif

                <div class="field-group">
                    <label class="field-label" for="email">Email address</label>
                    <div class="input {{ $errors->has('email') ? 'has-error' : '' }}">
                        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        <input type="email" id="email" name="email" placeholder="Enter your email address"
                               value="{{ old('email') }}" autocomplete="email" required autofocus>
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-row">
                        <label class="field-label" for="password">Password</label>
                        <a href="#" id="forgotPassword" class="link">Forgot password?</a>
                    </div>
                    <div class="input">
                        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                               autocomplete="current-password" required>
                        <button type="button" class="icon-btn" data-toggle-password="password" aria-label="Show password">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <label class="check">
                    <input type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>

                <button type="submit" class="btn btn-gold btn-lg btn-block">Log in</button>

                <p class="auth-switch">
                    Don't have an account? <a href="{{ route('register') }}">Register here</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    @include('auth.partials.password-toggle')
@endpush