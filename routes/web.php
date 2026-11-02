
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

// Student Dashboard
Route::get('/student/dashboard', function () {

    $appointments = \App\Models\Appointment::where('user_id', \Illuminate\Support\Facades\Auth::id())
        ->orderBy('preferred_date', 'asc')
        ->orderBy('preferred_time', 'asc')
        ->get();

    $nextAppointment = $appointments
        ->where('status', 'Approved')
        ->where('preferred_date', '>=', today()->toDateString())
        ->first();

    return view('student.dashboard', compact(
        'appointments',
        'nextAppointment'
    ));

})->middleware(['auth', 'role:user'])->name('student.dashboard');

Route::get('/student/appointments', [AppointmentController::class, 'index'])
    ->middleware(['auth', 'role:user'])
    ->name('student.appointments.index');

Route::get('/admin/dashboard', function () {

    $pendingCount = \App\Models\Appointment::where('status', 'Pending')->count();

    $approvedCount = \App\Models\Appointment::where('status', 'Approved')->count();

    $rejectedCount = \App\Models\Appointment::where('status', 'Rejected')->count();

    $recentAppointments = \App\Models\Appointment::with('user')
        ->orderBy('preferred_date', 'asc')
        ->orderBy('preferred_time', 'asc')
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'pendingCount',
        'approvedCount',
        'rejectedCount',
        'recentAppointments'
    ));

})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Admin Manage Appointments
Route::get('/admin/appointments', [AppointmentController::class, 'adminIndex'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.appointments.index');

// Approve Appointment
Route::patch('/admin/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.appointments.approve');

// Reject Appointment
Route::patch('/admin/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.appointments.reject');

// Create Appointment Form
Route::get('/student/appointments/create', [AppointmentController::class, 'create'])
    ->middleware(['auth', 'role:user'])
    ->name('student.appointments.create');

// Store Appointment
Route::post('/student/appointments', [AppointmentController::class, 'store'])
    ->middleware(['auth', 'role:user'])
    ->name('student.appointments.store');