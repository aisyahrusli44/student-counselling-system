@extends('layouts.portal')

@section('title', 'Manage Users | UniCare')

@section('page-title', 'Students')
@section('page-subtitle', 'All registered student accounts and their appointment activity.')

@section('portal-content')

    <section class="card" data-filter-table>
        <div class="toolbar">
            <p class="toolbar-title">{{ $students->count() }} {{ Str::plural('student', $students->count()) }}</p>
            <label class="search">
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <span class="sr-only">Search students</span>
                <input type="search" placeholder="Search name, email or student ID" data-search-input>
            </label>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Student ID</th>
                        <th>Joined</th>
                        <th>Appointments</th>
                        <th>Pending</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $initials = collect(explode(' ', trim($student->name)))->filter()->take(2)
                                ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
                        @endphp
                        <tr data-status="student"
                            data-search="{{ mb_strtolower($student->name . ' ' . $student->email . ' ' . $student->student_id) }}">
                            <td>
                                <div class="person">
                                    <span class="avatar">{{ $initials }}</span>
                                    <span class="cell-strong">
                                        {{ $student->name }}
                                        <span class="cell-sub">{{ $student->email }}</span>
                                    </span>
                                </div>
                            </td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ optional($student->created_at)->format('d M Y') ?? '—' }}</td>
                            <td>{{ $student->appointments_count }}</td>
                            <td>
                                @if ($student->pending_count > 0)
                                    <span class="badge badge-pending">{{ $student->pending_count }} pending</span>
                                @else
                                    <span class="field-hint">—</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.users.show', $student->id) }}" class="link">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="table-empty">No students have registered yet.</td></tr>
                    @endforelse
                    <tr data-empty-filter hidden>
                        <td colspan="6" class="table-empty">No students match your search.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <span data-shown-count>Showing {{ $students->count() }} of {{ $students->count() }}</span>
        </div>
    </section>

@endsection

@push('scripts')
    @include('partials.table-filter')
@endpush