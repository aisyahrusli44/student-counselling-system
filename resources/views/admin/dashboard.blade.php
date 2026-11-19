@extends('layouts.portal')

@section('title', 'Admin Dashboard | UniCare')

@section('page-title', 'Dashboard overview')
@section('page-subtitle', 'Welcome back, ' . Auth::user()->name . ". Here's what's happening in the counselling office.")

@section('portal-content')

    @if ($errors->any())
        <div class="alert alert-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="stats">
        <div class="stat">
            <div class="stat-icon pending"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
            <div><div class="stat-value">{{ $pendingCount }}</div><div class="stat-label">Pending requests</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon approved"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
            <div><div class="stat-value">{{ $approvedCount }}</div><div class="stat-label">Confirmed appointments</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon rejected"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg></div>
            <div><div class="stat-value">{{ $rejectedCount }}</div><div class="stat-label">Rejected requests</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon info"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5M16 4.5a3.5 3.5 0 0 1 0 7M22 20c0-3-2-4.8-5-5.3"/></svg></div>
            <div><div class="stat-value">{{ $studentCount }}</div><div class="stat-label">Registered students</div></div>
        </div>
    </div>

    <div class="split">
        <section class="card main-col" aria-labelledby="recent-heading">
            <div class="card-header">
                <h2 id="recent-heading">Recent appointment requests</h2>
                <a href="{{ route('admin.appointments.index') }}" class="link">View all</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr><th>Student</th><th>Date</th><th>Purpose</th><th>Status</th><th class="text-right">Action</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($recentAppointments as $appointment)
                            <tr>
                                <td class="cell-strong">
                                    {{ $appointment->user->name }}
                                    <span class="cell-sub">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i') }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>
                                <td>@include('partials.purpose-tag', ['purpose' => $appointment->purpose])</td>
                                <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                                <td class="text-right">@include('admin.partials.appointment-actions', ['appointment' => $appointment])</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="table-empty">No appointment requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card side-col" aria-labelledby="today-heading">
            <div class="card-header"><h2 id="today-heading">Today's sessions</h2></div>
            <div class="card-body">
                @if ($todaySessions->isEmpty())
                    <p class="field-hint">No approved sessions scheduled for today.</p>
                @else
                    <div class="session-list">
                        @foreach ($todaySessions as $session)
                            <div class="session">
                                <span class="session-time">{{ \Carbon\Carbon::parse($session->preferred_time)->format('H:i') }}</span>
                                <div>
                                    <div class="session-name">{{ $session->user->name }}</div>
                                    <div class="session-sub">{{ $session->purpose }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>

@endsection