@extends('layouts.portal')

@section('title', 'Student Dashboard | UniCare')

@section('page-title', 'Welcome, ' . Auth::user()->name)

@section('page-subtitle')
    Here's an overview of your <strong>counselling sessions</strong>.
@endsection

@section('page-actions')
    <a href="{{ route('student.appointments.create') }}" class="btn btn-gold">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
        New appointment
    </a>
@endsection

@php
    $today = today()->toDateString();

    // Show the next approved session; if there is none, show the next request still awaiting review.
    $upcoming = $nextAppointment ?? $appointments
        ->where('status', 'Pending')
        ->where('preferred_date', '>=', $today)
        ->first();

    $counts = [
        'total'    => $appointments->count(),
        'pending'  => $appointments->where('status', 'Pending')->count(),
        'approved' => $appointments->where('status', 'Approved')->count(),
        'rejected' => $appointments->where('status', 'Rejected')->count(),
    ];

    $recent = $appointments->sortByDesc(fn ($a) => $a->preferred_date . ' ' . $a->preferred_time)->take(5);
@endphp

@section('portal-content')

    {{-- 1. Summary counts (right under the welcome heading) --}}
    <div class="stats">
        <div class="stat">
            <div class="stat-icon info"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></div>
            <div><div class="stat-value">{{ $counts['total'] }}</div><div class="stat-label">Total requests</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon pending"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
            <div><div class="stat-value">{{ $counts['pending'] }}</div><div class="stat-label">Pending</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon approved"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
            <div><div class="stat-value">{{ $counts['approved'] }}</div><div class="stat-label">Approved</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon rejected"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg></div>
            <div><div class="stat-value">{{ $counts['rejected'] }}</div><div class="stat-label">Rejected</div></div>
        </div>
    </div>

    {{-- 2. Next appointment + help card --}}
    <div class="dash-grid">
        <section class="card span-2" aria-labelledby="next-heading">
            <div class="card-header">
                <h2 id="next-heading">Next appointment</h2>
                @if ($upcoming)
                    <span class="badge-lg">@include('partials.status-badge', ['status' => $upcoming->status])</span>
                @endif
            </div>
            <div class="card-body">
                @if ($upcoming)
                    @php $date = \Carbon\Carbon::parse($upcoming->preferred_date); @endphp
                    <div class="next-appt">
                        <div class="date-tile" aria-hidden="true">
                            <span class="date-tile-mon">{{ strtoupper($date->format('M')) }}</span>
                            <span class="date-tile-day">{{ $date->format('d') }}</span>
                            <span class="date-tile-dow">{{ $date->format('D') }}</span>
                        </div>
                        <div>
                            <p class="next-appt-title">{{ $upcoming->purpose }}</p>
                            <div class="meta-row">
                                <span>
                                    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
                                    <strong>{{ $date->format('l, d F Y') }}</strong>
                                </span>
                                <span>
                                    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    <strong>{{ \Carbon\Carbon::parse($upcoming->preferred_time)->format('h:i A') }}</strong>
                                </span>
                            </div>
                            @if ($upcoming->status === 'Pending')
                                <p class="field-hint" style="margin-top: 10px">Waiting for the <strong>counselling office</strong> to review your request.</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <strong>No upcoming appointments</strong>
                        <span>When you book a session, it will show up here.</span>
                        <a href="{{ route('student.appointments.create') }}" class="btn btn-primary">Book an appointment</a>
                    </div>
                @endif
            </div>
        </section>

        <section class="help-card" aria-labelledby="help-heading">
            <div class="help-icon">
                <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><path d="m5.6 5.6 3.6 3.6M14.8 14.8l3.6 3.6M18.4 5.6l-3.6 3.6M9.2 14.8l-3.6 3.6"/></svg>
            </div>
            <h2 id="help-heading">Need help right now?</h2>
            <p>If you're in distress or feel unsafe, <strong>don't wait for an appointment</strong>. Help &amp; Support lists who to contact and what to do.</p>
            <a href="{{ route('student.help') }}" class="btn btn-gold" style="align-self: flex-start; margin-top: auto">
                Go to Help &amp; Support
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </section>
    </div>

    {{-- 3. Recent appointments --}}
    <section class="card" aria-labelledby="recent-heading">
        <div class="card-header">
            <h2 id="recent-heading">Recent appointments</h2>
            <a href="{{ route('student.appointments.index') }}" class="link">View all</a>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Date</th><th>Time</th><th>Purpose</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($recent as $appointment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}</td>
                            <td><strong>{{ $appointment->purpose }}</strong></td>
                            <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="table-empty">You have no appointments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

@endsection