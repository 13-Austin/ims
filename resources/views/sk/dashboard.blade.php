<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌟 Sangguniang Kabataan (SK) Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- KK Members Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Katipunan ng Kabataan Members</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKKMembers ?? 0 }}</div>
                    <div class="text-xs text-gray-400 mt-1">Registered youth ages 15-30 years old</div>
                </div>

                <!-- SK Projects Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Active SK Projects</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProjects ?? 0 }}</div>
                    <div class="text-xs text-gray-400 mt-1">Total registered SK programs and projects</div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to the SK Management Module!</h3>
                <p class="text-sm text-gray-600">
                    Manage youth records, programs, and the Sangguniang Kabataan fund for Barangay Magsaysay professionally and independently. Use the sidebar navigation to switch between modules.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>