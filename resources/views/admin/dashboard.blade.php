
@extends('layouts.app')

@section('title', 'Admin Dashboard')

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

            <a href="{{ route('admin.dashboard') }}" class="active">
               <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                    <rect x="13" y="3" width="8" height="8" rx="1"/>
                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                    <rect x="13" y="13" width="8" height="8" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.appointments.index') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="17" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                <span>Manage Appointments</span>
            </a>

            <a href="#">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="8" r="4"/>
                    <path d="M2 21c0-4 3-7 7-7M16 11a4 4 0 1 0 0-8M15 14c4 0 7 3 7 7"/>
                </svg>
                <span>Manage Users</span>
            </a>

            <a href="#">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19V5M4 19h17"/>
                    <path d="M8 15l4-4 3 2 5-7"/>
                </svg>
                <span>Reports</span>
            </a>

            <a href="#">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
                </svg>
                <span>Profile</span>
            </a>

            <!-- Logout Button -->
                <button
                    type="button"
                    class="dashboard-logout"
                    onclick="document.getElementById('logout-dialog').showModal()">

                    <span>Logout</span>
                </button>

                <!-- Logout Confirmation Modal -->
                <dialog id="logout-dialog" class="reject-dialog">

                    <h2>Logout Confirmation</h2>

                    <p>Are you sure you want to logout from your account?</p>

                    <div class="appointment-form-actions">

                        <button
                            type="button"
                            class="btn-outline"
                            onclick="document.getElementById('logout-dialog').close()">
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
                <h1>Dashboard Overview</h1>
                <p>Welcome back, {{ Auth::user()->name }}. Here's an overview of the counselling system.</p>
            </div>

            <div class="dashboard-user">
                <span>{{ now()->timezone('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Summary Cards -->
        <section class="admin-summary">

            <div class="admin-summary-card">
                <div class="admin-summary-icon pending-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <div>
                    <p>Pending Requests</p>
                    <h2>{{ $pendingCount }}</h2>
                </div>
            </div>

            <div class="admin-summary-card">
                <div class="admin-summary-icon approved-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 3 3 5-6"/>
                    </svg>
                </div>
                <div>
                    <p>Confirmed Appointments</p>
                    <h2>{{ $approvedCount }}</h2>
                </div>
            </div>

            <div class="admin-summary-card">
                <div class="admin-summary-icon rejected-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m9 9 6 6m0-6-6 6"/>
                    </svg>
                </div>
                <div>
                    <p>Rejected Requests</p>
                    <h2>{{ $rejectedCount }}</h2>
                </div>
            </div>

        </section>

        <!-- Recent Appointment Requests -->
        <section class="admin-appointments-card">

            <div class="section-heading">
                <h2>Recent Appointment Requests</h2>
            </div>

            <div class="admin-table-wrapper">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($recentAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->user->name }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}
                                </td>

                                <td>{{ $appointment->purpose }}</td>

                                <td>
                                    <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>

                                <td>
                                    @if ($appointment->status === 'Pending')

                                        <div class="appointment-actions">

                                            <!-- Approve Button -->
                                                <button
                                                    type="button"
                                                    class="btn-approve"
                                                    onclick="document.getElementById('approve-dialog-{{ $appointment->id }}').showModal()">
                                                    Approve
                                                </button>

                                                <!-- Approve Confirmation Modal -->
                                                <dialog id="approve-dialog-{{ $appointment->id }}" class="reject-dialog">
                                                    <h2>Approve Appointment</h2>

                                                    <p>Are you sure you want to approve this appointment?</p>

                                                    <div class="appointment-form-actions">

                                                        <button
                                                            type="button"
                                                            class="btn-outline"
                                                            onclick="document.getElementById('approve-dialog-{{ $appointment->id }}').close()">
                                                            Cancel
                                                        </button>

                                                        <form
                                                            method="POST"
                                                            action="{{ route('admin.appointments.approve', $appointment->id) }}">
                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="submit" class="btn-approve">
                                                                Confirm Approve
                                                            </button>
                                                        </form>

                                                    </div>
                                                </dialog>

                                            <!-- Reject Button-->
                                            <button
                                                type="button"
                                                class="btn-reject"
                                                onclick="document.getElementById('reject-dialog-{{ $appointment->id }}').showModal()">
                                                Reject
                                            </button>

                                        </div>

                                       <!-- Reject Confirmation Modal -->
                                        <dialog id="reject-dialog-{{ $appointment->id }}" class="reject-dialog">

                                            <h2>Reject Appointment</h2>

                                            <p>Please provide a reason for rejecting this appointment.</p>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.appointments.reject', $appointment->id) }}">

                                                @csrf
                                                @method('PATCH')

                                                <label for="rejection-reason-{{ $appointment->id }}">
                                                    Rejection Reason
                                                </label>

                                                <textarea
                                                    id="rejection-reason-{{ $appointment->id }}"
                                                    name="rejection_reason"
                                                    placeholder="Enter the reason for rejection..."
                                                    maxlength="1000"
                                                    required></textarea>

                                                <div class="appointment-form-actions">

                                                    <button
                                                        type="button"
                                                        class="btn-outline"
                                                        onclick="document.getElementById('reject-dialog-{{ $appointment->id }}').close()">
                                                        Cancel
                                                    </button>

                                                    <button type="submit" class="btn-reject">
                                                        Confirm Reject
                                                    </button>

                                                </div>
                                            </form>
                                        </dialog>

                                    @else

                                        <details class="appointment-view-details">
                                            <summary>View Details</summary>

                                            <div class="appointment-details-content">

                                                <p><strong>Student:</strong> {{ $appointment->user->name }}</p>

                                                <p><strong>Date:</strong>
                                                    {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}
                                                </p>

                                                <p><strong>Time:</strong>
                                                    {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}
                                                </p>

                                                <p><strong>Purpose:</strong> {{ $appointment->purpose }}</p>

                                                <p><strong>Status:</strong> {{ $appointment->status }}</p>

                                                @if ($appointment->status === 'Rejected')
                                                    <p><strong>Rejection Reason:</strong></p>
                                                    <p>{{ $appointment->rejection_reason ?? 'No reason provided.' }}</p>
                                                @endif

                                            </div>
                                        </details>

                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="admin-empty-state">
                                    No appointment requests available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </section>

    </main>

</div>

@endsection
