@extends('layouts.portal')

@section('title', 'Reports | UniCare')

@section('page-title', 'Reports')
@section('page-subtitle', 'An overview of counselling requests across the system.')

@section('page-actions')
    <button type="button" class="btn btn-outline" onclick="window.print()">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Print
    </button>
@endsection

@php
    $statusMax = max(1, max($byStatus->all()));
    $purposeMax = max(1, max($byPurpose));
    $monthMax = max(1, max($byMonth));
    $statusClass = ['Pending' => 'pending', 'Approved' => 'approved', 'Rejected' => 'rejected'];
@endphp

@section('portal-content')

    <div class="stats">
        <div class="stat">
            <div class="stat-icon info"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></div>
            <div><div class="stat-value">{{ $total }}</div><div class="stat-label">Total requests</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon approved"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></div>
            <div><div class="stat-value">{{ $approvalRate === null ? '—' : $approvalRate . '%' }}</div><div class="stat-label">Approval rate</div></div>
        </div>
        <div class="stat">
            <div class="stat-icon pending"><svg aria-hidden="true" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5M16 4.5a3.5 3.5 0 0 1 0 7M22 20c0-3-2-4.8-5-5.3"/></svg></div>
            <div><div class="stat-value">{{ $activeStudents }} <span class="stat-of">/ {{ $studentCount }}</span></div><div class="stat-label">Students who have booked</div></div>
        </div>
    </div>

    <div class="split">
        <section class="card main-col" aria-labelledby="month-heading">
            <div class="card-header"><h2 id="month-heading">Requests per month</h2><span class="field-hint">Last 6 months, by preferred date</span></div>
            <div class="card-body">
                <div class="col-chart" role="img"
                     aria-label="Requests per month: {{ collect($byMonth)->map(fn ($n, $m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M') . ' ' . $n)->implode(', ') }}">
                    @foreach ($byMonth as $month => $count)
                        <div class="col">
                            <span class="col-value">{{ $count }}</span>
                            <span class="col-bar" style="height: {{ round($count / $monthMax * 100) }}%"></span>
                            <span class="col-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="card side-col" aria-labelledby="status-heading">
            <div class="card-header"><h2 id="status-heading">By status</h2></div>
            <div class="card-body bar-list">
                @foreach ($byStatus as $status => $count)
                    <div class="bar-row">
                        <div class="bar-head"><span>{{ $status }}</span><strong>{{ $count }}</strong></div>
                        <div class="bar-track"><span class="bar-fill {{ $statusClass[$status] }}" style="width: {{ round($count / $statusMax * 100) }}%"></span></div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <section class="card" aria-labelledby="purpose-heading">
        <div class="card-header"><h2 id="purpose-heading">By purpose</h2><span class="field-hint">What students want to talk about</span></div>
        <div class="card-body bar-list">
            @foreach ($byPurpose as $purpose => $count)
                <div class="bar-row">
                    <div class="bar-head">
                        <span>{{ $purpose }}</span>
                        <strong>{{ $count }} <span class="field-hint">({{ $total > 0 ? round($count / $total * 100) : 0 }}%)</span></strong>
                    </div>
                    <div class="bar-track"><span class="bar-fill" style="width: {{ round($count / $purposeMax * 100) }}%"></span></div>
                </div>
            @endforeach
        </div>
    </section>

@endsection