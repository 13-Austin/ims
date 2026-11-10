<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Brgy. Magsaysay</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        
        <!-- SIDEBAR SA KALIWA (Laging nakikita para sa Desktop/Laptop) -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col justify-between shadow-md flex-shrink-0">
            <div>
                <!-- Logo / Title -->
                <div class="h-16 flex items-center px-6 bg-gray-800 border-b border-gray-700">
                    <span class="text-lg font-bold tracking-wider">Brgy. Magsaysay</span>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        📊 Dashboard
                    </a>
                    
                    <a href="{{ route('residents.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('residents.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        👥 Resident Directory
                    </a>
                    
                    <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('projects.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        🏗️ Projects & Budget
                    </a>

                    <!-- Blotter / Cases Module Link -->
                    <a href="{{ route('blotter.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('blotter.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        ⚖️ Blotter / Cases
                    </a>

                    <a href="{{ route('demographics.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('demographics.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        📈 Demographic Analytics
                    </a>

                    <!-- Document Requests Module Link -->
                    <a href="{{ route('documents.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('documents.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        📄 Document Requests
                    </a>

                    <!-- SANGGUNIANG KABATAAN (SK) SECTION -->
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sangguniang Kabataan</p>
                    </div>

                    <a href="{{ route('sk.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('sk.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        🌟 SK Dashboard
                    </a>

                    <a href="{{ route('sk.katipunan') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('sk.katipunan*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        📋 KK Registry
                    </a>

                    <a href="{{ route('sk.projects') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('sk.projects*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        🎯 SK Projects
                    </a>

                    <a href="{{ route('sk.budget') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('sk.budget*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        💰 SK Budget (10%)
                    </a>
                </nav>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    👤 User Management
                </a>
            </div>

            <!-- User Profile & Logout sa ibaba ng Sidebar -->
            <div class="p-4 bg-gray-800 border-t border-gray-700">
                <div class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-400 truncate mb-3">{{ Auth::user()->email }}</div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-2 px-3 rounded transition text-center">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT SA KANAN -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-6">
                <!-- Profile greeting / Quick profile link -->
                <div class="text-sm text-gray-600">
                    Welcome back, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">⚙️ Profile Settings</a>
                </div>
            </header>

            <!-- Page Heading kung mayroon -->
            @isset($header)
                <div class="bg-white shadow px-6 py-4 border-b border-gray-200">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>