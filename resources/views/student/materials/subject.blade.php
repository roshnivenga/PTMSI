<x-app-layout>
    <x-slot name="header">
        <div class="py-4 border-b border-[#003a8c]/20 text-center md:text-left animate-fade-in-down">
            <h2 class="text-4xl font-extrabold text-[#003a8c] font-serif leading-tight drop-shadow-sm">
                {{ $subject->name }} Learning Materials
            </h2>
            <p class="mt-2 text-lg text-gray-600 italic">Manage and access all teaching resources for this subject</p>
            <div class="w-24 h-1 bg-yellow-400 mx-auto md:mx-0 rounded-full mt-4"></div>
        </div>
    </x-slot>

    <div class="py-12 px-4 md:px-12 text-gray-800 min-h-screen font-serif mt-24 ptmsi-margin">
        <div class="max-w-7xl mx-auto">
            @if ($materials->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl shadow-xl border border-yellow-200 animate-fade-in-up transform hover:scale-[1.01] transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-yellow-500 mb-6 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-4 text-3xl font-bold text-[#003a8c] mb-2">No materials uploaded yet!</h3>
                    <p class="text-lg text-gray-600">It looks a little empty here. Let your tutor know!</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-[#003a8c]/15 mt-8 transform transition-all duration-300 hover:scale-[1.005]">
                    <div class="grid grid-cols-12 px-6 py-4 bg-[#003a8c] text-yellow-200 font-bold text-lg rounded-t-2xl shadow-md">
                        <div class="col-span-6 flex items-center space-x-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Available Materials ({{ $materials->count() }})</span>
                        </div>
                        <div class="col-span-2 text-center">Uploaded</div>
                        <div class="col-span-2 text-center">Type</div>
                        <div class="col-span-2 text-right">Action</div>
                    </div>

                    <ul class="divide-y divide-[#003a8c]/10">
                        @foreach ($materials as $index => $material)
                            @php
                                $fileUrl = asset('storage/' . $material->file_path);
                                $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp

                            <li class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#f8fafd]' }} hover:bg-[#e6effa] transition-colors duration-200">
                                <div class="grid grid-cols-12 items-center px-6 py-4">
                                    <div class="col-span-6 flex items-center min-w-0">
                                        @if ($isImage)
                                            <img src="{{ $fileUrl }}" alt="Material Preview" class="h-14 w-14 rounded-lg border-2 border-yellow-300 shadow-md object-cover flex-shrink-0" />
                                        @else
                                            <div class="h-14 w-14 bg-[#003a8c] flex items-center justify-center rounded-lg shadow-md flex-shrink-0">
                                                <svg class="h-8 w-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    @if ($ext === 'pdf')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.5 4.5l-3 3m0 0l-3-3m3 3v-6m0 10.5h.01M16 12H8m6 4H8m0 4h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    @else
                                                        {{-- Generic file icon --}}
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    @endif
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="ml-4 min-w-0 flex-grow">
                                            <a href="{{ $fileUrl }}"
                                               class="text-xl font-semibold text-[#003a8c] hover:text-yellow-700 transition-colors duration-200 truncate block leading-tight"
                                               target="_blank"
                                               title="{{ basename($material->file_path) }}">
                                                {{ basename($material->file_path) }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1 truncate">{{ $material->description ?? 'No description available.' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-span-2 text-sm text-gray-600 text-center">
                                        <span class="font-medium block">{{ $material->created_at->format('M d, Y') }}</span>
                                        <span class="text-xs">{{ $material->created_at->format('h:i A') }}</span>
                                    </div>

                                    <div class="col-span-2 text-center">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-200 text-yellow-900 border border-yellow-300 shadow-sm">
                                            {{ strtoupper($ext) }}
                                        </span>
                                    </div>

                                    <div class="col-span-2 text-right">
                                        <a href="{{ $fileUrl }}" download
                                           class="inline-flex items-center px-4 py-2 bg-yellow-400 text-[#003a8c] hover:bg-[#003a8c] hover:text-yellow-300 rounded-full font-bold text-sm transition-all duration-200 shadow-md transform hover:scale-105">
                                            <svg class="h-5 w-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>