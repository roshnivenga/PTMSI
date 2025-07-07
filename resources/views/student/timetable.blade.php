<x-app-layout>
    <div class="py-16 px-4 md:px-12 text-gray-800 min-h-screen font-serif">
        <div class="max-w-7xl mx-auto mt-24">

            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                $timeSlots = $subjects->pluck('time')->unique()->sort()->values()->toArray();
                
                $subjectsByTimeDay = [];
                foreach ($subjects as $subject) {
                    $subjectsByTimeDay[$subject->time][$subject->day][] = $subject->name;
                }
            @endphp

            <div class="overflow-x-auto rounded-2xl shadow-2xl border border-[#003a8c]/15 mt-16 bg-white transform transition-all duration-300 hover:scale-[1.005]">
                <table class="min-w-full table-fixed border-collapse">
                    <thead>
                        <tr class="bg-[#003a8c] text-yellow-200 shadow-md">
                            <th class="w-40 px-6 py-4 border-r border-[#003a8c]/50 font-bold text-xl text-left sticky left-0 bg-[#003a8c] z-20 rounded-tl-2xl">Day / Time</th>
                            @foreach($timeSlots as $time)
                                <th class="px-6 py-4 border-r border-[#003a8c]/50 last:border-r-0 font-bold text-lg whitespace-nowrap">{{ $time }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $index => $day)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#f0f6fc]' }} duration-200">
                                <td class="px-6 py-4 border-r border-t border-[#003a8c]/10 text-[#003a8c] font-extrabold whitespace-nowrap sticky left-0 {{ $index % 2 === 0 ? 'bg-white' : 'bg-[#f0f6fc]' }} z-10 text-lg">
                                    {{ $day }}
                                </td>
                                @foreach($timeSlots as $time)
                                    <td class="px-4 py-3 border-r border-t border-[#003a8c]/10 last:border-r-0 align-top">
                                        @if(isset($subjectsByTimeDay[$time][$day]))
                                            <div class="flex flex-col space-y-2">
                                            <div class="flex flex-col space-y-2 w-full">
    @foreach($subjectsByTimeDay[$time][$day] as $subjName)
        <div class="bg-yellow-200 text-[#003a8c] px-4 py-2 rounded-lg shadow-sm font-semibold text-sm transition-all duration-200 transform hover:scale-[1.03] cursor-pointer border border-[#FFD700] w-full text-center min-h-[40px]">
            {{ $subjName }}
        </div>
    @endforeach
</div>

                                        @else
                                            <div class="flex items-center justify-center min-h-[40px]">
                                                <span class="text-gray-400 italic text-sm">—</span>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-12 flex justify-center">
                <button onclick="window.print()"
                    class="bg-[#003a8c] text-yellow-300 px-10 py-4 rounded-full font-bold shadow-xl hover:bg-yellow-300 hover:text-[#003a8c] transition duration-300 transform hover:scale-105 flex items-center gap-2">
                    Print / Save as PDF
                </button>
            </div>
        </div>
    </div>
</x-app-layout>