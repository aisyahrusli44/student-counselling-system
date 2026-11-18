@extends('layouts.app')

{{--
    Shared layout for the student and admin portals.
    Child views provide:
      @section('page-title')     main heading
      @section('page-subtitle')  line under the heading (optional)
      @section('page-actions')   buttons on the right of the heading (optional)
      @section('portal-content') the page body
--}}

@php
    $user = Auth::user();
    $isAdmin = $user->role === 'admin';

    $initials = collect(explode(' ', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');

    $icons = [
        'dashboard' => '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>',
        'calendar'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/>',
        'plus'      => '<circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>',
        'user'      => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',
        'users'     => '<circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5M16 4.5a3.5 3.5 0 0 1 0 7M22 20c0-3-2-4.8-5-5.3"/>',
        'chart'     => '<path d="M4 20V10M10 20V4M16 20v-8M22 20H2"/>',
        'help'      => '<circle cx="12" cy="12" r="9"/><path d="M9.6 9a2.5 2.5 0 1 1 4.5 1.5c-1.3 1.2-2.1 1.5-2.1 3"/><path d="M12 17.5v.1"/>',
    ];

        // 'match' = which route names highlight this menu item
    $navItems = $isAdmin
        ? [
            ['label' => 'Dashboard',           'icon' => 'dashboard', 'route' => 'admin.dashboard',          'match' => 'admin.dashboard'],
            ['label' => 'Manage Appointments', 'icon' => 'calendar',  'route' => 'admin.appointments.index', 'match' => 'admin.appointments.*'],
            ['label' => 'Manage Users',        'icon' => 'users',     'route' => 'admin.users.index',        'match' => 'admin.users.*'],
            ['label' => 'Reports',             'icon' => 'chart',     'route' => 'admin.reports.index',      'match' => 'admin.reports.*'],
            ['label' => 'Profile',             'icon' => 'user',      'route' => 'profile.edit',             'match' => 'profile.*'],
        ]
        : [
            ['label' => 'Dashboard',        'icon' => 'dashboard', 'route' => 'student.dashboard',           'match' => 'student.dashboard'],
            ['label' => 'My Appointments',  'icon' => 'calendar',  'route' => 'student.appointments.index',  'match' => ['student.appointments.index', 'student.appointments.edit']],
            ['label' => 'New Appointment',  'icon' => 'plus',      'route' => 'student.appointments.create', 'match' => 'student.appointments.create'],
            ['label' => 'Profile',          'icon' => 'user',      'route' => 'profile.edit',                'match' => 'profile.*'],
            ['label' => 'Help & Support',   'icon' => 'help',      'route' => 'student.help',                'match' => 'student.help'],
        ];
@endphp

@section('content')
<div class="portal {{ $isAdmin ? 'portal-admin' : 'portal-student' }}">

    <aside class="sidebar">
        <a href="{{ route($isAdmin ? 'admin.dashboard' : 'student.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/unicare-logo.png') }}" alt="UniCare">
            <span class="sidebar-brand-sub">{{ $isAdmin ? 'Administrator' : 'Student Counselling' }}</span>
        </a>

        <nav class="sidebar-nav" aria-label="{{ $isAdmin ? 'Admin' : 'Student' }} navigation">
            @foreach ($navItems as $item)
                 @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="nav-link {{ $active ? 'is-active' : '' }}"
                   @if ($active) aria-current="page" @endif>
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$item['icon']] !!}</svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

            <div class="sidebar-footer">
            <a href="{{ route('profile.edit') }}" class="sidebar-user {{ request()->routeIs('profile.*') ? 'is-active' : '' }}" title="View my profile">
                <span class="avatar">{{ $initials }}</span>
                <span>
                    <span class="sidebar-user-name">{{ $user->name }}</span>
                    <span class="sidebar-user-role">View profile</span>
                </span>
            </a>

            <button type="button" class="sidebar-logout" aria-label="Log out" title="Log out"
                    onclick="document.getElementById('logout-dialog').showModal()">
                <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            </button>
        </div>
    </aside>

    <main class="portal-main">
        <header class="page-header">
            <div>
                <h1 class="page-title">@yield('page-title')</h1>
                @hasSection('page-subtitle')
                    <p class="page-subtitle">@yield('page-subtitle')</p>
                @endif
            </div>
            <div class="page-meta">
                <span>{{ now()->timezone('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
                @yield('page-actions')
            </div>
        </header>

        @yield('portal-content')
    </main>
</div>

{{-- Logout confirmation --}}
<dialog id="logout-dialog" class="dialog" aria-labelledby="logout-dialog-title">
    <div class="dialog-head"><h2 id="logout-dialog-title">Log out?</h2></div>
    <div class="dialog-body"><p>Are you sure you want to log out of your account?</p></div>
    <div class="dialog-actions">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('logout-dialog').close()">Cancel</button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Log out</button>
        </form>
    </div>
</dialog>
@endsection