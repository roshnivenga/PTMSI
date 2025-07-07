<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
  public function rules(): array
{
    $user = $this->user();
    $hasEnrolment = \App\Models\Enrolment::where('user_id', $user->id)->exists();

    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['required', 'regex:/^\d{10,11}$/'],
        'address' => ['required', 'string', 'max:255'],
        'ic' => ['required', 'regex:/^\d{12}$/'],
        'profile_photo' => ['nullable', 'image', 'max:2048'],
    ];

    // Only allow level/form/standard before enrolment
   if ($user->role === 'student' && !$hasEnrolment) {
    $rules['level'] = ['required', 'string'];

    if ($this->input('level') === 'Primary') {
        $rules['standard'] = ['required', 'string'];
        $rules['form'] = ['nullable'];
    } elseif ($this->input('level') === 'Secondary') {
        $rules['form'] = ['required', 'string'];
        $rules['standard'] = ['nullable'];
    }
}

    


    return $rules;
}

public function messages()
{
    return [
        'level.prohibited' => 'You cannot change your academic level after enrolling.',
        'standard.prohibited' => 'Standard cannot be changed after enrolment.',
        'form.prohibited' => 'Form cannot be changed after enrolment.',
    ];
}

}
