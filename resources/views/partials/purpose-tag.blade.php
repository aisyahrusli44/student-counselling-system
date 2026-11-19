{{-- Coloured tag for an appointment purpose. Usage: @include('partials.purpose-tag', ['purpose' => $appointment->purpose]) --}}
@php
    $purposeKeys = [
        'Academic Issues' => 'academic',
        'Personal Issues' => 'personal',
        'Career Guidance' => 'career',
        'Family Issues'   => 'family',
    ];
    $purposeKey = $purposeKeys[$purpose] ?? 'other';
@endphp
<span class="purpose-tag purpose-{{ $purposeKey }}">{{ $purpose }}</span>