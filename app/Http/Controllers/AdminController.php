<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Enrolment;

class AdminController extends Controller
{
public function index(Request $request)
{
    $query = User::query()->where('role', 'student'); // Adjust this line if your role logic differs

    // Optional search
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%');
        });
    }

    // Optional level filter
    if ($request->filled('level')) {
        $query->where('level', $request->level); // Make sure 'level' is stored correctly (e.g. 'primary', 'secondary')
    }

    if ($request->filled('payment')) {
    if ($request->payment == 'paid') {
        $query->whereHas('latestPayment', function ($payment_status) {
            $payment_status->where('paymentStatus', true); // or whatever your status column is
        });
    } elseif ($request->payment == 'unpaid') {
        $query->whereDoesntHave('latestPayment', function ($payment_status) {
            $payment_status->where('paymentStatus', true);
        });
    }
}

    // Optional sorting
    if ($request->filled('sort')) {
    switch ($request->sort) {
        case 'class':
            $query->orderByRaw("CASE WHEN level = 'primary' THEN standard ELSE form END ASC");
            break;

        case 'name':
        case 'level':
            $query->orderBy($request->sort);
            break;

        case 'payment':
            // Assuming you have a 'payment_status' field directly on the user model:
            $query->orderBy('payment_status'); 
            break;
    }
} else {
    $query->orderBy('name'); // default sort
}


    $students = $query->with('latestPayment')->paginate(10)->withQueryString();


    //dd($students->toArray());


    return view('admin.index', compact('students'));
}


    /**
     * Show detailed info for a single student.
     */
    public function viewStudent($id)
{
    $student = User::with(['enrolments.subject', 'payments', 'latestPayment'])->findOrFail($id);
    return view('admin.view', compact('student'));
}



public function listSubjects(Request $request)
{
    $level = $request->query('level'); // primary / secondary
    $classLevel = $request->query('class_level');
    $showAll = $request->has('show_all');

    $subjects = Subject::query()
        ->when(!$showAll && $level && $classLevel, function ($query) use ($level, $classLevel) {
            $query->where('level', $level)
                  ->where('class_level', $classLevel);
        })
        ->whereHas('enrolments')
        ->orderBy('name')
        ->get();

    return view('admin.subjects.index', [
        'subjects' => $subjects,
        'level' => $level,
        'classLevel' => $classLevel,
        'showAll' => $showAll,
    ]);
}




public function viewSubject($slug)
{
    $subject = Subject::where('slug', $slug)->firstOrFail();

    $enrolments = Enrolment::with('user')
        ->where('subject_id', $subject->id)
        ->get();

    return view('admin.subjects.view', compact('subject', 'enrolments'));
}

public function deleteSubjectEnrolments($slug)
{
    $subject = Subject::where('slug', $slug)->firstOrFail();

    Enrolment::where('subject_id', $subject->id)->delete();

    return redirect()->route('admin.subjects.index', ['slug' => $slug])->with('status', 'All enrolments deleted successfully.');
}


public function deleteUser($id)
{
    $user = \App\Models\User::findOrFail($id);

    // Optional: delete related enrolments, payments, etc. before deleting the user
    $user->delete();

    return redirect()->route('admin.index')->with('status', 'User profile deleted successfully.');
}

public function userSelection()
{
    return view('admin.user-selection');
}

public function tutorIndex(Request $request)
{
    $query = User::query()->where('role', 'tutor');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%')
              ->orWhere('phone', 'like', '%' . $request->search . '%');
        });
    }

    $tutors = $query->orderBy('name')->paginate(10)->withQueryString();

    return view('admin.index-tutors', compact('tutors'));
}


public function viewTutor($id)
{
    $tutor = User::where('role', 'tutor')->findOrFail($id);
    return view('admin.view-tutors', compact('tutor'));
}

public function deleteTutor($id)
{
    $tutor = User::where('role', 'tutor')->findOrFail($id);
    $tutor->delete();

    return redirect()->route('admin.index.tutors')->with('status', 'Tutor profile deleted successfully.');
}


}
