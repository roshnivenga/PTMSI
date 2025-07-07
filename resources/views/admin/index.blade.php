<x-app-layout>
   

    <div class="mt-16 py-8 px-4 sm:px-6 lg:px-8 font-serif ptmsi-margin mt-24">
        <div class="bg-gradient-to-b from-yellow-50 via-blue-100 to-blue-200 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-10">
                <form method="GET" action="{{ route('admin.index') }}" class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#003a8c]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Search students...">
                    </div>

                    <div class="flex space-x-2">
                        <select name="level" class="border-gray-300 rounded-lg text-sm focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">All Levels</option>
                            <option value="primary" {{ request('level') == 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ request('level') == 'secondary' ? 'selected' : '' }}>Secondary</option>
                        </select>

                        <select name="payment" class="border-gray-300 rounded-lg text-sm focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">All Payments</option>
                            <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>

                       <select name="sort" class="border-gray-300 rounded-lg text-sm focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Sort by</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                            <option value="level" {{ request('sort') == 'level' ? 'selected' : '' }}>Sort by Level</option>
                            <option value="class" {{ request('sort') == 'class' ? 'selected' : '' }}>Sort by Class</option>
                        </select>


                        <button type="submit" class="px-4 py-2 bg-[#003a8c] text-yellow-300 rounded-lg hover:bg-[#002766] font-serif text-sm">Apply</button>
                    </div>
                </form>

                <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#003a8c] text-yellow-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Class</th>
                                <th class="px-10 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($students as $index => $student)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + $students->firstItem() }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $student->name }}</td>

                                    {{-- Payment Status --}}
                                    <td class="px-6 py-4 text-sm">
                                        @php
    $latestPayment = $student->latestPayment;
@endphp

                                        @if($latestPayment && $latestPayment->paymentStatus)
                                            <span class="inline-flex px-3 py-1 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-black-500">{{ ucfirst($student->level) ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-black-500">
    @php
        $level = strtolower($student->level ?? '');
    @endphp

    @if ($level === 'primary' && !empty($student->standard))
        {{ $student->standard }}
    @elseif ($level === 'secondary' && !empty($student->form))
        {{ $student->form }}
    @else
        -
    @endif
</td>



                                    <td class="px-8 py-4 whitespace-nowrap  text-right"> 
                                        <a href="{{ route('admin.view', $student->id) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-[#003a8c] hover:bg-yellow-300 hover:text-[#003a8c] transition-colors group"> <!-- Added hover effects -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 group-hover:text-[#003a8c]" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <!-- Added group-hover effect -->
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
