<x-app-layout>
@php
    $currentDay = now()->day;
    $hasEnrolledBefore = \App\Models\Enrolment::where('user_id', auth()->id())->exists();
     $hasPaidThisMonth = \App\Models\Payment::where('user_id', auth()->id())
        ->whereMonth('paymentDate', now()->month)
        ->whereYear('paymentDate', now()->year)
        ->exists();
    $editingOpen = $currentDay <= 7 || !$hasEnrolledBefore;
    $editingOpen = ($currentDay <= 7 && !$hasPaidThisMonth) || !$hasEnrolledBefore;
@endphp



    {{-- Toast Notifications (for errors/validation only) --}}
    @if(session('error') || $errors->any())
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-transition 
        class="fixed top-6 right-6 z-50 space-y-2"
    >
        @if(session('error'))
        <div class="flex items-center px-5 py-3 rounded-xl shadow-lg bg-red-600 text-white space-x-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="flex items-center px-5 py-3 rounded-xl shadow-lg bg-red-500 text-white space-x-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-sm font-medium">There were some errors. Please check your inputs.</span>
        </div>
        @endif
    </div>
    @endif

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="min-h-screen bg-gradient-to-b from-yellow-100 via-blue-50 to-blue-200 px-4 sm:px-6 lg:px-8 py-10 pb-32 font-serif relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-[#003a8c] tracking-tight mb-3">Subject Enrollment</h1>
                <div class="inline-block bg-[#003a8c] text-yellow-300 px-5 py-2 rounded-full shadow-md border border-yellow-300/40 transform transition hover:scale-105 backdrop-blur-sm">
                    <span class="text-lg font-medium tracking-wide">
                        @if($academicLevel === 'primary')
                            Standard {{ $classLevel }}
                        @else
                            Form {{ $classLevel }}
                        @endif
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('enrolment.store') }}">
                @csrf

                @if(!empty($enrolledSubjects) && count($enrolledSubjects))
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[#003a8c] mb-6 flex items-center">
                        <span class="bg-[#003a8c] text-white rounded-full w-7 h-7 flex items-center justify-center mr-3 text-sm shadow-inner">✓</span>
                        Your Registered Subjects
                        <span class="ml-auto text-sm font-medium bg-[#003a8c]/10 text-[#003a8c] px-3 py-1 rounded-full">
                           {{ count($enrolledSubjects ?? []) }} selected
                        </span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($enrolledSubjects as $subject)
                        <div class="relative group">
                            <div class="relative bg-gradient-to-br from-[#fffbe6] via-white to-[#e6f7ff] rounded-2xl shadow-md overflow-hidden border-2 border-[#003a8c]/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                <div class="p-6">
                                    <div class="flex items-start">
                                        <div class="bg-[#003a8c]/10 p-2 rounded-lg mr-4 shadow-inner">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-[#003a8c]">
  <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
</svg>



                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-[#003a8c]">{{ $subject->name }}</h3>
                                            <p class="text-sm text-gray-700 mt-1">{{ $subject->day }} • {{ $subject->time }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/80 px-5 py-3 flex items-center justify-between border-t border-[#003a8c]/10 backdrop-blur-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Enrolled
                                    </span>
                                    @if($editingOpen)
                                    <label class="cursor-pointer flex items-center space-x-2 remove-btn">
                                        <input type="checkbox" 
                                               name="subjects[]" 
                                               value="{{ $subject->id }}" 
                                               checked 
                                               class="form-checkbox h-5 w-5 text-[#003a8c] rounded border-gray-300 focus:ring-[#003a8c] subject-checkbox sr-only">

                                        <span class="px-4 py-1.5 bg-red-100/90 text-red-700 rounded-full text-sm font-medium hover:bg-red-200 transition shadow-sm flex items-center remove-label">
                                            <span class="text">Remove Subject</span>
                                        </span>
                                    </label>
                                    @else
                                    <span class="text-s font-bold text-gray-400 italic">Editing locked</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                @endif

                {{-- Available Subjects --}}
                <div class="mb-20">
                    <h2 class="text-2xl font-bold text-[#003a8c] mb-6">
                        Available Subjects
                        <span class="ml-2 text-sm font-medium bg-[#003a8c]/10 text-[#003a8c] px-3 py-1 rounded-full">
                       {{ count($availableSubjects ?? []) }} available
                        </span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableSubjects as $subject)
                        <div class="relative group">
                            <div class="relative bg-gradient-to-br from-[#fffbe6] via-white to-[#e6f7ff] rounded-2xl shadow-sm overflow-hidden border border-[#003a8c]/20 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                                <div class="p-6">
                                    <div class="flex items-start">
                                        <div class="bg-[#003a8c]/10 p-2 rounded-lg mr-4 shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-[#003a8c]">
  <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
</svg>

                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-[#003a8c]">{{ $subject->name }}</h3>
                                            <p class="text-sm text-gray-700 mt-1">{{ $subject->day }} • {{ $subject->time }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/80 px-5 py-3 flex justify-end border-t border-[#003a8c]/10 backdrop-blur-sm">
                                    @if($editingOpen)
                                    <label class="inline-flex items-center cursor-pointer transition-all hover:scale-105">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="form-checkbox h-5 w-5 text-[#FFD700] rounded border-gray-300 focus:ring-[#FFD700]">
                                        <span class="ml-2 text-sm font-medium text-gray-700">Select</span>
                                    </label>
                                    @else
                                    <span class="text-s font-bold text-gray-400 italic">Editing locked</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                {{-- Submit or Lock Message --}}
                @if($editingOpen)
                <div class="fixed bottom-8 left-0 right-0 flex justify-center">
                    <button type="submit" class="px-8 py-3 bg-[#003a8c] text-white rounded-full font-semibold hover:bg-[#FFD700] hover:text-[#003a8c] shadow-lg transition flex items-center hover:shadow-xl transform hover:-translate-y-1">
                        Confirm Subjects
                    </button>
                </div>
                @else
                <div class="fixed bottom-8 left-0 right-0 flex justify-center">
                    <p class="text-lg font-bold text-gray-500 bg-white px-6 py-3 rounded-full shadow-sm border border-gray-300">
                        Subject editing is locked after the 7th of each month.
                    </p>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Toggle "Remove Subject" to "Undo" --}}
    <script>
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function () {
                const checkbox = this.querySelector('.subject-checkbox');
                const label = this.querySelector('.remove-label');

                checkbox.checked = !checkbox.checked;

                if (!checkbox.checked) {
                    checkbox.classList.remove('sr-only');
                    label.textContent = "Undo Remove";
                    label.classList.remove('bg-red-100/90', 'text-red-700');
                    label.classList.add('bg-yellow-100', 'text-yellow-700');
                } else {
                    checkbox.classList.add('sr-only');
                    label.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142..." />
                        </svg>
                        Remove Subject
                    `;
                    label.classList.add('bg-red-100/90', 'text-red-700');
                    label.classList.remove('bg-yellow-100', 'text-yellow-700');
                }
            });
        });
    </script>
</x-app-layout>
