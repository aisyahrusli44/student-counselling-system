@extends('layouts.portal')

@section('title', 'Edit Appointment | UniCare')

@section('page-title', 'Edit appointment request')
@section('page-subtitle', 'You can change a request while it is still pending review.')

@php
    $purposes = [
        'Academic Issues' => 'Exams, workload, grades',
        'Personal Issues' => 'Relationships, wellbeing, life',
        'Career Guidance' => 'Future plans and decisions',
        'Family Issues'   => 'Home and family matters',
        'Other'           => 'Tell us in your own words',
    ];

    // A custom purpose was saved as its own text, so show it as "Other" + the text.
    $isStandard = array_key_exists($appointment->purpose, $purposes) && $appointment->purpose !== 'Other';
    $currentPurpose = old('purpose', $isStandard ? $appointment->purpose : 'Other');
    $currentOther = old('other_purpose', $isStandard ? '' : $appointment->purpose);
    $currentDate = old('preferred_date', \Carbon\Carbon::parse($appointment->preferred_date)->format('Y-m-d'));
    $currentTime = old('preferred_time', \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i'));
@endphp

@section('portal-content')

    <a href="{{ route('student.appointments.index') }}" class="back-link">
        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
        Back to my appointments
    </a>

    <form method="POST" action="{{ route('student.appointments.update', $appointment->id) }}" class="card">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h2>Appointment details</h2>
            @include('partials.status-badge', ['status' => $appointment->status])
        </div>

        <div class="card-body" style="display: flex; flex-direction: column; gap: 28px">

            @if ($errors->any())
                <div class="alert alert-error" role="alert">Please check the highlighted fields and try again.</div>
            @endif

            <fieldset style="border: 0; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 14px">
                <legend class="step-title" style="padding: 0 0 14px">
                    <span class="step-num">1</span> What would you like to discuss?
                </legend>

                <div class="choices">
                    @foreach ($purposes as $value => $description)
                        <label class="choice purpose-{{ strtolower(strtok($value, ' ')) }}">
                            <input type="radio" name="purpose" value="{{ $value }}"
                                   {{ $currentPurpose === $value ? 'checked' : '' }} required>
                            <span class="choice-box">
                                <span class="choice-title">{{ $value }}</span>
                                <span class="choice-desc">{{ $description }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('purpose')
                    <small class="field-error">{{ $message }}</small>
                @enderror

                <div id="other-purpose-field" class="field-group" hidden>
                    <label class="field-label" for="other_purpose">Please specify your purpose</label>
                    <div class="input {{ $errors->has('other_purpose') ? 'has-error' : '' }}">
                        <input type="text" id="other_purpose" name="other_purpose" value="{{ $currentOther }}"
                               placeholder="Enter your counselling purpose" maxlength="255">
                    </div>
                    @error('other_purpose')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>
            </fieldset>

            <div style="display: flex; flex-direction: column; gap: 14px; border-top: 1px solid var(--border-soft); padding-top: 24px">
                <h3 class="step-title"><span class="step-num">2</span> When would you like to meet?</h3>

                <div class="grid-2">
                    <div class="field-group">
                        <label class="field-label" for="preferred_date">Preferred date</label>
                        <div class="input {{ $errors->has('preferred_date') ? 'has-error' : '' }}">
                            <input type="date" id="preferred_date" name="preferred_date" value="{{ $currentDate }}"
                                   min="{{ now()->timezone('Asia/Kuala_Lumpur')->format('Y-m-d') }}" required>
                        </div>
                        @error('preferred_date')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="preferred_time">Preferred time</label>
                        <div class="input {{ $errors->has('preferred_time') ? 'has-error' : '' }}">
                            <input type="time" id="preferred_time" name="preferred_time" value="{{ $currentTime }}" required>
                        </div>
                        @error('preferred_time')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('student.appointments.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var radios = document.querySelectorAll('input[name="purpose"]');
        var otherField = document.getElementById('other-purpose-field');
        var otherInput = document.getElementById('other_purpose');

        function toggleOther() {
            var checked = document.querySelector('input[name="purpose"]:checked');
            var isOther = checked && checked.value === 'Other';
            otherField.hidden = !isOther;
            otherInput.required = isOther;
        }

        radios.forEach(function (radio) { radio.addEventListener('change', toggleOther); });
        toggleOther();
    });
</script>
@endpush