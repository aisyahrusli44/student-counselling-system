<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /* List all registered students with their appointment counts. */
    public function index(): View
    {
        $students = User::where('role', 'user')
            ->withCount([
                'appointments',
                'appointments as pending_count' => fn ($query) => $query->where('status', 'Pending'),
                'appointments as approved_count' => fn ($query) => $query->where('status', 'Approved'),
            ])
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('students'));
    }

    /* Show one student and their appointment history. */
    public function show(User $user): View
    {
        abort_if($user->role !== 'user', 404);

        $appointments = $user->appointments()
            ->with('user')
            ->orderBy('preferred_date', 'desc')
            ->orderBy('preferred_time', 'desc')
            ->get();

        return view('admin.users.show', compact('user', 'appointments'));
    }
}