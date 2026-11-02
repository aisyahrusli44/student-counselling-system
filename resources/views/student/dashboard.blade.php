
@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="dashboard-layout">

    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        
        <div class="dashboard-logo">
            <img src="{{ asset('images/logo.png') }}"
                alt="SCA Logo"
                class="dashboard-logo-img">
        </div>
        
        <nav class="dashboard-nav">
            <a href="#" class="active">
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

            <a href="{{ route('student.appointments.create') }}">
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

           
            <!-- Logout Button -->
            <button
                type="button"
                class="dashboard-logout"
                onclick="document.getElementById('student-logout-dialog').showModal()">

                <svg viewBox="0 0 24 24" width="16" height="16"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 17l5-5-5-5M15 12H3"/>
                    <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                </svg>

                <span>Logout</span>
            </button>

            <!-- Logout Confirmation Modal -->
            <dialog id="student-logout-dialog" class="reject-dialog">

                <h2>Logout Confirmation</h2>

                <p>Are you sure you want to logout from your account?</p>

                <div class="appointment-form-actions">

                    <button
                        type="button"
                        class="btn-outline"
                        onclick="document.getElementById('student-logout-dialog').close()">
                        Cancel
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="btn-reject">
                            Confirm Logout
                        </button>
                    </form>

                </div>
            </dialog>

        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">

        <!-- Header -->
        <header class="dashboard-header">
            <div>
                <h1>Welcome, {{ Auth::user()->name }}!</h1>
                <p>Here's your next counselling session and a quick way to book more support.</p>
            </div>

            <div class="dashboard-user">
                <span>{{ now()->timezone('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Next Appointment -->
        <section class="next-appointment-card">
            <div class="section-heading">
                <h2>Next Appointment</h2>

                @if ($nextAppointment)
                    <span class="status approved">Approved</span>
                @else
                    <span class="status pending">No Upcoming Appointment</span>
                @endif
            </div>

            @if ($nextAppointment)
                <div class="appointment-detail">
                    <p>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        &nbsp; {{ \Carbon\Carbon::parse($nextAppointment->preferred_date)->format('l, d F Y') }}
                    </p>

                    <small>
                        {{ \Carbon\Carbon::parse($nextAppointment->preferred_time)->format('h:i A') }}
                    </small>

                    <p>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6M8 13h8M8 17h8"/>
                        </svg>
                        &nbsp; {{ $nextAppointment->purpose }}
                    </p>

                    <small>Counselling support session</small>
                </div>
            @else
                <p>No approved upcoming appointments.</p>
            @endif
        </section>

        <!-- My Appointments -->
        <section class="my-appointments-card">
            <div class="section-heading">
                <h2>My Appointments</h2>
                <a href="{{ route('student.appointments.create') }}" class="btn-gold">
                    + New Appointment
                </a>
            </div>

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}
                            </td>

                            <td>{{ $appointment->purpose }}</td>

                            <td>
                                <span class="status {{ strtolower($appointment->status) }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>

                            <td>
                                @if ($appointment->status === 'Pending')
                                    <span>Pending Review</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-empty-state">
                                You have no appointments yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>
</div>
@endsection
