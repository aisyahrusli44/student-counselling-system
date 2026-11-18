
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ReportController;

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

    // Pending requests first (they need action), then the newest submitted
    $recentAppointments = \App\Models\Appointment::with('user')
        ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
        ->latest()
        ->take(5)
        ->get();

        // Added for the UI refresh: student total and today's approved sessions
    $studentCount = \App\Models\User::where('role', 'user')->count();

    $todaySessions = \App\Models\Appointment::with('user')
        ->where('status', 'Approved')
        ->whereDate('preferred_date', now()->timezone('Asia/Kuala_Lumpur')->toDateString())
        ->orderBy('preferred_time', 'asc')
        ->get();

    return view('admin.dashboard', compact(
        'pendingCount',
        'approvedCount',
        'rejectedCount',
        'recentAppointments',
        'studentCount',
        'todaySessions'
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

/*
|--------------------------------------------------------------------------
| Pages added with the UI refresh
|--------------------------------------------------------------------------
*/

// Profile (students and admins)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Student: help & support, edit / cancel a pending appointment
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::view('/student/help', 'student.help')->name('student.help');

    Route::get('/student/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])
        ->name('student.appointments.edit');

    Route::put('/student/appointments/{appointment}', [AppointmentController::class, 'update'])
        ->name('student.appointments.update');

    Route::delete('/student/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('student.appointments.destroy');
});

// Admin: manage users and reports
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
});