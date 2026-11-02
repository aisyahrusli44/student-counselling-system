
@extends('layouts.app')

@section('title', 'My Appointments')

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

            <a href="{{ route('student.dashboard') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                    <rect x="13" y="3" width="8" height="8" rx="1"/>
                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                    <rect x="13" y="13" width="8" height="8" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('student.appointments.index') }}" class="active">
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
                <h1>My Appointments</h1>
                <p>View and manage your counselling appointments.</p>
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
                <h2>Appointment History</h2>
                <a href="{{ route('student.appointments.create') }}" class="btn-gold">
                + New Appointment
            </a>
            </div>

            <div class="admin-table-wrapper">
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
                                <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>

                                <td>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}</td>

                                <td>{{ $appointment->purpose }}</td>

                                <td>
                                    <span class="status {{ strtolower($appointment->status) }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>

                                <td>
                                    @if ($appointment->status === 'Pending')

                                        <a href="#">Edit</a>
                                        <a href="#" class="cancel-link">Delete</a>

                                    @elseif ($appointment->status === 'Rejected')

                                        <details class="appointment-view-details">
                                            <summary>View Reason</summary>

                                            <div class="appointment-details-content">
                                                <p><strong>Rejection Reason:</strong></p>
                                                <p>{{ $appointment->rejection_reason ?? 'No reason provided.' }}</p>
                                            </div>
                                        </details>

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
            </div>

        </section>

    </main>
    
    @if (session('success'))
        <div class="alert-success auto-dismiss">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error auto-dismiss">
            {{ session('error') }}
        </div>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.auto-dismiss');

        alerts.forEach(function (alert) {
            setTimeout(function () {
                alert.classList.add('alert-hide');

                setTimeout(function () {
                    alert.remove();
                }, 400);

            }, 3000);
        });
    });
</script>

@endsection
