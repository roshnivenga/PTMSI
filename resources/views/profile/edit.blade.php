<x-app-layout>
    <div class="py-16 px-4 md:px-12 text-gray-800 font-serif ">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 mt-12">

            {{-- Left: Profile Picture & Basic Info --}}
          <div class="md:col-span-1 bg-white bg-opacity-90 p-8 rounded-3xl shadow-xl border border-yellow-200 flex flex-col items-center text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
    <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data" class="flex flex-col items-center w-full">
        @csrf
        @method('PATCH')
        <div class="relative w-40 h-40 rounded-full group">
            <img src="{{ $user->profile_photo_path && file_exists(public_path('storage/' . $user->profile_photo_path)) 
                ? asset('storage/' . $user->profile_photo_path) 
                : asset('images/default-avatar.png') }}" 
                class="w-full h-full rounded-full object-cover border-4 border-yellow-400 shadow-lg transition-transform duration-300 group-hover:scale-105">
            <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="this.form.submit()">
            <label for="profile_photo" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                <span class="text-white text-sm font-semibold">Change</span>
            </label>
        </div>
        
        <label for="profile_photo" class="inline-flex items-center justify-center px-8 py-3 mt-6 text-sm font-semibold text-black bg-yellow-400 rounded-full shadow-lg hover:bg-yellow-500 transition-colors duration-300 cursor-pointer transform hover:scale-105">
            Upload New Photo
        </label>
        @error('profile_photo')
            <p class="text-sm text-red-600 mt-3 font-sans">{{ $message }}</p>
        @enderror
    </form>

    <div class="mt-8 border-t border-blue-100 pt-6 text-center w-full"> {{-- Changed to text-center for consistency --}}
        <p class="text-2xl font-bold text-[#003a8c]">{{ $user->name }}</p>
        <p class="text-md text-gray-600 mt-1">{{ $user->email }}</p>
        
        @if($user->role)
            <span class="inline-block mt-3 px-4 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full shadow-inner">
                {{ ucfirst($user->role) }}
            </span>
        @endif


        {{-- Additional Details --}}

        <div class="mt-6 text-base space-y-3 text-gray-700 text-left"> {{-- Changed to text-left for readability --}}

            <div class="flex items-center justify-between py-2 border-b border-blue-50 last:border-b-0">
                <span class="font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21L9.5 12.5a10 10 0 005 5l1.424-.712a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.717 21 3 14.283 3 6V5z"></path></svg>
                    Phone:
                </span>
                <span class="font-medium">{{ $user->phone ?? 'N/A' }}</span>
            </div>

            <div class="flex items-center justify-between py-2 border-b border-blue-50 last:border-b-0">
                <span class="font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.32 0 2.502.81 3.092 2H10a2 2 0 01-2-2z"></path></svg>
                    IC:
                </span>
                <span class="font-medium">{{ $user->ic ?? 'N/A' }}</span>
            </div>

            @if(auth()->user()->role == 'student')
            <div class="flex items-center justify-between py-2 border-b border-blue-50 last:border-b-0">
                <span class="font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    School Level:
                </span>
                <span class="font-medium">{{ $user->level ?? 'N/A' }}</span>
            </div>

            @if($user->level === 'Primary')
                <div class="flex items-center justify-between py-2 border-b border-blue-50 last:border-b-0">
                    <span class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 5h18a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                        Standard:
                    </span>
                    <span class="font-medium">{{ $user->standard ?? 'N/A' }}</span>
                </div>
            @elseif($user->level === 'Secondary')
                <div class="flex items-center justify-between py-2 border-b border-blue-50 last:border-b-0">
                    <span class="font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Form:
                    </span>
                    <span class="font-medium">{{ $user->form ?? 'N/A' }}</span>
                </div>
            @endif
          @endif
        </div>
    </div>
</div>
            {{-- Right: Forms Section --}}
            <div class="md:col-span-3 bg-white bg-opacity-90 p-8 rounded-3xl shadow-xl border border-yellow-200 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">

                {{-- Profile Information --}}
                <h2 class="text-2xl font-bold text-[#003a8c] mb-6 border-b pb-3 border-blue-100">Personal Details</h2>
                @if (session('status') === 'profile-updated')
    <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
    Your profile has been updated successfully.
    </div>
