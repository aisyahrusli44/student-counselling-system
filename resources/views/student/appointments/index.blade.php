@extends('layouts.portal')

@section('title', 'My Appointments | UniCare')

@section('page-title', 'My appointments')
@section('page-subtitle', 'Track the status of your counselling requests.')

@section('page-actions')
    <a href="{{ route('student.appointments.create') }}" class="btn btn-gold">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
        New appointment
    </a>
@endsection

@php
    $tabs = [
        'all'      => ['label' => 'All',      'count' => $appointments->count()],
        'pending'  => ['label' => 'Pending',  'count' => $appointments->where('status', 'Pending')->count()],
        'approved' => ['label' => 'Approved', 'count' => $appointments->where('status', 'Approved')->count()],
        'rejected' => ['label' => 'Rejected', 'count' => $appointments->where('status', 'Rejected')->count()],
    ];
@endphp

@section('portal-content')

    <section class="card" data-filter-table>
        <div class="toolbar">
            <div class="tabs" role="tablist" aria-label="Filter appointments by status">
                @foreach ($tabs as $key => $tab)
                    <button type="button" class="tab" role="tab" data-filter="{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $tab['label'] }} <span class="tab-count">{{ $tab['count'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr data-status="{{ strtolower($appointment->status) }}">
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}</td>
                            <td>{{ $appointment->purpose }}</td>
                            <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                            <td class="text-right">
                                @if ($appointment->status === 'Pending')
                                                                        <div class="actions">
                                        <a href="{{ route('student.appointments.edit', $appointment->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="document.getElementById('cancel-dialog-{{ $appointment->id }}').showModal()">Cancel</button>
                                    </div>

                                    <dialog id="cancel-dialog-{{ $appointment->id }}" class="dialog" aria-labelledby="cancel-title-{{ $appointment->id }}">
                                        <div class="dialog-head"><h2 id="cancel-title-{{ $appointment->id }}">Cancel this request?</h2></div>
                                        <div class="dialog-body">
                                            <p>Your {{ $appointment->purpose }} request for
                                               {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }},
                                               {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('h:i A') }}
                                               will be removed. This can't be undone.</p>
                                        </div>
                                        <div class="dialog-actions">
                                            <button type="button" class="btn btn-outline"
                                                    onclick="document.getElementById('cancel-dialog-{{ $appointment->id }}').close()">Keep request</button>
                                            <form method="POST" action="{{ route('student.appointments.destroy', $appointment->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-solid">Cancel request</button>
                                            </form>
                                        </div>
                                    </dialog>
                                @elseif ($appointment->status === 'Rejected')
                                    <details class="details">
                                        <summary>View reason</summary>
                                        <dl class="details-panel">
                                            <dt>Rejection reason</dt>
                                            <dd>{{ $appointment->rejection_reason ?? 'No reason provided.' }}</dd>
                                        </dl>
                                    </details>
                                @else
                                    <span class="field-hint">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="table-empty">
                                You have no appointments yet.
                                <a href="{{ route('student.appointments.create') }}" class="link">Book your first session</a>
                            </td>
                        </tr>
                    @endforelse
                    <tr data-empty-filter hidden>
                        <td colspan="5" class="table-empty">No appointments in this category.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <span data-shown-count>Showing {{ $appointments->count() }} {{ Str::plural('appointment', $appointments->count()) }}</span>
        </div>
    </section>

@endsection

@push('scripts')
    @include('partials.table-filter')
@endpush