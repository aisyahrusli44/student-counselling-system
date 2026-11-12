<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    /* Display the student's appointments.*/
    public function index(): View
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->orderBy('preferred_date', 'asc')
            ->orderBy('preferred_time', 'asc')
            ->get();

        return view('student.appointments.index', compact('appointments'));
    }

    /**
     * Show the new appointment form.
     */
    public function create(): View
    {
        return view('student.appointments.create');
    }

    /* Display all appointments for the administrator. */
    public function adminIndex(): View
    {
        $appointments = Appointment::with('user')
            ->orderBy('preferred_date', 'asc')
            ->orderBy('preferred_time', 'asc')
            ->get();

        return view('admin.appointments.index', compact('appointments'));
    }
    /**
     * Approve a pending appointment.
     */
    public function approve(Appointment $appointment): RedirectResponse
    {
        if ($appointment->status !== 'Pending') {
            return back()->with('error', 'This appointment has already been processed.');
        }

        $appointment->update([
            'status' => 'Approved',
        ]);

        return back()->with('success', 'Appointment approved successfully!');
    }

    /* Reject a pending appointment.*/
    public function reject(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->status !== 'Pending') {
            return back()->with('error', 'This appointment has already been processed.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $appointment->update([
            'status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Appointment rejected successfully!');
    }

    /*Store a new appointment*/
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'purpose' => [
                'required',
                'in:Academic Issues,Personal Issues,Career Guidance,Family Issues,Other',
            ],
            'other_purpose' => [
                'required_if:purpose,Other',
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'preferred_date' => $validated['preferred_date'],
            'preferred_time' => $validated['preferred_time'],
            'purpose' => $validated['purpose'] === 'Other'
                ? $validated['other_purpose']
                : $validated['purpose'],
            'status' => 'Pending',
        ]);

        return redirect()
            ->route('student.appointments.index')
            ->with('success', 'Appointment submitted successfully!');
    }

    /* Show the edit form for one of the student's own pending appointments. */
    public function edit(Appointment $appointment): View
    {
        $this->ensureOwnPending($appointment);

        return view('student.appointments.edit', compact('appointment'));
    }

    /* Save changes to a pending appointment. */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->ensureOwnPending($appointment);

        $validated = $request->validate([
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'purpose' => [
                'required',
                'in:Academic Issues,Personal Issues,Career Guidance,Family Issues,Other',
            ],
            'other_purpose' => [
                'required_if:purpose,Other',
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $appointment->update([
            'preferred_date' => $validated['preferred_date'],
            'preferred_time' => $validated['preferred_time'],
            'purpose' => $validated['purpose'] === 'Other'
                ? $validated['other_purpose']
                : $validated['purpose'],
        ]);

        return redirect()
            ->route('student.appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    /* Cancel (delete) a pending appointment. */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $this->ensureOwnPending($appointment);

        $appointment->delete();

        return redirect()
            ->route('student.appointments.index')
            ->with('success', 'Appointment request cancelled.');
    }

    /* Students may only change their own appointments, and only while pending. */
    private function ensureOwnPending(Appointment $appointment): void
    {
        abort_if((int) $appointment->user_id !== (int) Auth::id(), 403, 'Unauthorized access.');
        abort_if($appointment->status !== 'Pending', 403, 'Only pending appointments can be changed.');
    }
}