<x-app-layout>
    <div class="py-16 px-4 md:px-12 text-gray-800 min-h-screen font-serif">
        <div class="max-w-7xl mx-auto">

            @php
                $subjectCount = count($subjects);
                $gridClass = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4'; // Default to 4 columns on large screens
                $justifyClass = ''; // Default to no specific justification
            
                if ($subjectCount === 1) {
                    $gridClass = 'grid-cols-1';
                    $justifyClass = 'justify-center'; // Center the single item
                } elseif ($subjectCount === 2) {
                    $gridClass = 'grid-cols-1 sm:grid-cols-2';
                    $justifyClass = 'justify-center'; // Center 2 items on larger screens if they don't fill a row naturally
                } elseif ($subjectCount === 3) {
                    $gridClass = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3';
                    $justifyClass = 'lg:justify-center'; // Center 3 items on large screens
                }
            @endphp

            <div class="grid {{ $gridClass }} gap-8 p-6 mt-10 {{ $justifyClass }} auto-rows-fr mt-24">
                @forelse($subjects as $subject)
                    <a href="{{ route('student.materials.subject', $subject->id) }}"
                       class="relative flex flex-col items-center justify-center p-8 bg-[#003a8c] text-yellow-300 rounded-2xl shadow-xl 
                              hover:bg-[#002a6c] hover:shadow-2xl transition-all duration-300 transform 
                              hover:-translate-y-2 hover:scale-[1.02] border border-[#003a8c]/50 overflow-hidden group min-h-[180px]">
                        
                        <div class="absolute inset-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                        <div class="mb-4 text-5xl text-yellow-300 group-hover:text-yellow-200 transition-colors duration-300 drop-shadow-lg">
                            <h2 class="text-3xl font-extrabold text-center leading-tight tracking-wide transition-colors duration-300">
                            {{ $subject->name }}
                            </h2>
                        </div>
                        
                        
                        <div class="absolute bottom-4 right-4 text-yellow-300 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-2xl shadow-lg text-gray-700">
                        <p class="text-xl font-semibold mb-4">No subjects enrolled yet!</p>
                        <p class="text-md">Please contact administration to enroll in subjects.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>