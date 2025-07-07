<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Enrolment;
use App\Models\Payment;
use App\Models\Survey;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // 1. Students registered this month
        $monthlyRegisteredStudents = User::where('role', 'student')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        // 2. Total students
        $totalStudents = User::where('role', 'student')->count();

        // 3. Total tutors
        $totalTutors = User::where('role', 'tutor')->count();

        // 4. Outstanding fees
        $studentsWithOutstandingFees = User::where('role', 'student')
            ->whereDoesntHave('payments', function($query) use ($currentMonth, $currentYear) {
                $query->whereYear('paymentDate', $currentYear)
                      ->whereMonth('paymentDate', $currentMonth)
                      ->where('paymentStatus', 1);
            })->count();

        // 5. Survey count
        $studentsWithSurvey = Survey::distinct('user_id')->count('user_id');

        // 6. Class with most students
        $mostEnrolledClass = Enrolment::select('subject_id')
            ->groupBy('subject_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        return view('admin.dashboard', compact(
            'monthlyRegisteredStudents',
            'totalStudents',
            'totalTutors',
            'studentsWithOutstandingFees',
            'studentsWithSurvey',
            'mostEnrolledClass'
        ));
    }
}
