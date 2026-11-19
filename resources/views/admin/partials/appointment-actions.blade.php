{{-- Approve / reject buttons with confirmation dialogs for a pending appointment,
     or a "View details" popover for one that has already been processed. --}}
@if ($appointment->status === 'Pending')
    <div class="actions">
        <button type="button" class="btn btn-primary btn-sm"
                onclick="document.getElementById('approve-dialog-{{ $appointment->id }}').showModal()">Approve</button>
        <button type="button" class="btn btn-danger btn-sm"
                onclick="document.getElementById('reject-dialog-{{ $appointment->id }}').showModal()">Reject</button>
    </div>

    <dialog id="approve-dialog-{{ $appointment->id }}" class="dialog" aria-labelledby="approve-title-{{ $appointment->id }}">
        <div class="dialog-head"><h2 id="approve-title-{{ $appointment->id }}">Approve appointment</h2></div>
        <div class="dialog-body">
            <p>Approve <strong>{{ $appointment->user->name }}</strong>'s request for
               {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }},
               {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i') }}?</p>
        </div>
        <div class="dialog-actions">
            <button type="button" class="btn btn-outline"
                    onclick="document.getElementById('approve-dialog-{{ $appointment->id }}').close()">Cancel</button>
            <form method="POST" action="{{ route('admin.appointments.approve', $appointment->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary">Confirm approve</button>
            </form>
        </div>
    </dialog>

    <dialog id="reject-dialog-{{ $appointment->id }}" class="dialog" aria-labelledby="reject-title-{{ $appointment->id }}">
        <form method="POST" action="{{ route('admin.appointments.reject', $appointment->id) }}">
            @csrf
            @method('PATCH')
            <div class="dialog-head"><h2 id="reject-title-{{ $appointment->id }}">Reject appointment</h2></div>
            <div class="dialog-body">
                <p>Please give a reason. The student will see it in their appointments.</p>
                <label class="field-label" for="rejection-reason-{{ $appointment->id }}">Rejection reason</label>
                <textarea id="rejection-reason-{{ $appointment->id }}" name="rejection_reason" class="textarea"
                          placeholder="Enter the reason for rejection…" maxlength="1000" required></textarea>
            </div>
            <div class="dialog-actions">
                <button type="button" class="btn btn-outline"
                        onclick="document.getElementById('reject-dialog-{{ $appointment->id }}').close()">Cancel</button>
                <button type="submit" class="btn btn-danger-solid">Confirm reject</button>
            </div>
        </form>
    </dialog>
@else
    <details class="details">
        <summary>View details</summary>
        <dl class="details-panel">
            <dt>Student</dt><dd>{{ $appointment->user->name }}</dd>
            <dt>Date &amp; time</dt>
            <dd>{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('d M Y') }},
                {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('H:i') }}</dd>
            <dt>Purpose</dt><dd>{{ $appointment->purpose }}</dd>
            <dt>Status</dt><dd>{{ $appointment->status }}</dd>
            @if ($appointment->status === 'Rejected')
                <dt>Rejection reason</dt><dd>{{ $appointment->rejection_reason ?? 'No reason provided.' }}</dd>
            @endif
        </dl>
    </details>
@endif