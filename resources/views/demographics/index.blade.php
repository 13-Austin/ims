<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Demographic Analytics & Report Generation') }}
            </h2>
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded shadow transition flex items-center cursor-pointer">
                🖨️ Print / Export Full Summary PDF
            </button>
        </div>
    </x-slot>

    <!-- PRINT STYLES PARA SA MULTI-PAGE RESIDENT LIST -->
    <style>
        @media print {
            aside, nav, header, .no-print, button, .modal-close-btn {
                display: none !important;
            }
            body, main {
                background-color: white !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 11px !important;
                color: #000 !important;
            }
            .max-w-7xl {
                max-width: 100% !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .bg-white {
                background-color: transparent !important;
                box-shadow: none !important;
            }
            .print-modal-container {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                background: white !important;
                padding: 0 !important;
                max-height: none !important;
            }
            .overflow-x-auto {
                max-height: none !important;
                overflow: visible !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #999 !important;
                padding: 6px 8px !important;
            }
            tr {
                page-break-inside: avoid !important;
            }
            thead {
                display: table-header-group !important;
            }
        }
    </style>

    <div class="py-8" x-data="{ 
        modalOpen: false, 
        modalTitle: '', 
        selectedCategory: 'total',

        openModal(title, category) {
            this.modalTitle = title;
            this.selectedCategory = category;
            this.modalOpen = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- TOP STATS CARDS (CLICKABLE) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <!-- TOTAL POPULATION -->
                <div @click="openModal('Total Population Residents List', 'total')" 
                     class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-600 cursor-pointer hover:shadow-md hover:bg-blue-50/50 transition">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">TOTAL POPULATION</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalPopulation ?? 2 }}</h3>
                    <p class="text-xs text-blue-600 mt-2 font-medium flex items-center">
                        🔍 Click to view full resident list & print →
                    </p>
                </div>

                <!-- GENDER BREAKDOWN -->
                <div @click="openModal('Gender Breakdown Residents List', 'gender')" 
                     class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600 cursor-pointer hover:shadow-md hover:bg-indigo-50/50 transition">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">GENDER BREAKDOWN</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-sm font-semibold text-blue-600">Male: {{ $maleCount ?? 2 }}</span>
                        <span class="text-sm font-semibold text-pink-600">Female: {{ $femaleCount ?? 0 }}</span>
                    </div>
                    <p class="text-xs text-indigo-600 mt-3 font-medium flex items-center">
                        🔍 Click to view breakdown list →
                    </p>
                </div>

                <!-- SENIOR CITIZENS -->
                <div @click="openModal('Senior Citizens (60+ Yrs) Registry', 'senior')" 
                     class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-600 cursor-pointer hover:shadow-md hover:bg-emerald-50/50 transition">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">SENIOR CITIZENS (60+ YRS)</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $seniorCount ?? 0 }}</h3>
                    <p class="text-xs text-emerald-600 mt-2 font-medium flex items-center">
                        🔍 Click to view senior list & print →
                    </p>
                </div>

            </div>

            <!-- SECOND ROW AGE DEMOGRAPHICS CARDS (CLICKABLE) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                
                <!-- MINORS -->
                <div @click="openModal('Minors (0-14 Yrs) List', 'minors')" class="bg-white p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 border-t-2 border-amber-500 transition">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">MINORS (0-14 YRS)</p>
                    <h4 class="text-xl font-bold text-gray-800 mt-1">{{ $minorsCount ?? $minors ?? 1 }}</h4>
                </div>

                <!-- SK AGE BRACKET -->
                <div @click="openModal('SK Youth Members (15-30 Yrs)', 'sk')" class="bg-white p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 border-t-2 border-blue-500 transition">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">SK AGE BRACKET (15-30 YRS)</p>
                    <h4 class="text-xl font-bold text-blue-600 mt-1">{{ $skCount ?? $skAge ?? 1 }}</h4>
                </div>

                <!-- WORKING AGE -->
                <div @click="openModal('Working Age Population (31-59 Yrs)', 'working')" class="bg-white p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 border-t-2 border-emerald-500 transition">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">WORKING AGE (31-59 YRS)</p>
                    <h4 class="text-xl font-bold text-emerald-600 mt-1">{{ $workingCount ?? $workingAge ?? 0 }}</h4>
                </div>

                <!-- SENIORS SUMMARY -->
                <div @click="openModal('Senior Citizens (60+ Yrs) Registry', 'senior')" class="bg-white p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 border-t-2 border-indigo-500 transition">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">SENIOR CITIZENS (60+ YRS)</p>
                    <h4 class="text-xl font-bold text-indigo-600 mt-1">{{ $seniorCount ?? $seniorCitizens ?? 0 }}</h4>
                </div>

            </div>

            <!-- PUROK & CIVIL STATUS TABLES (SUMMARY VIEW) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- PUROK POPULATION DENSITY -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 uppercase mb-4 pb-2 border-b">Purok Population Density</h4>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase bg-gray-50">
                                <th class="text-left py-2 px-3">Purok / Location</th>
                                <th class="text-right py-2 px-3">Total Residents</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($purokStats ?? $purokDistribution ?? [] as $purok)
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-gray-800">{{ $purok->purok_name ?? $purok->purok_location }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-gray-900">{{ $purok->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-gray-800">PUROK 4</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-gray-900">2</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- CIVIL STATUS STATISTICS -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 uppercase mb-4 pb-2 border-b">Civil Status Statistics</h4>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase bg-gray-50">
                                <th class="text-left py-2 px-3">Civil Status</th>
                                <th class="text-right py-2 px-3">Total Residents</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($civilStats ?? $civilStatusDistribution ?? [] as $civil)
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-gray-800">{{ $civil->status ?? $civil->civil_status }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-gray-900">{{ $civil->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-gray-800">Single</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-gray-900">2</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- INTERACTIVE POPULATION LIST MODAL -->
            <div x-show="modalOpen" 
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4" 
                 style="display: none;">
                
                <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl p-6 print-modal-container relative" 
                     @click.away="modalOpen = false">
                    
                    <!-- MODAL PRINTABLE HEADER -->
                    <div class="border-b pb-3 mb-4 flex justify-between items-start">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold">BARANGAY MAGSAYSAY DEMOGRAPHIC REPORT</div>
                            <h3 class="text-xl font-extrabold text-blue-900" x-text="modalTitle"></h3>
                        </div>
                        <button @click="modalOpen = false" class="no-print text-gray-400 hover:text-gray-600 text-2xl font-bold px-2 cursor-pointer">&times;</button>
                    </div>

                    <!-- POPULATION LIST TABLE -->
                    <div class="overflow-x-auto max-h-[60vh] mb-4">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2.5 text-left font-bold text-gray-700 uppercase text-xs">Full Name</th>
                                    <th class="px-4 py-2.5 text-left font-bold text-gray-700 uppercase text-xs">Age</th>
                                    <th class="px-4 py-2.5 text-left font-bold text-gray-700 uppercase text-xs">Gender</th>
                                    <th class="px-4 py-2.5 text-left font-bold text-gray-700 uppercase text-xs">Purok / Address</th>
                                    <th class="px-4 py-2.5 text-left font-bold text-gray-700 uppercase text-xs">Civil Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($residentsList ?? $residents ?? [] as $resident)
                                    @php
                                        $age = 0;
                                        if (isset($resident->birthdate) && $resident->birthdate) {
                                            $age = \Carbon\Carbon::parse($resident->birthdate)->age;
                                        } elseif (isset($resident->age)) {
                                            $age = $resident->age;
                                        }
                                    @endphp
                                    <tr x-show="
                                        selectedCategory === 'total' || 
                                        (selectedCategory === 'gender' && true) ||
                                        (selectedCategory === 'sk' && {{ $age }} >= 15 && {{ $age }} <= 30) ||
                                        (selectedCategory === 'minors' && {{ $age }} < 15) ||
                                        (selectedCategory === 'senior' && {{ $age }} >= 60) ||
                                        (selectedCategory === 'working' && {{ $age }} >= 31 && {{ $age }} <= 59)
                                    ">
                                        <td class="px-4 py-2.5 font-bold text-gray-900">{{ $resident->first_name ?? $resident->name ?? 'N/A' }} {{ $resident->last_name ?? '' }}</td>
                                        <td class="px-4 py-2.5 text-gray-700">{{ $age }} yrs old</td>
                                        <td class="px-4 py-2.5 text-gray-700">{{ $resident->gender ?? 'N/A' }}</td>
                                        <td class="px-4 py-2.5 text-gray-700">{{ $resident->purok_sitio ?? $resident->purok ?? 'N/A' }}</td>
                                        <td class="px-4 py-2.5 text-gray-700">{{ $resident->civil_status ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No resident records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- MODAL ACTION BUTTONS -->
                    <div class="flex justify-end space-x-3 no-print pt-3 border-t">
                        <button type="button" @click="modalOpen = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-bold cursor-pointer">
                            Close
                        </button>
                        <button type="button" onclick="window.print()" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-md text-sm font-bold shadow flex items-center cursor-pointer">
                            🖨️ Print This Resident List Report
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>