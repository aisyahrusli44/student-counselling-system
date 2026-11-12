@extends('layouts.portal')

@section('title', 'My Profile | UniCare')

@section('page-title', 'My profile')
@section('page-subtitle', 'Manage your account details and password.')

@php
    $isAdmin = $user->role === 'admin';
    $initials = collect(explode(' ', trim($user->name)))->filter()->take(2)
        ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
    $pw = $errors->password;
@endphp

@section('portal-content')

    <section class="profile-hero">
        <span class="avatar avatar-lg">{{ $initials }}</span>
        <div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-meta">
                {{ $isAdmin ? 'Administrator' : 'Student' }}
                @if (! $isAdmin && $user->student_id)
                    · {{ $user->student_id }}
                @endif
                @if ($user->created_at)
                    · Member since {{ $user->created_at->format('F Y') }}
                @endif
            </p>
        </div>
    </section>

    <div class="split">
        {{-- Account details --}}
        <form method="POST" action="{{ route('profile.update') }}" class="card main-col">
            @csrf
            @method('PATCH')

            <div class="card-header"><h2>Account details</h2></div>

            <div class="card-body form-stack">
                @if ($errors->default->any())
                    <div class="alert alert-error" role="alert">{{ $errors->default->first() }}</div>
                @endif

                <div class="field-group">
                    <label class="field-label" for="name">Full name</label>
                    <div class="input {{ $errors->default->has('name') ? 'has-error' : '' }}">
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="email">Email address</label>
                    <div class="input {{ $errors->default->has('email') ? 'has-error' : '' }}">
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                    </div>
                </div>

                @unless ($isAdmin)
                    <div class="field-group">
                        <label class="field-label" for="student_id">Student ID</label>
                        <div class="input input-readonly">
                            <input type="text" id="student_id" value="{{ $user->student_id }}" readonly>
                        </div>
                        <span class="field-hint">Your student ID can't be changed. Contact the counselling office if it's wrong.</span>
                    </div>
                @endunless
            </div>

            <div class="card-footer">
                <span></span>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>

        {{-- Change password --}}
        <form method="POST" action="{{ route('profile.password') }}" class="card side-col">
            @csrf
            @method('PUT')

            <div class="card-header"><h2>Change password</h2></div>

            <div class="card-body form-stack">
                @if ($pw->any())
                    <div class="alert alert-error" role="alert">{{ $pw->first() }}</div>
                @endif

                <div class="field-group">
                    <label class="field-label" for="current_password">Current password</label>
                    <div class="input {{ $pw->has('current_password') ? 'has-error' : '' }}">
                        <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="new_password">New password</label>
                    <div class="input {{ $pw->has('password') ? 'has-error' : '' }}">
                        <input type="password" id="new_password" name="password" minlength="6" autocomplete="new-password" required>
                    </div>
                    <span class="field-hint">At least 6 characters.</span>
                </div>

                <div class="field-group">
                    <label class="field-label" for="new_password_confirmation">Confirm new password</label>
                    <div class="input">
                        <input type="password" id="new_password_confirmation" name="password_confirmation" minlength="6" autocomplete="new-password" required>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <span></span>
                <button type="submit" class="btn btn-outline">Update password</button>
            </div>
        </form>
    </div>

@endsection