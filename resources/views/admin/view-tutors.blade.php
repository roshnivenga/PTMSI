<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-[#003a8c] font-serif">Tutor Profile</h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 font-serif ptmsi-margin mt-24">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden shadow-xl sm:rounded-lg border border-[#003a8c]/20">
            <!-- Tutor Header -->
            <div class="bg-[#003a8c] px-6 py-4 text-white flex items-center space-x-4">
                <div class="p-2 rounded-full">
                    @if($tutor->profile_photo_path)
                        <img src="{{ asset('storage/' . $tutor->profile_photo_path) }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover shadow-md">
                    @else
                        <div class="bg-yellow-300 text-[#003a8c] p-5 rounded-full">
                            <i class="fas fa-user-tie text-2xl"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-bold">{{ $tutor->name }}</h3>
                    <p class="text-blue-100">{{ $tutor->email }}</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white p-5 rounded-lg shadow border-l-4 border-[#003a8c]">
                    <h3 class="text-lg font-semibold text-[#003a8c] mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Personal Information
                    </h3>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex">
                            <span class="w-24 text-gray-600 font-medium">Name:</span>
                            <span>{{ $tutor->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 text-gray-600 font-medium">Email:</span>
                            <span>{{ $tutor->email }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 text-gray-600 font-medium">Phone:</span>
                            <span>{{ $tutor->phone ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Subjects Section -->
               

                <!-- Classes Section -->
                
                <!-- Back Button -->
                <div class="flex justify-center gap-4">
                    <a href="{{ route('admin.index.tutors') }}" class="px-5 py-2 bg-[#003a8c] text-white rounded-lg hover:bg-yellow-300 hover:text-[#003a8c] t transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Student List
                    </a>

                     <form action="{{ route('admin.tutors.delete', $tutor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center">
            <i class="fas fa-trash mr-2"></i> Delete Profile
        </button>
    </form>
            </div>
        </div>
    </div>
</x-app-layout>