@endif
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    @php
            $inputClasses = 'mt-1 block w-full bg-white border border-yellow-400 rounded-md shadow-sm focus:outline-none focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400 focus:ring-offset-0';
        @endphp

                    {{-- Name, Email, Phone, Address --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input id="name" name="name" type="text" class="{{ $inputClasses }}" value="{{ old('name', $user->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email Address" />
                            <x-text-input id="email" name="email" type="email" class="{{ $inputClasses }}" value="{{ old('email', $user->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Phone Number" />
                            <x-text-input id="phone" name="phone" type="text" class="{{ $inputClasses }}" value="{{ old('phone', $user->phone) }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                           <x-input-label for="ic" value="Identification Number (IC)" />
                            <x-text-input id="ic" name="ic" type="text" class="{{ $inputClasses }}" value="{{ old('ic', $user->ic) }}" />
                            <x-input-error :messages="$errors->get('ic')" class="mt-2" />

                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="address" value="Residential Address" />
                            <textarea id="address" name="address" rows="3" class="{{ $inputClasses }}">{{ old('address', $user->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>
 @php
    $hasEnrolment = \App\Models\Enrolment::where('user_id', auth()->id())->exists();
    @endphp
@if(auth()->user()->role === 'student')

                    {{-- School Level --}}
         <div x-data="{ level: '{{ old('level', $user->level) }}' }">
    <x-input-label for="level" value="School Level" class="mt-4" />
    <select id="level" name="level" x-model="level" 
        class="{{ $inputClasses }}"
        @if($hasEnrolments) disabled @endif>
        <option value="">Select level</option>
        <option value="Primary" {{ $user->level === 'Primary' ? 'selected' : '' }}>Primary School</option>
        <option value="Secondary" {{ $user->level === 'Secondary' ? 'selected' : '' }}>Secondary School</option>
    </select>
    <x-input-error :messages="$errors->get('level')" class="mt-2" />

    {{-- Primary --}}
    <div x-show="level === 'Primary'" class="mt-4">
        <x-input-label for="standard" value="Which Standard?" />
        <select name="standard" class="{{ $inputClasses }}" @if($hasEnrolments) disabled @endif>
            <option value="">Select standard</option>
            @for ($i = 1; $i <= 6; $i++)
                <option value="Standard {{ $i }}" {{ $user->standard === 'Standard '.$i ? 'selected' : '' }}>Standard {{ $i }}</option>
            @endfor
        </select>
    </div>

    {{-- Secondary --}}
    <div x-show="level === 'Secondary'" class="mt-4">
        <x-input-label for="form" value="Which Form?" />
        <select name="form" class="{{ $inputClasses }}" @if($hasEnrolment) disabled @endif>
            <option value="">Select form</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="Form {{ $i }}" {{ $user->form === 'Form '.$i ? 'selected' : '' }}>Form {{ $i }}</option>
            @endfor
        </select>
    </div>
</div>
@endif

                    <div class="flex justify-end pt-6">
                        <x-primary-button>Save Changes</x-primary-button>
                    </div>
                </form>

                {{-- Password Update --}}
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-[#003a8c] mb-6 border-b pb-3 border-yellow-100">Change Password</h2>
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="current_password" value="Current Password" />
                            <x-text-input id="current_password" name="current_password" type="password" class="{{ $inputClasses }}" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="New Password" />
                            <x-text-input id="password" name="password" type="password" class="{{ $inputClasses }}" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Confirm New Password" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="{{ $inputClasses }}" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>Update Password</x-primary-button>
                        </div>
                    </form>

                    

                </div>

                {{-- Delete Account --}}
                @if(auth()->user()->role == 'admin')
                <div class="mt-16 border-t border-blue-100 pt-8">
                    <h3 class="text-2xl font-bold text-red-700 mb-4">Danger Zone: Delete Account</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Once your account is deleted, all your data will be permanently removed. This action cannot be undone.
                    </p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="px-8 py-3 bg-red-600 text-white rounded-full font-bold shadow-md hover:bg-red-700 transition duration-300" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            Delete Account
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
