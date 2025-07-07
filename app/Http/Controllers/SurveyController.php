<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Models\Survey;  
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function showSurvey()
    {
        if ($redirect = $this->checkFormEligibility()) {
            return $redirect;
        }

        $questions = SurveyQuestion::all();
        return view('student.survey', compact('questions'));
    }

    public function submitSurvey(Request $request)
    {
        if ($redirect = $this->checkFormEligibility()) {
            return $redirect;
        }

        $answers = $request->input('answers');
        $scores = [];

        foreach ($answers as $questionId => $answer) {
            if ($answer === 'yes') {
                $category = SurveyQuestion::find($questionId)->category;
                $scores[$category] = ($scores[$category] ?? 0) + 1;
            }
        }

        arsort($scores);
        $topCategory = array_key_first($scores);
        $recommendation = config('career_recommendations')[$topCategory] ?? null;

        
        Survey::create([
            'user_id' => auth()->id(),
            'top_category' => $topCategory,
            'scores' => $scores,
            'submitted_at' => now(),
        ]);

        return view('student.survey-result', compact('recommendation', 'scores'));
    }

    /**
     * 
     */
    private function checkFormEligibility()
    {
        $userForm = auth()->user()->form;

        if (!in_array($userForm, ['Form 4', 'Form 5'])) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Career Survey is only available to Form 4 and Form 5 students.');
        }

        return null;
    }
}
