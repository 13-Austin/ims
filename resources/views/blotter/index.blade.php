<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katarungang Pambarangay (Blotter & Case Management)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: null, activeCase: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Barangay Blotter Records</h3>
                    <a href="{{ route('blotter.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        + New Blotter Complaint
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complainant vs Respondent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location & Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hearing Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($cases as $case)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $case->case_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <div class="font-semibold">{{ $case->complainant_name }}</div>
                                        <div class="text-xs text-gray-500">vs. {{ $case->respondent_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div>{{ $case->incident_location }}</div>
                                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($case->incident_date)->format('M d, Y h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $case->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $case->status == 'Summoned' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $case->status == 'Settled' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $case->status == 'Dismissed' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $case->status == 'Filed in Court' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $case->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $case->hearing_date ? \Carbon\Carbon::parse($case->hearing_date)->format('M d, Y') : 'Not Set' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                                        <button @click="openModal = {{ $case->id }}" type="button" class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md shadow">
                                            Manage Hearing / Status
                                        </button>

                                        @if(auth()->user()->role !== 'Staff')
                                            <form action="{{ route('blotter.destroy', $case->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('Are you sure you want to delete this case?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- MODAL PARA SA CASE STATUS & HEARING -->
                                <div x-show="openModal === {{ $case->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6" @click.away="openModal = null">
                                        <div class="flex justify-between items-center pb-3 border-b mb-4">
                                            <h5 class="text-lg font-bold text-gray-800">Manage Case: {{ $case->case_number }}</h5>
                                            <button @click="openModal = null" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                                        </div>

                                        <form action="{{ route('blotter.update', $case->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Case Status</label>
                                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                                    <option value="Pending" {{ $case->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Summoned" {{ $case->status == 'Summoned' ? 'selected' : '' }}>Summoned / Hearing Scheduled</option>
                                                    <option value="Settled" {{ $case->status == 'Settled' ? 'selected' : '' }}>Settled (Amicable Settlement)</option>
                                                    <option value="Dismissed" {{ $case->status == 'Dismissed' ? 'selected' : '' }}>Dismissed</option>
                                                    <option value="Filed in Court" {{ $case->status == 'Filed in Court' ? 'selected' : '' }}>Filed in Court</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Next Hearing Date</label>
                                                <input type="date" name="hearing_date" value="{{ $case->hearing_date }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </div>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Amicable Settlement / Agreement Details</label>
                                                <textarea name="agreement_details" rows="3" class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="Ilagay ang detalye ng napagkasunduan kung nagkasundo na...">{{ $case->agreement_details }}</textarea>
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="openModal = null" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm">Cancel</button>
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No blotter records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $cases->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>