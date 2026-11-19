@extends('layouts.portal')

@section('title', $user->name . ' | UniCare')

@section('page-title', $user->name)
@section('page-subtitle', 'Student profile and appointment history.')

@php
    $initials = collect(explode(' ', trim($user->name)))->filter()->take(2)
        ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
    $counts = [
        'total'    => $appointments->count(),
        'pending'  => $appointments->where('status', 'Pending')->count(),
        'approved' => $appointments->where('status', 'Approved')->count(),
        'rejected' => $appointments->where('status', 'Rejected')->count(),
    ];
@endphp

@section('portal-content')

    <a href="{{ route('admin.users.index') }}" class="back-link">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
        Back to students
    </a>

    @if ($errors->any())
        <div class="alert alert-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="split">
        <section class="card side-col" aria-labelledby="student-heading">
            <div class="card-header"><h2 id="student-heading">Student details</h2></div>
            <div class="card-body">
                <div class="person" style="margin-bottom: 18px">
                    <span class="avatar avatar-lg">{{ $initials }}</span>
                    <span class="cell-strong" style="font-weight: 600">
                        {{ $user->name }}
                        <span class="cell-sub" style="display: block; font-size: 13px; color: var(--muted); font-weight: 400">Student</span>
                    </span>
                </div>
                <dl class="info-list">
                    <dt>Student ID</dt><dd>{{ $user->student_id }}</dd>
                    <dt>Email</dt><dd><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
                    <dt>Joined</dt><dd>{{ optional($user->created_at)->format('d F Y') ?? '—' }}</dd>
                </dl>
            </div>
        </section>

        <div class="main-col" style="display: flex; flex-direction: column; gap: 20px">
            <div class="stats">
                <div class="stat">
                    <div class="stat-icon info"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></div>
                    <div><div class="stat-value">{{ $counts['total'] }}</div><div class="stat-label">Total</div></div>
                </div>
                <div class="stat">
                    <div class="stat-icon pending"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
                    <div><div class="stat-value">{{ $counts['pending'] }}</div><div class="stat-label">Pending</div></div>
                </div>
                <div class="stat">
                    <div class="stat-icon approved"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
                    <div><div class="stat-value">{{ $counts['approved'] }}</div><div class="stat-label">Approved</div></div>
                </div>
            </div>

            <section class="card" aria-labelledby="history-heading">
                <div class="card-header"><h2 id="history-heading">Appointment history</h2></div>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr><th>Date</th><th>Time</th><th>Purpose</th><th>Status</th><th class="text-right">Action</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i') }}</td>
                                    <td>@include('partials.purpose-tag', ['purpose' => $appointment->purpose])</td>
                                    <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                                    <td class="text-right">@include('admin.partials.appointment-actions', ['appointment' => $appointment])</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="table-empty">This student hasn't booked any appointments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

@endsection