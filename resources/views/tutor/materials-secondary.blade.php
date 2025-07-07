<x-app-layout>
    <x-slot name="header">
        <div class="py-4 border-b border-[#003a8c]/20 text-center md:text-left animate-fade-in-down">
            <h2 class="text-4xl font-extrabold text-[#003a8c] font-serif leading-tight drop-shadow-sm">
                {{ __('Secondary Level Subjects') }}
            </h2>
            <p class="mt-2 text-lg text-gray-600 italic">Browse and manage materials organized by class level.</p>
            <div class="w-24 h-1 bg-yellow-400 mx-auto md:mx-0 rounded-full mt-4"></div>
        </div>
    </x-slot>

    <div class="py-12 px-4 md:px-12 text-gray-800 min-h-screen font-serif mt-24">
        <div class="max-w-7xl mx-auto">
            <form method="GET" action="{{ route('tutor.materials.secondary') }}" class="mb-12">
                <div class="max-w-md mx-auto md:mx-0 bg-white p-6 rounded-xl shadow-lg border border-blue-200 animate-fade-in-up">
                    <label for="class_level" class="block text-lg font-semibold text-[#003a8c] mb-3">Choose Form</label>
                    <div class="relative">
                        <select name="class_level" id="class_level" onchange="this.form.submit()"
                                class="block w-full px-5 py-3 border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-base font-medium transition duration-200 ease-in-out appearance-none bg-white pr-10">
                            <option value="" selected>-- Select Form --</option>
                            @foreach ([1 => 'Form 1', 2 => 'Form 2', 3 => 'Form 3', 4 => 'Form 4', 5 => 'Form 5'] as $value => $label)
                                <option value="{{ $value }}" {{ request('class_level') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

           <div class="mt-10">
    @if (request('class_level') == null || request('class_level') == '')
        <div class="text-center py-16 bg-white rounded-2xl shadow-xl border border-blue-200 animate-fade-in-up transform hover:scale-[1.01] transition-all duration-300">
            <svg class="h-20 w-20 mx-auto text-yellow-500 mb-6 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-4 text-3xl font-bold text-[#003a8c] mb-2">Select a Standard</h3>
            <p class="text-lg text-gray-600">Please choose a standard from the dropdown above to view available subjects.</p>
        </div>
    @elseif ($secondarySubjects->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-xl border border-blue-200 animate-fade-in-up transform hover:scale-[1.01] transition-all duration-300">
            <svg class="h-20 w-20 mx-auto text-yellow-500 mb-6 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-4 text-3xl font-bold text-[#003a8c] mb-2">No subjects found!</h3>
            <p class="text-lg text-gray-600">No subjects match the selected filter or none have been added yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in-up delay-200">
            @foreach ($secondarySubjects as $subject)
                <a href="{{ route('tutor.secondary.materials.view', ['slug' => $subject->slug]) }}"
                   class="block bg-white rounded-2xl shadow-xl overflow-hidden border border-blue-200 
                          hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] group">
                    <div class="bg-[#003a8c] text-yellow-300 p-5 flex items-center justify-between">
                        <h3 class="text-2xl font-bold leading-tight">{{ $subject->name }}</h3>
                        <span class="text-lg font-semibold text-yellow-100 px-3 py-1 bg-yellow-600 rounded-full shadow-inner">
                            Form {{ $subject->class_level }}
                        </span>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $subject->description ?? 'Explore comprehensive learning materials and resources for this subject.' }}
                        </p>
                        <div class="inline-flex items-center px-6 py-3 bg-yellow-400 text-[#003a8c] hover:bg-[#003a8c] hover:text-yellow-300 
                                    rounded-full font-bold transition-all duration-300 shadow-md transform group-hover:scale-105">
                            Manage Materials
                            <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>


            <template x-if="selectedStandard === null || selectedStandard === ''">
                    <div class="text-center py-16 bg-white rounded-2xl shadow-xl border border-blue-200 animate-fade-in-up transform hover:scale-[1.01] transition-all duration-300">
                        <svg class="h-20 w-20 mx-auto text-yellow-500 mb-6 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h3 class="mt-4 text-3xl font-bold text-[#003a8c] mb-2">Select a Standard</h3>
                        <p class="text-lg text-gray-600">Please choose a standard from the dropdown above to view available subjects.</p>
                    </div>
                </template>

        </div>
    </div>
</x-app-layout>