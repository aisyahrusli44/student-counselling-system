<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    /* Purposes offered on the booking form; anything else counts as "Other". */
    private const PURPOSES = [
        'Academic Issues',
        'Personal Issues',
        'Career Guidance',
        'Family Issues',
    ];

    public function index(): View
    {
        $appointments = Appointment::get(['status', 'purpose', 'preferred_date', 'user_id']);

        $total = $appointments->count();

        // Requests by status
        $byStatus = collect(['Pending', 'Approved', 'Rejected'])
            ->mapWithKeys(fn ($status) => [$status => $appointments->where('status', $status)->count()]);

        // Approval rate = approved / processed (approved + rejected)
        $processed = $byStatus['Approved'] + $byStatus['Rejected'];
        $approvalRate = $processed > 0 ? round($byStatus['Approved'] / $processed * 100) : null;

        // Requests by purpose (custom "Other" text is grouped as Other)
        $byPurpose = array_fill_keys(array_merge(self::PURPOSES, ['Other']), 0);
        foreach ($appointments as $appointment) {
            $key = in_array($appointment->purpose, self::PURPOSES, true) ? $appointment->purpose : 'Other';
            $byPurpose[$key]++;
        }
        arsort($byPurpose);

        // Requests per month for the last 6 months (by preferred date)
        $start = now()->timezone('Asia/Kuala_Lumpur')->startOfMonth()->subMonths(5);
        $byMonth = [];
        for ($i = 0; $i < 6; $i++) {
            $byMonth[$start->copy()->addMonths($i)->format('Y-m')] = 0;
        }
        foreach ($appointments as $appointment) {
            $month = substr((string) $appointment->preferred_date, 0, 7);
            if (array_key_exists($month, $byMonth)) {
                $byMonth[$month]++;
            }
        }

        $studentCount = User::where('role', 'user')->count();
        $activeStudents = $appointments->pluck('user_id')->unique()->count();

        return view('admin.reports.index', compact(
            'total',
            'byStatus',
            'approvalRate',
            'byPurpose',
            'byMonth',
            'studentCount',
            'activeStudents'
        ));
    }
}