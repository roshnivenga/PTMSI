<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-[#003a8c] font-serif tracking-tight">
                <i class="fas fa-chalkboard-teacher mr-2"></i>Manage Tutors
            </h2>
        </div>
    </x-slot>

    <div class="mt-16 py-8 px-4 sm:px-6 lg:px-8 font-serif ptmsi-margin mt-24">
        <div class="bg-gradient-to-b from-yellow-50 via-blue-100 to-blue-200 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-10">
               <form method="GET" action="{{ route('admin.index.tutors') }}" class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">

                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#003a8c]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Search tutors...">
                    </div>

                    <div class="flex space-x-2">
                        <select name="sort" class="border-gray-300 rounded-lg text-sm focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Sort by</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Phone</th>
                                <th class="px-10 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tutors as $index => $tutor)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index + $tutors->firstItem() }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tutor->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tutor->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tutor->phone }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-right"> 
                                        <a href="{{ route('admin.view-tutors', $tutor->id) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-[#003a8c] hover:bg-yellow-300 hover:text-[#003a8c] transition-colors group">
                                            <i class="fas fa-users mr-1 group-hover:text-[#003a8c]"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">
                                        <div class="p-8 text-center">
                                            <i class="fas fa-user-times text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-gray-500 text-lg">No tutors found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $tutors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>