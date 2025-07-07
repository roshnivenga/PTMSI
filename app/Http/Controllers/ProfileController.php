<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
{
    $user = $request->user();
    $hasEnrolments = \App\Models\Enrolment::where('user_id', $user->id)->exists();

    return view('profile.edit', [
        'user' => $user,
        'hasEnrolments' => $hasEnrolments,
    ]);
}
    /**
     * Update the user's profile information.
     */

public function update(ProfileUpdateRequest $request): RedirectResponse
{


    $user = $request->user();

    \Log::info($request->all());
    
    $data = $request->validated();

    $hasEnrolment = \App\Models\Enrolment::where('user_id', $user->id)->exists();

    // ✅ Force original values if enrolled
    if ($user->role === 'student' && $hasEnrolment) {
        $data['level'] = $user->level;
        $data['standard'] = $user->standard;
        $data['form'] = $user->form;
    }

    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    if ($request->hasFile('profile_photo')) {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePhoto(Request $request): RedirectResponse
{
    $request->validate([
        'profile_photo' => ['required', 'image', 'max:2048'],
    ]);

    $user = $request->user();

    if ($user->profile_photo_path) {
        Storage::disk('public')->delete($user->profile_photo_path);
    }

    $path = $request->file('profile_photo')->store('profile-photos', 'public');
    $user->profile_photo_path = $path;
    $user->save();

    return back()->with('status', 'profile-photo-updated');
}

}
