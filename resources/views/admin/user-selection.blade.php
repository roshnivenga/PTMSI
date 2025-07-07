<x-app-layout>
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 font-serif mt-36">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Header with icon -->


            <!-- Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Student Card -->
                 <a href="{{ route('admin.index') }}"
               class="group relative bg-gradient-to-br from-[#003a8c] to-[#002766] text-yellow-300 hover:shadow-2xl transition-all duration-500 rounded-2xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
                <div class="p-24 flex flex-col h-full">
                    <div class="z-10 relative">
                        <h3 class="text-2xl font-bold font-serif mb-4">Students</h3>
                    </div>
                </div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/always-grey.png')] opacity-10"></div>
            </a>

                <!-- Tutor Card -->
                 <a href="{{ route('admin.index.tutors') }}"
               class="group relative bg-gradient-to-br from-[#003a8c] to-[#002766] text-yellow-300 hover:shadow-2xl transition-all duration-500 rounded-2xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer">
                <div class="p-24 flex flex-col h-full">
                    <div class="z-10 relative">
                        <h3 class="text-2xl font-bold font-serif mb-4">Tutors</h3>
                    </div>
                </div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/always-grey.png')] opacity-10"></div>
            </a>
            </div>

            <!-- Additional Options (optional) -->
        </div>
    </div>
</x-app-layout>