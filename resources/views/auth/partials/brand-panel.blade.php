{{-- Navy left panel with the centred UniCare logo. $variant: 'login' | 'register' --}}
<section class="auth-brand">
        <a href="{{ route('home') }}" class="auth-back">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/></svg>
        Home
    </a>

    <div class="auth-logo">
        <div class="auth-logo-mark">
                        <img src="{{ asset('images/unicare-symbol.png') }}?v={{ filemtime(public_path('images/unicare-symbol.png')) }}" alt="UniCare logo">
            <span class="wordmark">UniCare</span>
            <span class="auth-logo-title">Student Counselling</span>
            <span class="auth-logo-sub">APPOINTMENT SYSTEM</span>
        </div>

        <span class="auth-divider" aria-hidden="true"></span>

            <p class="auth-tagline">A safe space to talk, be heard and take care of your wellbeing.</p>
    </div>

    <div class="auth-note">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C4A062" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
        Private and confidential
    </div>
</section>