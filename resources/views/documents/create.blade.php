<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Document Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Create Official Document Request</h3>
                </div>

                <form action="{{ route('documents.store') }}" method="POST">
                    @csrf

                    <!-- SEARCHABLE RESIDENT INPUT -->
                    <div class="mb-4">
                        <label for="resident_search" class="block text-sm font-medium text-gray-700">Search & Select Resident</label>
                        
                        <!-- Input field with search autocomplete -->
                        <input type="text" id="resident_search" list="residents_list" placeholder="Type last name or first name..." required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        
                        <!-- Dropdown list options while typing -->
                        <datalist id="residents_list">
                            @foreach($residents as $resident)
                                <option value="{{ $resident->last_name }}, {{ $resident->first_name }} (Purok: {{ $resident->purok_sitio ?? 'N/A' }})" data-id="{{ $resident->id }}">
                            @endforeach
                        </datalist>

                        <!-- Hidden input to save the actual resident_id to the database -->
                        <input type="hidden" name="resident_id" id="resident_id">
                    </div>

                    <div class="mb-4">
                        <label for="document_type" class="block text-sm font-medium text-gray-700">Document Type</label>
                        <select name="document_type" id="document_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Select Document Type --</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Certificate of Indigency">Certificate of Indigency</option>
                            <option value="Certificate of Residency">Certificate of Residency</option>
                            <option value="Business Clearance">Business Clearance</option>
                            <option value="Other Certification">Other Certification</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                        <textarea name="purpose" id="purpose" rows="3" required placeholder="e.g., Employment, Financial Assistance" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('documents.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Submit Request
                        </button>
                    </div>
                </form>

                <!-- JavaScript to automatically capture the resident ID upon selection -->
                <script>
                    document.getElementById('resident_search').addEventListener('input', function(e) {
                        let value = e.target.value;
                        let options = document.getElementById('residents_list').options;
                        let hiddenInput = document.getElementById('resident_id');
                        
                        hiddenInput.value = ""; // Clear first
                        
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].value === value) {
                                // Find resident ID from the database loop above
                                @foreach($residents as $resident)
                                    if(value === "{{ $resident->last_name }}, {{ $resident->first_name }} (Purok: {{ $resident->purok_sitio ?? 'N/A' }})") {
                                        hiddenInput.value = "{{ $resident->id }}";
                                    }
                                @endforeach
                                break;
                            }
                        }
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>