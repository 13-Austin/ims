<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Official Document Requests & Issuance') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: null, activeReq: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Document Requests Monitoring</h3>
                    <a href="{{ route('documents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        + New Document Request
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resident Profile</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $req)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-3">
                                        @if($req->resident && $req->resident->photo)
                                            <img src="{{ asset('storage/' . $req->resident->photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                                {{ substr($req->resident->first_name ?? 'R', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $req->resident->first_name ?? '' }} {{ $req->resident->last_name ?? '' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                Purok: {{ $req->resident->purok_sitio ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                        {{ $req->document_type }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                        {{ $req->purpose }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $req->status == 'Approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $req->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $req->status == 'Released' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $req->status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $req->status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $req->processor->name ?? 'Unassigned' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                                        
                                        <!-- 1. VIEW / PRINT: Kung si Staff ang naka-login, kailangang Approved na bago makapag-print -->
                                        @if(auth()->user()->role !== 'Staff' || $req->status == 'Approved' || $req->status == 'Released')
                                            <a href="{{ route('documents.show', $req->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold">
                                                View / Print
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs cursor-not-allowed" title="Hindi maaring i-print hangga't hindi aprubado">
                                                Print (Locked)
                                            </span>
                                        @endif
                                        
                                        <!-- 2. MANAGE APPROVAL BUTTON: Makikita lang ng Kap at Admin. Si Staff ay WALA nito. -->
                                        @if(auth()->user()->role !== 'Staff')
                                            <button @click="openModal = {{ $req->id }}" type="button" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md shadow">
                                                Manage Approval
                                            </button>
                                        @endif

                                        <!-- Delete Action Button -->
                                        @if(auth()->user()->role !== 'Staff')
                                            <form action="{{ route('documents.destroy', $req->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('Are you sure you want to delete this document request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- MODAL: Para lang kay Kap at Admin (Hindi kay Staff) -->
                                @if(auth()->user()->role !== 'Staff')
                                <div x-show="openModal === {{ $req->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6" @click.away="openModal = null">
                                        <div class="flex justify-between items-center pb-3 border-b mb-4">
                                            <h5 class="text-lg font-bold text-gray-800">Approval & Signatory Details</h5>
                                            <button @click="openModal = null" class="text-gray-500 hover:text-gray-700 font-bold">&times;</button>
                                        </div>

                                        <form action="{{ route('documents.status', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                                    <option value="Pending" {{ $req->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Approved" {{ $req->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="Released" {{ $req->status == 'Released' ? 'selected' : '' }}>Released</option>
                                                    <option value="Rejected" {{ $req->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Authorized Signatory Name</label>
                                                <input type="text" name="signatory_name" class="w-full border-gray-300 rounded-md shadow-sm text-sm" 
                                                       value="{{ $req->signatory_name ?? 'HON. ALOHA CUA-BAUTISTA' }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Signatory Title / Designee Role</label>
                                                <select name="signatory_title" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                                    <option value="Punong Barangay" {{ $req->signatory_title == 'Punong Barangay' ? 'selected' : '' }}>Punong Barangay</option>
                                                    <option value="Barangay Kagawad / Officer-on-Duty" {{ $req->signatory_title == 'Barangay Kagawad / Officer-on-Duty' ? 'selected' : '' }}>Barangay Kagawad / Officer-on-Duty</option>
                                                    <option value="Barangay Secretary" {{ $req->signatory_title == 'Barangay Secretary' ? 'selected' : '' }}>Barangay Secretary (By Authority)</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Dry Seal Tracking No.</label>
                                                <input type="text" name="dry_seal_number" class="w-full border-gray-300 rounded-md shadow-sm text-sm" 
                                                       value="{{ $req->dry_seal_number ?? 'DS-' . date('Y') . '-' . str_pad((\App\Models\Document::max('id') + 1), 3, '0', STR_PAD_LEFT) }}" placeholder="e.g. DS-2026-001">
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="openModal = null" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm">Cancel</button>
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">Save & Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No document requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>