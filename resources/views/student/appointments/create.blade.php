
@extends('layouts.app')

@section('title', 'New Appointment')

@section('content')

<div class="dashboard-layout">

    <!-- Sidebar -->
    <aside class="dashboard-sidebar">

        <div class="dashboard-logo">
            <span>✦</span> SCA
        </div>

        <nav class="dashboard-nav">

            <a href="{{ route('student.dashboard') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                    <rect x="13" y="3" width="8" height="8" rx="1"/>
                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                    <rect x="13" y="13" width="8" height="8" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('student.appointments.index') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                <span>My Appointments</span>
            </a>

            <a href="{{ route('student.appointments.create') }}" class="active">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18M12 13v5M9.5 15.5h5"/>
                </svg>
                <span>New Appointment</span>
            </a>

            <a href="#">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
                </svg>
                <span>Profile</span>
            </a>

            <a href="#">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M9.6 9a2.5 2.5 0 1 1 4.5 1.5c-1.3 1.2-2.1 1.5-2.1 3"/>
                    <path d="M12 17.5v.1"/>
                </svg>
                <span>Help &amp; Support</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dashboard-logout">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 17l5-5-5-5M15 12H3"/>
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>

        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">

        <header class="dashboard-header">
            <div>
                <h1>New Appointment</h1>
                <p>Fill in the details to request a counselling appointment.</p>
            </div>

            <div class="dashboard-user">
                <span>{{ now()->timezone('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>

                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <section class="my-appointments-card">

            <div class="section-heading">
                <h2>Appointment Details</h2>
            </div>

            <form method="POST" action="{{ route('student.appointments.store') }}">
                @csrf

                <div class="appointment-form-group">
                    <label for="preferred_date">Preferred Date</label>
                    <input
                        type="date"
                        id="preferred_date"
                        name="preferred_date"
                        value="{{ old('preferred_date') }}"
                        min="{{ now()->timezone('Asia/Kuala_Lumpur')->format('Y-m-d') }}"
                        required
                    >
                    @error('preferred_date')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="appointment-form-group">
                    <label for="preferred_time">Preferred Time</label>
                    <input
                        type="time"
                        id="preferred_time"
                        name="preferred_time"
                        value="{{ old('preferred_time') }}"
                        required
                    >
                    @error('preferred_time')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="appointment-form-group">
                    <label for="purpose">Appointment Purpose</label>

                    <select id="purpose" name="purpose" required>
                        <option value="">Select a purpose</option>
                        <option value="Academic Issues" {{ old('purpose') == 'Academic Issues' ? 'selected' : '' }}>Academic Issues</option>
                        <option value="Personal Issues" {{ old('purpose') == 'Personal Issues' ? 'selected' : '' }}>Personal Issues</option>
                        <option value="Career Guidance" {{ old('purpose') == 'Career Guidance' ? 'selected' : '' }}>Career Guidance</option>
                        <option value="Family Issues" {{ old('purpose') == 'Family Issues' ? 'selected' : '' }}>Family Issues</option>
                        <option value="Other" {{ old('purpose') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <div id="other-purpose-field" class="appointment-form-group" style="display: none;">
                        <label for="other_purpose">Please Specify Your Purpose</label>

                        <input
                            type="text"
                            id="other_purpose"
                            name="other_purpose"
                            value="{{ old('other_purpose') }}"
                            placeholder="Enter your counselling purpose"
                            maxlength="255"
                        >

                        @error('other_purpose')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    @error('purpose')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="appointment-form-actions">
                    <a href="{{ route('student.appointments.index') }}" class="btn-outline">
                        Cancel
                    </a>

                    <button type="submit" class="btn-gold">
                        Submit Appointment
                    </button>
                </div>

            </form>

        </section>

    </main>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purposeSelect = document.getElementById('purpose');
        const otherPurposeField = document.getElementById('other-purpose-field');
        const otherPurposeInput = document.getElementById('other_purpose');

        function toggleOtherPurpose() {
            if (purposeSelect.value === 'Other') {
                otherPurposeField.style.display = 'block';
                otherPurposeInput.required = true;
            } else {
                otherPurposeField.style.display = 'none';
                otherPurposeInput.required = false;
                otherPurposeInput.value = '';
            }
        }

        purposeSelect.addEventListener('change', toggleOtherPurpose);

        // Check the selected value when the page loads.
        toggleOtherPurpose();
    });
</script>
@endsection
