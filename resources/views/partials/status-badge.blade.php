@php
    $statusClass = match ($status) {
        'Approved' => 'badge-approved',
        'Rejected' => 'badge-rejected',
        'Pending'  => 'badge-pending',
        default    => 'badge-muted',
    };
@endphp
<span class="badge {{ $statusClass }}">{{ $status }}</span>