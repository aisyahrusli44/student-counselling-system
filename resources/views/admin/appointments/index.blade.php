
@extends('layouts.app')

@section('title', 'Manage Appointments')

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

            <a href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                    <rect x="13" y="3" width="8" height="8" rx="1"/>
                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                    <rect x="13" y="13" width="8" height="8" rx="1"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.appointments.index') }}" class="active">
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
                <h1>Manage Appointments</h1>
                <p>View and manage student counselling appointment requests.</p>
            </div>

            <div class="dashboard-user">
                <span>{{ now()->timezone('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Appointment Table -->
        <section class="admin-appointments-card">

            <div class="section-heading">
                <h2>All Appointment Requests</h2>
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
                        @forelse ($appointments as $appointment)
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

                                            <!-- Reject Button -->
                                            <button
                                                type="button"
                                                class="btn-reject"
                                                onclick="document.getElementById('reject-dialog-{{ $appointment->id }}').showModal()">
                                                Reject
                                            </button>

                                        </div>

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

                                        <span>Processed</span>

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
