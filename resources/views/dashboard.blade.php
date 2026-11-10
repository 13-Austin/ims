<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Demographic Analytics & Report Generation Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Population -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Population</div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-2">--</div>
                    <div class="text-xs text-gray-500 mt-1">Recorded residents in Barangay Magsaysay</div>
                </div>

                <!-- Gender Breakdown -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Gender Breakdown</div>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-sm font-medium text-gray-700">Male: <strong class="text-blue-600">--</strong></span>
                        <span class="text-sm font-medium text-gray-700">Female: <strong class="text-pink-600">--</strong></span>
                    </div>
                </div>

                <!-- Senior Citizens -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Senior Citizens (60+ YRS)</div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-2">--</div>
                    <div class="text-xs text-gray-500 mt-1">Eligible for senior welfare & benefits</div>
                </div>
            </div>

            <!-- Age Bracket Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-xs font-semibold text-gray-500 uppercase">Minors (0-14 YRS)</div>
                    <div class="text-2xl font-bold text-gray-800 mt-1">--</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 border-2 border-blue-100 bg-blue-50/30">
                    <div class="text-xs font-semibold text-blue-600 uppercase">SK Age Bracket (15-30 YRS)</div>
                    <div class="text-2xl font-bold text-blue-900 mt-1">--</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-xs font-semibold text-gray-500 uppercase">Working Age (31-59 YRS)</div>
                    <div class="text-2xl font-bold text-gray-800 mt-1">--</div>
                </div>
            </div>

            <!-- Quick Navigation Modules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Sangguniang Kabataan & Barangay Modules</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('sk.dashboard') }}" class="p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition border">
                        <div class="font-semibold text-gray-800 text-sm">🌟 SK Dashboard</div>
                        <div class="text-xs text-gray-500 mt-1">Youth programs overview</div>
                    </a>
                    <a href="{{ route('sk.katipunan') }}" class="p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition border">
                        <div class="font-semibold text-gray-800 text-sm">📋 KK Registry</div>
                        <div class="text-xs text-gray-500 mt-1">15-30 years old list</div>
                    </a>
                    <a href="{{ route('sk.projects') }}" class="p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition border">
                        <div class="font-semibold text-gray-800 text-sm">🎯 SK Projects</div>
                        <div class="text-xs text-gray-500 mt-1">Youth initiatives</div>
                    </a>
                    <a href="{{ route('sk.budget') }}" class="p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition border">
                        <div class="font-semibold text-gray-800 text-sm">💰 SK Budget</div>
                        <div class="text-xs text-gray-500 mt-1">10% fund allocation</div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>