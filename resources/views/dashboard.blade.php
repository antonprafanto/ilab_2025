<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Beta Version Banner -->
            <div id="dashboard-beta-banner" class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 overflow-hidden shadow-lg sm:rounded-lg mb-6 transition-all duration-300">
                <!-- Full Banner Content -->
                <div id="dashboard-beta-content" class="p-6 relative transition-all duration-300">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-2">
                                🚀 Platform dalam Versi Beta
                            </h3>
                            <p class="text-white/90 text-sm mb-3">
                                Sistem iLab UNMUL saat ini dalam tahap pengembangan aktif (Fase 3). Beberapa fitur masih dalam proses penyelesaian dan akan tersedia segera.
                            </p>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                <p class="text-white text-xs font-semibold mb-2">✅ Fitur yang Sudah Tersedia:</p>
                                <ul class="text-white/90 text-xs space-y-1 ml-4 list-disc">
                                    <li>Registrasi & Login dengan Sistem Approval</li>
                                    <li>Manajemen Laboratorium, Equipment, dan Service Catalog</li>
                                    <li>User Management untuk Admin</li>
                                </ul>
                                <p class="text-white text-xs font-semibold mt-3 mb-2">🔨 Dalam Pengembangan:</p>
                                <ul class="text-white/90 text-xs space-y-1 ml-4 list-disc">
                                    <li>Booking System (Equipment Reservation)</li>
                                    <li>Service Request & Analysis</li>
                                    <li>SOP Management, Maintenance Scheduling, dan Reports</li>
                                </ul>
                            </div>
                            <p class="text-white/80 text-xs mt-3 italic">
                                💡 Fitur baru akan ditambahkan secara bertahap setiap minggu. Terima kasih atas kesabaran Anda!
                            </p>
                        </div>
                        <!-- Toggle Button -->
                        <button onclick="toggleDashboardBetaBanner()" class="flex-shrink-0 text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Minimized State -->
                <div id="dashboard-beta-minimized" class="hidden p-3 cursor-pointer" onclick="toggleDashboardBetaBanner()">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-bold text-white">🚀 Platform dalam Versi Beta - Klik untuk detail</p>
                        </div>
                        <button class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Welcome Card with Avatar -->
            <div class="bg-gradient-to-r from-[--color-unmul-blue] to-[--color-tropical-green] overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-8 text-white">
                    <div class="flex items-center space-x-4">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-20 w-20 rounded-full ring-4 ring-white shadow-lg">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ auth()->user()->full_name }}!</h3>
                            <p class="text-sm text-white/90">
                                Role: <span class="font-semibold bg-white/20 px-3 py-1 rounded-full">{{ auth()->user()->getRoleNames()->first() }}</span>
                            </p>
                            <p class="text-xs text-white/80 mt-1">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards (Role-specific) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                @can('view-all-requests')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Requests</p>
                                <p class="text-3xl font-bold text-[--color-unmul-blue] mt-1">0</p>
                            </div>
                            <div class="bg-[--color-unmul-blue]/10 p-3 rounded-full">
                                <svg class="w-8 h-8 text-[--color-unmul-blue]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('view-own-requests')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Requests</p>
                                <p class="text-3xl font-bold text-[--color-tropical-green] mt-1">0</p>
                            </div>
                            <div class="bg-[--color-tropical-green]/10 p-3 rounded-full">
                                <svg class="w-8 h-8 text-[--color-tropical-green]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('view-equipment')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Equipment Available</p>
                                <p class="text-3xl font-bold text-[--color-sunset-orange] mt-1">0</p>
                            </div>
                            <div class="bg-[--color-sunset-orange]/10 p-3 rounded-full">
                                <svg class="w-8 h-8 text-[--color-sunset-orange]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Tasks</p>
                                <p class="text-3xl font-bold text-[--color-vibrant-red] mt-1">0</p>
                            </div>
                            <div class="bg-[--color-vibrant-red]/10 p-3 rounded-full">
                                <svg class="w-8 h-8 text-[--color-vibrant-red]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold mb-4 text-lg">Your Permissions</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                        @forelse(auth()->user()->getAllPermissions() as $permission)
                            <div class="bg-gradient-to-r from-[--color-unmul-blue]/10 to-[--color-tropical-green]/10 border border-[--color-unmul-blue]/20 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $permission->name }}
                            </div>
                        @empty
                            <p class="text-gray-500">No permissions assigned</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Links based on permissions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @can('view-equipment')
                <a href="{{ route('equipment.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg transition border-l-4 border-[--color-unmul-blue]">
                    <div class="flex items-center space-x-3">
                        <div class="bg-[--color-unmul-blue]/10 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-[--color-unmul-blue]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-lg text-gray-900 dark:text-white">Equipment Management</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">View and manage laboratory equipment</p>
                        </div>
                    </div>
                </a>
                @endcan

                @can('view-users')
                <a href="{{ route('users.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg transition border-l-4 border-[--color-sunset-orange]">
                    <div class="flex items-center space-x-3">
                        <div class="bg-[--color-sunset-orange]/10 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-[--color-sunset-orange]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-lg text-gray-900 dark:text-white">User Management</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Manage system users</p>
                        </div>
                    </div>
                </a>
                @endcan

                @can('create-requests')
                <a href="#" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg transition border-l-4 border-[--color-tropical-green]">
                    <div class="flex items-center space-x-3">
                        <div class="bg-[--color-tropical-green]/10 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-[--color-tropical-green]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="font-semibold text-lg text-gray-900 dark:text-white">Create Service Request</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Submit new testing/analysis request</p>
                        </div>
                    </div>
                </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
