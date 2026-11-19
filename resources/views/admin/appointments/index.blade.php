@extends('layouts.portal')

@section('title', 'Manage Appointments | UniCare')

@section('page-title', 'Appointment requests')
@section('page-subtitle', 'Review, approve or reject counselling requests from students.')

@php
    $tabs = [
        'all'      => ['label' => 'All',      'count' => $appointments->count()],
        'pending'  => ['label' => 'Pending',  'count' => $appointments->where('status', 'Pending')->count()],
        'approved' => ['label' => 'Approved', 'count' => $appointments->where('status', 'Approved')->count()],
        'rejected' => ['label' => 'Rejected', 'count' => $appointments->where('status', 'Rejected')->count()],
    ];
@endphp

@section('portal-content')

    @if ($errors->any())
        <div class="alert alert-error" role="alert">{{ $errors->first() }}</div>
    @endif

    <section class="card" data-filter-table>
        <div class="toolbar">
            <div class="tabs" role="tablist" aria-label="Filter requests by status">
                @foreach ($tabs as $key => $tab)
                    <button type="button" class="tab" role="tab" data-filter="{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $tab['label'] }} <span class="tab-count">{{ $tab['count'] }}</span>
                    </button>
                @endforeach
            </div>
            <label class="search">
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <span class="sr-only">Search by student</span>
                <input type="search" placeholder="Search by student name or ID" data-search-input>
            </label>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        @php
                            $name = $appointment->user->name;
                            $initials = collect(explode(' ', trim($name)))->filter()->take(2)
                                ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
                        @endphp
                        <tr data-status="{{ strtolower($appointment->status) }}"
                            data-search="{{ mb_strtolower($name . ' ' . $appointment->user->student_id) }}">
                            <td>
                                <div class="person">
                                    <span class="avatar">{{ $initials }}</span>
                                    <span class="cell-strong">
                                        {{ $name }}
                                        <span class="cell-sub">{{ $appointment->user->student_id }}</span>
                                    </span>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i') }}</td>
                            <td>@include('partials.purpose-tag', ['purpose' => $appointment->purpose])</td>
                            <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                            <td class="text-right">@include('admin.partials.appointment-actions', ['appointment' => $appointment])</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="table-empty">No appointment requests yet.</td></tr>
                    @endforelse
                    <tr data-empty-filter hidden>
                        <td colspan="6" class="table-empty">No requests match this filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <span data-shown-count>Showing {{ $appointments->count() }} of {{ $appointments->count() }}</span>
        </div>
    </section>

@endsection

@push('scripts')
    @include('partials.table-filter')
@endpush